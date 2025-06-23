<?php

namespace App\Http\Controllers;

use App\Models\Wilayah;
use App\Models\Pengaduan;
use App\Models\Pelapor;
use App\Models\HistoriTracking;
use App\Models\BentukKekerasan;
use App\Models\Pekerjaan;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use App\Models\Korban;
use App\Models\Pelaku;

class PengaduanController extends Controller
{
    public function index()
    {
        $user = Auth::user();

        if ($user->role === 'staff') {
            $pengaduans = Pengaduan::with(['korban'])
                ->orderBy('created_at', 'desc')
                ->get();
            return view('pengaduan_staf_dinas.index', compact('pengaduans'));
        }
        
        if ($user->role === 'pelapor') {
            $pengaduans = Pengaduan::with(['korban', 'historiTracking'])
                ->where('user_id', $user->id)
                ->orderBy('id', 'asc')
                ->get();
            return view('pengaduan.index', compact('pengaduans'));
        }

        abort(403, 'Anda tidak memiliki izin untuk mengakses halaman ini.');
    }

    // Menampilkan form pengaduan dan memilih kota
    public function create()
    {
        if (Auth::user()->role !== 'pelapor') {
            abort(403, 'Hanya pelapor yang dapat membuat pengaduan.');
        }
        $kecamatans = Wilayah::select('kecamatan_id', 'kecamatan_nama')
                             ->whereNotNull('kecamatan_nama')
                             ->groupBy('kecamatan_id', 'kecamatan_nama')
                             ->orderBy('kecamatan_nama')
                             ->get();
        $pekerjaan = Pekerjaan::all();
        
        return view('pengaduan.create', compact('kecamatans', 'pekerjaan'));
    }

    // Menampilkan detail pengaduan
    public function show($id)
    {
        $user = Auth::user();
        $pengaduan = Pengaduan::with(['pelapor', 'korban', 'historiTracking.changedByUser', 'user.alamat'])
            ->findOrFail($id);
            
        // Pastikan user hanya bisa melihat pengaduan miliknya (jika role pelapor)
        if ($user->role === 'pelapor' && $pengaduan->user_id !== $user->id) {
            abort(403, 'Unauthorized action.');
        }

        return view('pengaduan.show', compact('pengaduan'));
    }

    // Menampilkan riwayat pengaduan user (halaman utama pengaduan)
    public function riwayat()
    {
        if (Auth::user()->role !== 'pelapor') {
            abort(403, 'Hanya pelapor yang dapat melihat riwayat pengaduan.');
        }
        $user = Auth::user();

        $pengaduans = Pengaduan::with(['korban', 'historiTracking'])
            ->where('user_id', $user->id)
            ->orderBy('created_at', 'desc')
            ->get();

        return view('pengaduan.riwayat', compact('pengaduans'));
    }

    // Menyimpan data pengaduan dan pelapor
    public function store(Request $request)
    {
        if (Auth::user()->role !== 'pelapor') {
            abort(403, 'Hanya pelapor yang dapat mengajukan pengaduan.');
        }
        
        $rules = [
            // Data pengaduan
            'tempat_kejadian' => 'required|string|max:255',
            'kecamatan_kejadian' => 'required',
            'tanggal_kejadian' => 'required|date',
            'kronologi' => 'required|string',

            // Data korban
            'korban.nama' => 'required|string|max:255',
            'korban.jenis_kelamin' => 'required|in:Laki-laki,Perempuan',
            'korban.disabilitas' => 'required|in:Ya,Tidak',
            'korban.usia' => 'required|integer|min:0',
            'korban.no_telepon' => 'required|string|regex:/^08[0-9]{8,11}$/',
            'korban.pendidikan' => 'required|in:Tidak Sekolah,SD,SMP,SMA,D3,S1,S2,S3',
            'korban.status_perkawinan' => 'required|in:Belum Kawin,Kawin,Cerai Hidup,Cerai Mati',
            'korban.pekerjaan' => 'required|exists:pekerjaan,pekerjaan',
        ];

        $messages = [
            // Pesan error untuk data pengaduan
            'tempat_kejadian.required' => 'Tempat kejadian harus diisi.',
            'kecamatan_kejadian.required' => 'Kecamatan kejadian harus dipilih.',
            'tanggal_kejadian.required' => 'Tanggal kejadian harus diisi.',
            'tanggal_kejadian.date' => 'Format tanggal kejadian tidak valid.',
            'kronologi.required' => 'Kronologi harus diisi.',

            // Pesan error untuk data korban
            'korban.nama.required' => 'Nama korban harus diisi.',
            'korban.jenis_kelamin.required' => 'Jenis kelamin korban harus dipilih.',
            'korban.disabilitas.required' => 'Status disabilitas korban harus dipilih.',
            'korban.usia.required' => 'Usia korban harus diisi.',
            'korban.usia.integer' => 'Usia korban harus berupa angka.',
            'korban.usia.min' => 'Usia korban tidak boleh kurang dari 0.',
            'korban.no_telepon.required' => 'No telepon korban harus diisi.',
            'korban.no_telepon.regex' => 'Format no telepon korban tidak valid.',
            'korban.pendidikan.required' => 'Pendidikan korban harus dipilih.',
            'korban.status_perkawinan.required' => 'Status perkawinan korban harus dipilih.',
            'korban.pekerjaan.required' => 'Pekerjaan korban harus dipilih.',
            'korban.pekerjaan.exists' => 'Pekerjaan korban yang dipilih tidak valid.',
        ];

        $request->validate($rules, $messages);

        // Get kecamatan info
        $kecamatanInfo = Wilayah::where('kecamatan_id', $request->kecamatan_kejadian)
                                ->whereNotNull('kecamatan_nama')
                                ->firstOrFail();

        DB::beginTransaction();
        try {
            // Get authenticated user data
            $user = Auth::user();
            if (!$user->alamat) {
                throw new \Exception('Data alamat tidak ditemukan. Silakan lengkapi profil Anda terlebih dahulu.');
            }

            // Create pengaduan
            $pengaduan = Pengaduan::create([
                'user_id' => $user->id,
                'tempat_kejadian' => $request->tempat_kejadian,
                'tanggal_kejadian' => $request->tanggal_kejadian,
                'kronologi' => $request->kronologi,
                'kecamatan' => $kecamatanInfo->kecamatan_nama,
                'status' => 'menunggu',
            ]);

            // Simpan riwayat status awal
            HistoriTracking::create([
                'pengaduan_id' => $pengaduan->id,
                'status_sebelum' => null,
                'status_sesudah' => 'menunggu',
                'changed_by_user_id' => $user->id,
                'keterangan' => 'Pengaduan baru diajukan'
            ]);

            // Create pelapor data from user
            $pelapor = Pelapor::create([
                'pengaduan_id' => $pengaduan->id,
                'user_id' => $user->id,
                'nama_pelapor' => $user->name,
            ]);

            // Update user's address role to 'pelapor' for this pengaduan
            $user->alamat->update([
                'sebagai' => 'pelapor',
                'pengaduan_id' => $pengaduan->id
            ]);

            // Create korban data
            $korbanData = $request->korban;
            $korbanData['pengaduan_id'] = $pengaduan->id;
            Korban::create($korbanData);

            DB::commit();
            return redirect()->route('pengaduan.show', $pengaduan->id)->with('success', 'Pengaduan berhasil diajukan! Silakan lihat detail pengaduan Anda di bawah ini.');

        } catch (\Exception $e) {
            DB::rollback();
            return redirect()->back()
                           ->withInput()
                           ->with('error', 'Terjadi kesalahan: ' . $e->getMessage());
        }
    }

    public function destroy($id)
    {
        if (Auth::user()->role !== 'staff') {
            abort(403, 'Anda tidak memiliki izin untuk melakukan tindakan ini.');
        }

        $pengaduan = Pengaduan::findOrFail($id);
        $pengaduan->delete();

        return redirect()->route('pengaduan.index')->with('success', 'Pengaduan berhasil dihapus.');
    }
}
