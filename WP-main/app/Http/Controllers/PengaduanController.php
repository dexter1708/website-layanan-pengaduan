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

class PengaduanController extends Controller
{
    public function index(){
        // dd();
        return view('pengaduan_staf_dinas.index');
    }
    // Menampilkan form pengaduan dan memilih kota
    public function create()
    {
        // dd(Pengaduan::all());
        $user = Auth::user();
        // dd($user);

        // Ambil riwayat pengaduan user (maksimal 5 terbaru)
        $riwayatPengaduan = Pengaduan::with(['korban', 'pelaku', 'historiTracking'])
            ->where('user_id', $user->id)
            ->orderBy('created_at', 'desc')
            ->take(5)
            ->get();

        // Ambil data kota untuk dropdown
        $kotas = Wilayah::select('kota_id', 'kota_nama')->distinct()->get();

        // Ambil data bentuk kekerasan dan pekerjaan
        $bentukKekerasan = BentukKekerasan::all();
        $pekerjaan = Pekerjaan::all();

        return view('pelapor.pengaduan', compact('kotas', 'bentukKekerasan', 'pekerjaan', 'riwayatPengaduan'));
    }

    // Menampilkan detail pengaduan
    public function show($id)
    {
        // $user = Auth::user();
        // $pengaduan = Pengaduan::with(['pelapor', 'korban', 'pelaku', 'historiTracking.changedByUser', 'user.alamat'])
        //     ->findOrFail($id);

        // // Pastikan user hanya bisa melihat pengaduan miliknya (jika role pelapor)
        // if ($user->role === 'pelapor' && $pengaduan->user_id !== $user->id) {
        //     abort(403, 'Unauthorized action.');
        // }

        // return view('pengaduan.show', compact('pengaduan'));

            // Data dummy sementara
            $data = [
                'id' => $id,
                'nama' => 'Aisyah Nanda',
                'tanggal' => '15 - 02 - 2025',
                'kecamatan' => 'Bojongsoang',
                'jenis' => 'Kekerasan terhadap perempuan',
                'bentuk' => 'Fisik',
                'status' => 'Diproses',
            ];

            return view('pengaduan_staf_dinas.show', compact('data'));

    }

    // Menampilkan riwayat pengaduan user
    public function riwayat(Request $request)
    {
        $user = Auth::user();

        $query = Pengaduan::with(['korban', 'pelaku', 'historiTracking'])
            ->where('user_id', $user->id)
            ->orderBy('created_at', 'desc');

        // Filter berdasarkan tanggal jika ada
        if ($request->filled('dari')) {
            $query->where('created_at', '>=', $request->dari);
        }

        if ($request->filled('sampai')) {
            $query->where('created_at', '<=', $request->sampai . ' 23:59:59');
        }

        $pengaduans = $query->get();

        return view('pelapor.riwayat', compact('pengaduans'));
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
            'korban.no_telepon' => 'required|string|regex:/^08[0-9]{8,11}$/',
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
            'korban.no_telepon.required' => 'No telepon korban harus diisi.',
            'korban.no_telepon.regex' => 'Format no telepon korban tidak valid.',
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
            $korban = $pengaduan->korban()->create($request->korban);

            // Create pelaku data
            $pelaku = $pengaduan->pelaku()->create($request->pelaku);

            DB::commit();
            return redirect()->route('pengaduan.show', $pengaduan->id)->with('success', 'Pengaduan berhasil diajukan! Silakan lihat detail pengaduan Anda di bawah ini.');

        } catch (\Exception $e) {
            DB::rollback();
            return redirect()->back()
                           ->withInput()
                           ->with('error', 'Terjadi kesalahan: ' . $e->getMessage());
        }
    }
}
