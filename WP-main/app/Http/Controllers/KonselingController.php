<?php

namespace App\Http\Controllers;

use App\Models\Konseling;
use App\Models\Pengaduan;
use App\Models\Korban;
use App\Models\layanan;
use App\Models\instruktur;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Validation\Rule;

class KonselingController extends Controller
{
    public function index()
    {
        $user = Auth::user();

        if (!$user) {
            $konselings = collect();
            return view('konseling.index', compact('konselings'));
        }

        if ($user->role === 'staff') {
            $konselings = Konseling::with(['pengaduan', 'korban'])
                ->orderBy('jadwal_konseling', 'desc')
                ->get();
        } else {
            $konselings = Konseling::whereHas('pengaduan', function($query) use ($user) {
                $query->where('user_id', $user->id);
            })
            ->with(['pengaduan', 'korban'])
            ->orderBy('jadwal_konseling', 'desc')
            ->get();
        }

        return view('konseling.index', compact('konselings'));
    }

    public function create()
    {
        // Only staff can create counseling sessions
        if (Auth::user()->role !== 'staff') {
            abort(403, 'Unauthorized action.');
        }

        // Get all cases that might need counseling
        $pengaduans = Pengaduan::with(['korban' => function($query) {
            // Hanya ambil korban yang belum memiliki jadwal konseling
            $query->whereDoesntHave('konseling');
        }])
        ->whereHas('korban') // Hanya ambil pengaduan yang punya korban
        ->get();

        // Ambil hanya layanan dengan jenis_layanan = 'konseling'
        $layanans = layanan::where('jenis_layanan', 'konseling')->get();

        // Ambil semua instruktur untuk filtering berdasarkan jenis layanan
        $instrukturs = instruktur::all();

        return view('konseling.create', compact('pengaduans', 'layanans', 'instrukturs'));
    }

    public function store(Request $request)
    {
        // Only staff can create counseling sessions
        if (Auth::user()->role !== 'staff') {
            abort(403, 'Unauthorized action.');
        }

        // Ambil semua nama_layanan dari tabel layanan yang jenisnya konseling
        $layanans = layanan::where('jenis_layanan', 'konseling')->pluck('nama_layanan')->toArray();

        $validated = $request->validate([
            'pengaduan_id' => 'required|exists:pengaduan,id',
            'korban_id' => 'required|exists:korban,id',
            'nama_konselor' => [
                'required',
                Rule::exists('instruktur', 'nama')->where(function ($query) use ($request) {
                    return $query->where('nama_layanan', $request->jenis_layanan);
                }),
            ],
            'tanggal_konseling' => 'required|date',
            'waktu_konseling' => 'required|date_format:H:i',
            'tempat_konseling' => 'required|string|max:255',
            'jenis_layanan' => 'required|in:' . implode(',', $layanans),
        ], [
            'pengaduan_id.required' => 'Pengaduan harus dipilih',
            'pengaduan_id.exists' => 'Pengaduan tidak ditemukan',
            'korban_id.required' => 'Korban harus dipilih',
            'korban_id.exists' => 'Korban tidak ditemukan',
            'nama_konselor.required' => 'Nama konselor harus diisi',
            'nama_konselor.exists' => 'Nama konselor yang dipilih tidak valid untuk layanan ini. Silakan pilih konselor yang sesuai dengan jenis layanan.',
            'tanggal_konseling.required' => 'Tanggal konseling harus diisi',
            'tanggal_konseling.date' => 'Format tanggal konseling tidak valid',
            'waktu_konseling.required' => 'Waktu konseling harus diisi',
            'waktu_konseling.date_format' => 'Format waktu konseling tidak valid (gunakan format HH:MM)',
            'tempat_konseling.required' => 'Tempat konseling harus diisi',
            'jenis_layanan.required' => 'Jenis layanan harus dipilih',
        ]);

        $korban = Korban::findOrFail($request->korban_id);

        // Cek apakah korban sudah memiliki konseling
        $existingKonseling = Konseling::where('korban_id', $request->korban_id)->first();
        if ($existingKonseling) {
            return back()
                ->withInput()
                ->withErrors(['korban_id' => 'Korban ini sudah memiliki jadwal konseling']);
        }

        // Gabungkan tanggal dan waktu
        $jadwalKonseling = $request->tanggal_konseling . ' ' . $request->waktu_konseling;

        Konseling::create([
            'pengaduan_id' => $request->pengaduan_id,
            'korban_id' => $request->korban_id,
            'nama_korban' => $korban->nama,
            'nama_konselor' => $request->nama_konselor,
            'jadwal_konseling' => $jadwalKonseling,
            'tempat_konseling' => $request->tempat_konseling,
            'jenis_layanan' => $request->jenis_layanan,
            'konfirmasi' => 'menunggu'
        ]);

        return redirect()->route('konseling.index')
            ->with('success', 'Jadwal konseling berhasil dibuat.');
    }

    public function show($id)
    {
        // $konseling = Konseling::with(['pengaduan', 'korban'])->findOrFail($id);

        // // Check if user has permission to view this counseling session
        // $user = Auth::user();
        // if ($user->role !== 'staff' && $konseling->pengaduan->user_id !== $user->id) {
        //     abort(403, 'Unauthorized action.');
        // }

        // // Ambil semua instruktur untuk filtering berdasarkan jenis layanan
        // $instrukturs = instruktur::all();

        // return view('konseling.show', compact('konseling', 'instrukturs'));
        return view('konseling.show');
    }
    public function showkonfirmasi($id)
    {
        return view('konseling.konfirmasi');
    }

    public function edit($id)
    {
        // Only staff can edit counseling sessions
        if (Auth::user()->role !== 'staff') {
            abort(403, 'Unauthorized action.');
        }

        $konseling = Konseling::with(['pengaduan', 'korban'])->findOrFail($id);
        $pengaduans = Pengaduan::with('korban')->get(); // Mungkin perlu disaring

        // Ambil hanya layanan dengan jenis_layanan = 'konseling'
        $layanans = layanan::where('jenis_layanan', 'konseling')->get();

        // Ambil semua instruktur untuk filtering berdasarkan jenis layanan
        $instrukturs = instruktur::all();

        return view('konseling.edit', compact('konseling', 'pengaduans', 'layanans', 'instrukturs'));
    }

    public function update(Request $request, $id)
    {
        // Only staff can update counseling sessions
        if (Auth::user()->role !== 'staff') {
            abort(403, 'Unauthorized action.');
        }

        // Ambil semua nama_layanan dari tabel layanan yang jenisnya konseling
        $layanans = layanan::where('jenis_layanan', 'konseling')->pluck('nama_layanan')->toArray();

        // Validasi data yang masuk
        $validated = $request->validate([
            'pengaduan_id' => 'required|exists:pengaduan,id',
            'korban_id' => 'required|exists:korban,id',
            'nama_konselor' => [
                'required',
                Rule::exists('instruktur', 'nama')->where(function ($query) use ($request) {
                    return $query->where('nama_layanan', $request->jenis_layanan);
                }),
            ],
            'tanggal_konseling' => 'required|date',
            'waktu_konseling' => 'required|date_format:H:i',
            'tempat_konseling' => 'required|string|max:255',
            'jenis_layanan' => 'required|in:' . implode(',', $layanans),
            'konfirmasi' => 'nullable|in:butuh_konfirmasi_staff,menunggu_konfirmasi_user,setuju,tolak',
        ], [
            'pengaduan_id.required' => 'Pengaduan harus dipilih',
            'pengaduan_id.exists' => 'Pengaduan tidak ditemukan',
            'korban_id.required' => 'Korban harus dipilih',
            'korban_id.exists' => 'Korban tidak ditemukan',
            'nama_konselor.required' => 'Nama konselor harus diisi',
            'nama_konselor.exists' => 'Nama konselor yang dipilih tidak valid untuk layanan ini. Silakan pilih konselor yang sesuai dengan jenis layanan.',
            'tanggal_konseling.required' => 'Tanggal konseling harus diisi',
            'tanggal_konseling.date' => 'Format tanggal konseling tidak valid',
            'waktu_konseling.required' => 'Waktu konseling harus diisi',
            'waktu_konseling.date_format' => 'Format waktu konseling tidak valid (gunakan format HH:MM)',
            'tempat_konseling.required' => 'Tempat konseling harus diisi',
            'jenis_layanan.required' => 'Jenis layanan harus dipilih',
            'konfirmasi.in' => 'Status konfirmasi tidak valid',
        ]);

        // Cari jadwal konseling yang akan diupdate
        $konseling = Konseling::findOrFail($id);

        // Gabungkan tanggal dan waktu
        $jadwalKonseling = $request->tanggal_konseling . ' ' . $request->waktu_konseling;

        // Siapkan data untuk update
        $updateData = [
            'pengaduan_id' => $request->pengaduan_id,
            'korban_id' => $request->korban_id,
            'nama_konselor' => $request->nama_konselor,
            'jadwal_konseling' => $jadwalKonseling,
            'tempat_konseling' => $request->tempat_konseling,
            'jenis_layanan' => $request->jenis_layanan,
        ];

        // Update konfirmasi jika diisi
        if ($request->filled('konfirmasi')) {
            $updateData['konfirmasi'] = $request->konfirmasi;
        }

        // Update data jadwal konseling
        $konseling->update($updateData);

        // Redirect ke halaman detail atau index dengan pesan sukses
        return redirect()->route('konseling.show', $konseling->id)
            ->with('success', 'Jadwal konseling berhasil diperbarui.');
    }

    public function destroy($id)
    {
        // Only staff can delete counseling sessions
        if (Auth::user()->role !== 'staff') {
            abort(403, 'Unauthorized action.');
        }

        $konseling = Konseling::findOrFail($id);
        $konseling->delete();

        return redirect()->route('konseling.index')
            ->with('success', 'Jadwal konseling berhasil dihapus.');
    }

    public function updateKonfirmasi(Request $request, $id)
    {
        $user = Auth::user();
        $konseling = Konseling::findOrFail($id);

        // Validasi akses
        if ($user->role === 'staff') {
            // Staff bisa konfirmasi semua konseling
            $request->validate([
                'konfirmasi' => ['required', Rule::in([
                    'menunggu_konfirmasi_user',
                    'setuju',
                    'tolak'
                ])],
            ]);

            $konseling->update(['konfirmasi' => $request->konfirmasi]);
        } else {
            // User hanya bisa konfirmasi konseling miliknya
            if ($konseling->pengaduan->user_id !== $user->id) {
                abort(403, 'Anda tidak memiliki izin untuk melakukan tindakan ini.');
            }

            $request->validate([
                'konfirmasi' => ['required', Rule::in([
                    'setuju',
                    'tolak'
                ])],
            ]);

            $konseling->update(['konfirmasi' => $request->konfirmasi]);
        }

        $message = match($request->konfirmasi) {
            'menunggu_konfirmasi_user' => 'Jadwal telah dibuat, menunggu konfirmasi user.',
            'setuju' => 'Konseling telah dikonfirmasi.',
            'tolak' => 'Konseling telah dibatalkan.',
            default => 'Status konfirmasi konseling berhasil diperbarui.'
        };

        return redirect()->back()->with('success', $message);
    }

    public function requestForm()
    {
        $user = Auth::user();

        if ($user->role === 'staff') {
            return redirect()->route('konseling.index')->with('error', 'Staff tidak dapat mengajukan konseling.');
        }

        // Ambil pengaduan milik user yang belum memiliki konseling
        $pengaduans = Pengaduan::where('user_id', $user->id)
            ->whereHas('korban', function($query) {
                $query->whereDoesntHave('konseling');
            })
            ->with(['korban' => function($query) {
                $query->whereDoesntHave('konseling');
            }])
            ->get();

        // Ambil layanan dengan jenis_layanan = 'konseling'
        $layanans = layanan::where('jenis_layanan', 'konseling')->get();

        return view('konseling.request', compact('pengaduans', 'layanans'));
    }

    public function requestCounseling(Request $request)
    {
        $user = Auth::user();

        if ($user->role === 'staff') {
            return redirect()->route('konseling.index')->with('error', 'Staff tidak dapat mengajukan konseling.');
        }

        // Ambil semua nama_layanan dari tabel layanan yang jenisnya konseling
        $layanans = layanan::where('jenis_layanan', 'konseling')->pluck('nama_layanan')->toArray();

        $validated = $request->validate([
            'pengaduan_id' => 'required|exists:pengaduan,id',
            'korban_id' => [
                'required',
                Rule::exists('korban', 'id')->where(function ($query) use ($request) {
                    return $query->where('pengaduan_id', $request->pengaduan_id);
                }),
                Rule::unique('konseling', 'korban_id')->where(function ($query) use ($request) {
                    return $query->where('pengaduan_id', $request->pengaduan_id);
                }),
            ],
            'tanggal_konseling' => 'required|date',
            'waktu_konseling' => 'required|date_format:H:i',
            'jenis_layanan' => 'required|in:' . implode(',', $layanans),
        ]);

        $korban = Korban::findOrFail($validated['korban_id']);

        // Gabungkan tanggal dan waktu
        $jadwalKonseling = $validated['tanggal_konseling'] . ' ' . $validated['waktu_konseling'];

        Konseling::create([
            'pengaduan_id' => $validated['pengaduan_id'],
            'korban_id' => $validated['korban_id'],
            'nama_korban' => $korban->nama,
            'nama_konselor' => 'Belum ditentukan',
            'jadwal_konseling' => $jadwalKonseling,
            'tempat_konseling' => 'Belum ditentukan',
            'jenis_layanan' => $validated['jenis_layanan'],
            'konfirmasi' => 'butuh_konfirmasi_staff',
        ]);

        return redirect()->route('konseling.index')->with('success', 'Permintaan konseling berhasil diajukan. Staff akan meninjau permintaan Anda.');
    }
}
