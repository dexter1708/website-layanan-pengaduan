<?php

namespace App\Http\Controllers;

use App\Models\Wilayah;
use App\Models\Pengaduan;
use App\Models\Pelapor;
use App\Models\BentukKekerasan;
use App\Models\Pekerjaan;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class PengaduanController extends Controller
{
    // Menampilkan form pengaduan dan memilih kota
    public function create()
    {
        // Ambil data kota untuk dropdown
        $kotas = Wilayah::select('kota_id', 'kota_nama')->distinct()->get();
        
        // Ambil data bentuk kekerasan dan pekerjaan
        $bentukKekerasan = BentukKekerasan::all();
        $pekerjaan = Pekerjaan::all();
        
        return view('pelapor.pengaduan', compact('kotas', 'bentukKekerasan', 'pekerjaan'));
    }
    
    // Menyimpan data pengaduan dan pelapor
    public function store(Request $request)
    {
        $rules = [
            // Data pengaduan
            'tempat_kejadian' => 'required|string|max:255',
            'kecamatan_kejadian' => 'required',
            'desa_kejadian' => 'required',
            'tanggal_kejadian' => 'required|date',
            'jenis_laporan' => 'required|string|max:255',
            'kronologi' => 'required|string',
            'jenis_kasus' => 'required|string|max:255',
            'bentuk_kekerasan' => 'required|string|max:255',

            // Data korban
            'korban.nama' => 'required|string|max:255',
            'korban.jenis_kelamin' => 'required|in:Laki-laki,Perempuan',
            'korban.disabilitas' => 'required|in:Ya,Tidak',
            'korban.usia' => 'required|integer|min:0',
            'korban.pendidikan' => 'required|in:Tidak Sekolah,SD,SMP,SMA,D3,S1,S2,S3',
            'korban.status_perkawinan' => 'required|in:Belum Kawin,Kawin,Cerai Hidup,Cerai Mati',
            'korban.pekerjaan' => 'required|exists:pekerjaan,pekerjaan',

            // Data pelaku
            'pelaku.nama' => 'required|string|max:255',
            'pelaku.jenis_kelamin' => 'required|in:Laki-laki,Perempuan',
            'pelaku.usia' => 'required|integer|min:0',
            'pelaku.pendidikan' => 'required|in:Tidak Sekolah,SD,SMP,SMA,D3,S1,S2,S3',
            'pelaku.hubungan' => 'required|in:Orang Tua,Saudara,Pasangan,Tetangga,Teman,Lainnya',
            'pelaku.kewarganegaraan' => 'required|in:WNI,WNA',
            'pelaku.pekerjaan' => 'required|exists:pekerjaan,pekerjaan',
        ];

        $messages = [
            // Pesan error untuk data pengaduan
            'tempat_kejadian.required' => 'Tempat kejadian harus diisi.',
            'kecamatan_kejadian.required' => 'Kecamatan kejadian harus dipilih.',
            'desa_kejadian.required' => 'Desa kejadian harus dipilih.',
            'tanggal_kejadian.required' => 'Tanggal kejadian harus diisi.',
            'tanggal_kejadian.date' => 'Format tanggal kejadian tidak valid.',
            'jenis_laporan.required' => 'Jenis laporan harus dipilih.',
            'kronologi.required' => 'Kronologi harus diisi.',
            'jenis_kasus.required' => 'Jenis kasus harus dipilih.',
            'bentuk_kekerasan.required' => 'Bentuk kekerasan harus dipilih.',

            // Pesan error untuk data korban
            'korban.nama.required' => 'Nama korban harus diisi.',
            'korban.jenis_kelamin.required' => 'Jenis kelamin korban harus dipilih.',
            'korban.disabilitas.required' => 'Status disabilitas korban harus dipilih.',
            'korban.usia.required' => 'Usia korban harus diisi.',
            'korban.usia.integer' => 'Usia korban harus berupa angka.',
            'korban.usia.min' => 'Usia korban tidak boleh kurang dari 0.',
            'korban.pendidikan.required' => 'Pendidikan korban harus dipilih.',
            'korban.status_perkawinan.required' => 'Status perkawinan korban harus dipilih.',
            'korban.pekerjaan.required' => 'Pekerjaan korban harus dipilih.',
            'korban.pekerjaan.exists' => 'Pekerjaan korban yang dipilih tidak valid.',

            // Pesan error untuk data pelaku
            'pelaku.nama.required' => 'Nama pelaku harus diisi.',
            'pelaku.jenis_kelamin.required' => 'Jenis kelamin pelaku harus dipilih.',
            'pelaku.usia.required' => 'Usia pelaku harus diisi.',
            'pelaku.usia.integer' => 'Usia pelaku harus berupa angka.',
            'pelaku.usia.min' => 'Usia pelaku tidak boleh kurang dari 0.',
            'pelaku.pendidikan.required' => 'Pendidikan pelaku harus dipilih.',
            'pelaku.hubungan.required' => 'Hubungan dengan korban harus dipilih.',
            'pelaku.kewarganegaraan.required' => 'Kewarganegaraan pelaku harus dipilih.',
            'pelaku.pekerjaan.required' => 'Pekerjaan pelaku harus dipilih.',
            'pelaku.pekerjaan.exists' => 'Pekerjaan pelaku yang dipilih tidak valid.',
        ];

        $request->validate($rules, $messages);

        // Validate and get the wilayah for kejadian
        $wilayahKejadian = Wilayah::where('kecamatan_id', $request->kecamatan_kejadian)
                                 ->where('desa_id', $request->desa_kejadian)
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
                'jenis_laporan' => $request->jenis_laporan,
                'kronologi' => $request->kronologi,
                'jenis_kasus' => $request->jenis_kasus,
                'bentuk_kekerasan' => $request->bentuk_kekerasan,
                'kecamatan' => $wilayahKejadian->kecamatan_nama,
                'desa' => $wilayahKejadian->desa_nama,
                'status' => 'menunggu',
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
            $korban = $pengaduan->korban()->create($request->korban);

            // Create pelaku data
            $pelaku = $pengaduan->pelaku()->create($request->pelaku);

            DB::commit();
            return redirect()->route('dashboard')->with('success', 'Pengaduan berhasil diajukan!');

        } catch (\Exception $e) {
            DB::rollback();
            return redirect()->back()
                           ->withInput()
                           ->with('error', 'Terjadi kesalahan: ' . $e->getMessage());
        }
    }
}
