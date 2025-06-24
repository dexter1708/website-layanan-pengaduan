<?php

namespace App\Http\Controllers;

use App\Models\Pendampingan;
use App\Models\Pengaduan;
use App\Models\Korban;
use App\Models\layanan;
use App\Models\instruktur;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Validation\Rule;
use Illuminate\Support\Facades\Log;

class PendampinganController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $user = Auth::user();

        if ($user->role === 'staff') {
            $pendampingans = Pendampingan::with(['pengaduan', 'korban'])->latest()->get();
            return view('staff.pendampingan.index', compact('pendampingans'));
        }
        
        // Untuk user biasa (pelapor), tampilkan pendampingan terkait pengaduan mereka
        $pendampingans = Pendampingan::whereHas('pengaduan', function ($query) use ($user) {
            $query->where('user_id', $user->id);
        })->with(['pengaduan', 'korban'])->latest()->get();
        
        return view('pendampingan.index', compact('pendampingans'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        // Hanya staff yang bisa membuat pendampingan
        if (Auth::user()->role !== 'staff') {
            abort(403, 'Anda tidak memiliki izin untuk mengakses halaman ini.');
        }

        $pengaduans = Pengaduan::with('korban')
        ->whereHas('korban')
        ->get();

        // Ambil hanya layanan dengan jenis_layanan = 'pendampingan'
        $layanans = layanan::where('jenis_layanan', 'pendampingan')->get();

        // Ambil semua instruktur untuk filtering berdasarkan jenis layanan
        $instrukturs = instruktur::all();

        return view('staff.pendampingan.create', compact('pengaduans', 'layanans', 'instrukturs'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        if (Auth::user()->role !== 'staff') {
            abort(403, 'Anda tidak memiliki izin untuk melakukan tindakan ini.');
        }

        // Ambil semua nama_layanan dari tabel layanan yang jenisnya pendampingan
        $layanans = layanan::where('jenis_layanan', 'pendampingan')->pluck('nama_layanan')->toArray();

        $request->validate([
            'pengaduan_id' => 'required|exists:pengaduan,id',
            'korban_id' => [
                'required',
                Rule::exists('korban', 'id')->where(function ($query) use ($request) {
                    return $query->where('pengaduan_id', $request->pengaduan_id);
                }),
            ],
            'nama_pendamping' => [
                'required',
                Rule::exists('instruktur', 'nama')->where(function ($query) use ($request) {
                    return $query->where('nama_layanan', $request->jenis_layanan);
                }),
            ],
            'tanggal_pendampingan' => 'required|date',
            'waktu_pendampingan' => 'required|date_format:H:i',
            'tempat_pendampingan' => 'required|string|max:255',
            'jenis_layanan' => 'required|in:' . implode(',', $layanans),
            'konfirmasi' => ['required', Rule::in([
                Pendampingan::STATUS_BUTUH_KONFIRMASI_STAFF,
                Pendampingan::STATUS_MENUNGGU_KONFIRMASI_USER,
                Pendampingan::STATUS_TERKONFIRMASI,
                Pendampingan::STATUS_DIBATALKAN
            ])],
        ], [
            'nama_pendamping.required' => 'Nama pendamping harus dipilih.',
            'nama_pendamping.exists' => 'Nama pendamping yang dipilih tidak valid untuk layanan ini. Silakan pilih pendamping yang sesuai dengan jenis layanan.',
            'jenis_layanan.required' => 'Jenis layanan harus dipilih.',
            'jenis_layanan.in' => 'Jenis layanan yang dipilih tidak valid.',
            'pengaduan_id.required' => 'Pengaduan harus dipilih.',
            'pengaduan_id.exists' => 'Pengaduan yang dipilih tidak ditemukan.',
            'korban_id.required' => 'Korban harus dipilih.',
            'korban_id.exists' => 'Korban yang dipilih tidak valid untuk pengaduan ini.',
            'tanggal_pendampingan.required' => 'Tanggal pendampingan harus diisi.',
            'tanggal_pendampingan.date' => 'Format tanggal pendampingan tidak valid.',
            'waktu_pendampingan.required' => 'Waktu pendampingan harus diisi.',
            'waktu_pendampingan.date_format' => 'Format waktu pendampingan tidak valid (gunakan format HH:MM).',
            'tempat_pendampingan.required' => 'Tempat pendampingan harus diisi.',
            'tempat_pendampingan.max' => 'Tempat pendampingan tidak boleh lebih dari 255 karakter.',
        ]);

        // Gabungkan tanggal dan waktu
        $tanggalWaktu = $request->tanggal_pendampingan . ' ' . $request->waktu_pendampingan;

        Pendampingan::create([
            'pengaduan_id' => $request->pengaduan_id,
            'korban_id' => $request->korban_id,
            'nama_pendamping' => $request->nama_pendamping,
            'tanggal_pendampingan' => $tanggalWaktu,
            'tempat_pendampingan' => $request->tempat_pendampingan,
            'jenis_layanan' => $request->jenis_layanan,
            'konfirmasi' => $request->konfirmasi,
        ]);

        return redirect()->route('staff.pendampingan.index')->with('success', 'Data Pendampingan berhasil ditambahkan.');
    }

    /**
     * Display the specified resource.
     */
    public function show($id)
    {
        $pendampingan = Pendampingan::with(['pengaduan', 'korban'])->findOrFail($id);

        // Pastikan hanya user yang berwenang yang bisa mengakses
        $user = Auth::user();
        if ($user->role !== 'staff' && $pendampingan->pengaduan->user_id !== $user->id) {
            abort(403, 'Anda tidak memiliki izin untuk mengakses halaman ini.');
        }

        return view('pendampingan.show', compact('pendampingan'));
    }

    public function showkonfirmasi($id)
    {
        $user = Auth::user();
        if (!$user) {
            return redirect()->route('login');
        }
        $pendampingan = Pendampingan::with(['pengaduan', 'korban'])->findOrFail($id);

        // Pastikan hanya user yang berwenang yang bisa mengakses
        if ($user->role !== 'staff' && $pendampingan->pengaduan->user_id !== $user->id) {
            abort(403, 'Anda tidak memiliki izin untuk mengakses halaman ini.');
        }

        return view('pendampingan_staff_dinas.konfirmasi', compact('pendampingan'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit($id)
    {
        if (Auth::user()->role !== 'staff') {
            abort(403, 'Anda tidak memiliki izin untuk mengakses halaman ini.');
        }

        $pendampingan = Pendampingan::with(['pengaduan', 'korban'])->findOrFail($id);
        
        $pengaduans = Pengaduan::with('korban')->get();
        $layanans = layanan::where('jenis_layanan', 'pendampingan')->get();
        $instrukturs = instruktur::all();

        return view('staff.pendampingan.edit', compact('pendampingan', 'pengaduans', 'layanans', 'instrukturs'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, $id)
    {
        if (Auth::user()->role !== 'staff') {
            abort(403, 'Anda tidak memiliki izin untuk melakukan tindakan ini.');
        }

        $pendampingan = Pendampingan::findOrFail($id);

        // Ambil semua nama_layanan dari tabel layanan yang jenisnya pendampingan
        $layanans = layanan::where('jenis_layanan', 'pendampingan')->pluck('nama_layanan')->toArray();

        $request->validate([
            'pengaduan_id' => 'required|exists:pengaduan,id',
            'korban_id' => [
                'required',
                Rule::exists('korban', 'id')->where(function ($query) use ($request) {
                    return $query->where('pengaduan_id', $request->pengaduan_id);
                }),
            ],
            'nama_pendamping' => [
                'required',
                Rule::exists('instruktur', 'nama')->where(function ($query) use ($request) {
                    return $query->where('nama_layanan', $request->jenis_layanan);
                }),
            ],
            'tanggal_pendampingan' => 'required|date',
            'waktu_pendampingan' => 'required|date_format:H:i',
            'tempat_pendampingan' => 'required|string|max:255',
            'jenis_layanan' => 'required|in:' . implode(',', $layanans),
            'konfirmasi' => ['required', Rule::in([
                Pendampingan::STATUS_BUTUH_KONFIRMASI_STAFF,
                Pendampingan::STATUS_MENUNGGU_KONFIRMASI_USER,
                Pendampingan::STATUS_TERKONFIRMASI,
                Pendampingan::STATUS_DIBATALKAN
            ])],
        ]);

        // Gabungkan tanggal dan waktu
        $tanggalWaktu = $request->tanggal_pendampingan . ' ' . $request->waktu_pendampingan;

        $pendampingan->update([
            'pengaduan_id' => $request->pengaduan_id,
            'korban_id' => $request->korban_id,
            'nama_pendamping' => $request->nama_pendamping,
            'tanggal_pendampingan' => $tanggalWaktu,
            'tempat_pendampingan' => $request->tempat_pendampingan,
            'jenis_layanan' => $request->jenis_layanan,
            'konfirmasi' => $request->konfirmasi,
        ]);

        return redirect()->route('staff.pendampingan.index')->with('success', 'Data Pendampingan berhasil diperbarui.');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy($id)
    {
        if (Auth::user()->role !== 'staff') {
            abort(403, 'Anda tidak memiliki izin untuk melakukan tindakan ini.');
        }

        $pendampingan = Pendampingan::findOrFail($id);
        $pendampingan->delete();

        return redirect()->route('staff.pendampingan.index')->with('success', 'Data Pendampingan berhasil dihapus.');
    }

    public function updateKonfirmasi(Request $request, $id)
    {
        $user = Auth::user();
        if (!$user) {
            return redirect()->route('login');
        }
        $pendampingan = Pendampingan::findOrFail($id);

        // Hanya user terkait yang bisa update, atau staff
        if ($user->role !== 'staff' && $pendampingan->pengaduan->user_id !== $user->id) {
            abort(403, 'Anda tidak memiliki izin untuk melakukan tindakan ini.');
        }

        $validated = $request->validate([
            'konfirmasi' => ['required', Rule::in([
                Pendampingan::STATUS_TERKONFIRMASI,
                Pendampingan::STATUS_DIBATALKAN,
            ])],
        ]);

        $pendampingan->update(['konfirmasi' => $validated['konfirmasi']]);

        return redirect()->back()->with('success', 'Status konfirmasi berhasil diperbarui.');
    }

    // --- USER/PELAPOR METHODS ---

    public function requestForm()
    {
        $user = Auth::user();
        
        // Ambil pengaduan milik user yang BELUM memiliki pendampingan
        $pengaduans = Pengaduan::where('user_id', $user->id)
                                ->whereDoesntHave('pendampingan')
                                ->with('korban')
                                ->get();
                                
        $layanans = layanan::where('jenis_layanan', 'pendampingan')->get();

        return view('pendampingan.request', compact('pengaduans', 'layanans'));
    }

    public function requestAccompaniment(Request $request)
    {
        $user = Auth::user();

        $validatedData = $request->validate([
            'pengaduan_id' => [
                'required',
                Rule::exists('pengaduan', 'id')->where('user_id', $user->id),
            ],
            'korban_id' => 'required|exists:korban,id',
            'jenis_layanan' => 'required|exists:layanan,nama_layanan',
            'tanggal_pendampingan' => 'required|date|after_or_equal:today',
            'waktu_pendampingan' => 'required|date_format:H:i',
            
        ]);
        
        // Gabungkan tanggal dan waktu
        $jadwal = $validatedData['tanggal_pendampingan'] . ' ' . $validatedData['waktu_pendampingan'];

        Pendampingan::create([
            'pengaduan_id' => $validatedData['pengaduan_id'],
            'korban_id' => $validatedData['korban_id'],
            'jenis_layanan' => $validatedData['jenis_layanan'],
            'tanggal_pendampingan' => $jadwal,
            'konfirmasi' => Pendampingan::STATUS_BUTUH_KONFIRMASI_STAFF, // Default status
        ]);

        return redirect()->route('pendampingan.index')->with('success', 'Permintaan pendampingan berhasil diajukan dan menunggu konfirmasi staff.');
    }
}
