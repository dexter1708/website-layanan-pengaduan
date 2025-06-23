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
use Carbon\Carbon;

class KonselingController extends Controller
{
    public function index()
    {
        $user = Auth::user();
        $query = Konseling::with(['pengaduan.user', 'korban'])->orderBy('jadwal_konseling', 'desc');

        if ($user->role === 'pelapor') {
            $query->whereHas('pengaduan', fn($q) => $q->where('user_id', $user->id));
        }

        $konselings = $query->get();
        
        // Gunakan view yang berbeda berdasarkan role
        if ($user->role === 'staff') {
            return view('staff.konseling.index', compact('konselings'));
        }
        
        return view('konseling.index', compact('konselings'));
    }

    public function create()
    {
        abort_if(Auth::user()->role !== 'staff', 403, 'Unauthorized action.');

        // Ambil semua pengaduan yang memiliki korban
        $pengaduans = Pengaduan::with('korban')
            ->whereHas('korban')
            ->get();
            
        // Filter pengaduan yang korbannya belum memiliki konseling
        $pengaduans = $pengaduans->filter(function($pengaduan) {
            return !$pengaduan->korban->konseling;
        });
            
        $layanans = layanan::where('jenis_layanan', 'konseling')->get();
        $instrukturs = instruktur::all();

        return view('staff.konseling.create', compact('pengaduans', 'layanans', 'instrukturs'));
    }

    public function store(Request $request)
    {
        abort_if(Auth::user()->role !== 'staff', 403, 'Unauthorized action.');
        $this->validateKonseling($request);

        $korban = Korban::findOrFail($request->korban_id);
        if ($korban->konseling) {
            return back()->withInput()->withErrors(['korban_id' => 'Korban ini sudah memiliki jadwal konseling.']);
        }

        Konseling::create([
            'pengaduan_id' => $request->pengaduan_id,
            'korban_id' => $request->korban_id,
            'nama_korban' => $korban->nama,
            'nama_konselor' => $request->nama_konselor,
            'jadwal_konseling' => $request->tanggal_konseling . ' ' . $request->waktu_konseling,
            'tempat_konseling' => $request->tempat_konseling,
            'jenis_layanan' => $request->jenis_layanan,
            'konfirmasi' => $request->konfirmasi ?? Konseling::STATUS_MENUNGGU_KONFIRMASI_USER,
        ]);

        return redirect()->route('konseling.index')->with('success', 'Jadwal konseling berhasil dibuat.');
    }

    public function show($id)
    {
        $konseling = Konseling::with(['pengaduan', 'korban'])->findOrFail($id);
        $this->authorizeAction($konseling);
        return view('konseling.show', compact('konseling'));
    }

    public function edit($id)
    {
        abort_if(Auth::user()->role !== 'staff', 403, 'Unauthorized action.');

        $konseling = Konseling::with(['pengaduan', 'korban'])->findOrFail($id);
        $pengaduans = Pengaduan::with('korban')->get();
        $layanans = layanan::where('jenis_layanan', 'konseling')->get();
        $instrukturs = instruktur::all();

        return view('staff.konseling.edit', compact('konseling', 'pengaduans', 'layanans', 'instrukturs'));
    }

    public function update(Request $request, $id)
    {
        abort_if(Auth::user()->role !== 'staff', 403, 'Unauthorized action.');
        $this->validateKonseling($request, $id);

        $konseling = Konseling::findOrFail($id);
        $updateData = [
            'pengaduan_id' => $request->pengaduan_id,
            'korban_id' => $request->korban_id,
            'nama_konselor' => $request->nama_konselor,
            'jadwal_konseling' => $request->tanggal_konseling . ' ' . $request->waktu_konseling,
            'tempat_konseling' => $request->tempat_konseling,
            'jenis_layanan' => $request->jenis_layanan,
        ];
        
        if ($konseling->konfirmasi === Konseling::STATUS_BUTUH_KONFIRMASI_STAFF) {
            $updateData['konfirmasi'] = Konseling::STATUS_MENUNGGU_KONFIRMASI_USER;
        } elseif ($request->filled('konfirmasi')) {
            $updateData['konfirmasi'] = $request->konfirmasi;
        }
        
        $konseling->update($updateData);

        return redirect()->route('konseling.index')->with('success', 'Jadwal konseling berhasil diperbarui.');
    }

    public function destroy($id)
    {
        abort_if(Auth::user()->role !== 'staff', 403, 'Unauthorized action.');
        $konseling = Konseling::findOrFail($id);
        $konseling->delete();
        return redirect()->route('konseling.index')->with('success', 'Jadwal konseling berhasil dihapus.');
    }

    public function requestForm()
    {
        $user = Auth::user();
        
        // Ambil semua pengaduan user yang memiliki korban
        $pengaduans = Pengaduan::with('korban')
            ->where('user_id', $user->id)
            ->whereHas('korban')
            ->get();
            
        // Filter pengaduan yang korbannya belum memiliki konseling
        $pengaduans = $pengaduans->filter(function($pengaduan) {
            return !$pengaduan->korban->konseling;
        });
            
        // Siapkan data korban untuk JavaScript
        $korbanData = $pengaduans->mapWithKeys(function($p) {
            if ($p->korban) {
                return [$p->id => [
                    'id' => $p->korban->id,
                    'nama' => $p->korban->nama,
                    'has_konseling' => false // Karena sudah difilter di query
                ]];
            }
            return [$p->id => null];
        });
            
        $layanans = layanan::where('jenis_layanan', 'konseling')->get();
        return view('konseling.request', compact('pengaduans', 'layanans', 'korbanData'));
    }

    public function requestCounseling(Request $request)
    {
        $validated = $request->validate([
            'pengaduan_id' => 'required|exists:pengaduan,id',
            'korban_id' => 'required|exists:korban,id',
            'jenis_layanan' => 'required|string',
            'tanggal_konseling' => 'required|date|after_or_equal:today',
            'waktu_konseling' => 'required|date_format:H:i',
        ]);
        
        $korban = Korban::findOrFail($validated['korban_id']);
        $jadwal = Carbon::parse($validated['tanggal_konseling'] . ' ' . $validated['waktu_konseling']);

        Konseling::create([
            'pengaduan_id' => $validated['pengaduan_id'],
            'korban_id' => $validated['korban_id'],
            'nama_korban' => $korban->nama,
            'jadwal_konseling' => $jadwal,
            'jenis_layanan' => $validated['jenis_layanan'],
            'tempat_konseling' => 'Belum ditentukan',
            'nama_konselor' => 'Belum ditentukan',
            'konfirmasi' => Konseling::STATUS_BUTUH_KONFIRMASI_STAFF,
        ]);

        return redirect()->route('konseling.index')->with('success', 'Permintaan konseling Anda telah diajukan dan sedang menunggu konfirmasi dari staff.');
    }

    public function showkonfirmasi($id)
    {
        $konseling = Konseling::with(['pengaduan', 'korban'])->findOrFail($id);
        
        // Pastikan hanya user yang berwenang yang bisa mengakses
        $user = Auth::user();
        if ($user->role !== 'staff' && $konseling->pengaduan->user_id !== $user->id) {
            abort(403, 'Anda tidak memiliki izin untuk mengakses halaman ini.');
        }
        
        return view('konseling.konfirmasi', compact('konseling'));
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
                    Konseling::STATUS_MENUNGGU_KONFIRMASI_USER,
                    Konseling::STATUS_TERKONFIRMASI,
                    Konseling::STATUS_DIBATALKAN
                ])],
                'nama_konselor' => [
                    'nullable',
                    Rule::exists('instruktur', 'nama')->where(function ($query) use ($konseling) {
                        return $query->where('nama_layanan', $konseling->jenis_layanan);
                    }),
                ],
                'tanggal_konseling' => 'nullable|date',
                'waktu_konseling' => 'nullable|date_format:H:i',
                'tempat_konseling' => 'nullable|string|max:255',
            ], [
                'nama_konselor.exists' => 'Nama konselor yang dipilih tidak valid untuk layanan ini.',
                'tanggal_konseling.date' => 'Format tanggal konseling tidak valid.',
                'waktu_konseling.date_format' => 'Format waktu konseling tidak valid (gunakan format HH:MM).',
                'tempat_konseling.max' => 'Tempat konseling tidak boleh lebih dari 255 karakter.',
            ]);

            // Update fields if provided
            $updateData = ['konfirmasi' => $request->konfirmasi];

            if ($request->filled('nama_konselor')) {
                $updateData['nama_konselor'] = $request->nama_konselor;
            }

            if ($request->filled('tanggal_konseling') && $request->filled('waktu_konseling')) {
                $jadwal = Carbon::parse($request->tanggal_konseling . ' ' . $request->waktu_konseling);
                $updateData['jadwal_konseling'] = $jadwal;
            }

            if ($request->filled('tempat_konseling')) {
                $updateData['tempat_konseling'] = $request->tempat_konseling;
            }

            $konseling->update($updateData);
        } else {
            // User hanya bisa konfirmasi konseling miliknya
            if ($konseling->pengaduan->user_id !== $user->id) {
                abort(403, 'Anda tidak memiliki izin untuk melakukan tindakan ini.');
            }

            $request->validate([
                'konfirmasi' => ['required', Rule::in([
                    Konseling::STATUS_TERKONFIRMASI,
                    Konseling::STATUS_DIBATALKAN
                ])],
            ]);

            $konseling->update(['konfirmasi' => $request->konfirmasi]);
        }

        $message = match($request->konfirmasi) {
            Konseling::STATUS_MENUNGGU_KONFIRMASI_USER => 'Jadwal telah dibuat, menunggu konfirmasi user.',
            Konseling::STATUS_TERKONFIRMASI => 'Jadwal konseling telah Anda setujui.',
            Konseling::STATUS_DIBATALKAN => 'Jadwal konseling telah Anda tolak.',
            default => 'Status konfirmasi konseling berhasil diperbarui.'
        };

        return redirect()->route('konseling.index')->with('success', $message);
    }
    
    private function validateKonseling(Request $request, $konselingId = null)
    {
        $layanans = layanan::where('jenis_layanan', 'konseling')->pluck('nama_layanan')->toArray();
        $korbanIdRule = 'required|exists:korban,id';

        if (!$konselingId) {
            $korbanIdRule .= '|unique:konseling,korban_id';
        }

        return $request->validate([
            'pengaduan_id' => 'required|exists:pengaduan,id',
            'korban_id' => $korbanIdRule,
            'nama_konselor' => ['required', Rule::exists('instruktur', 'nama')->where('nama_layanan', $request->jenis_layanan)],
            'tanggal_konseling' => 'required|date',
            'waktu_konseling' => 'required|date_format:H:i',
            'tempat_konseling' => 'required|string|max:255',
            'jenis_layanan' => 'required|in:' . implode(',', $layanans),
            'konfirmasi' => ['nullable', Rule::in(array_keys(self::getConfirmationStatusMap()))],
        ], [
            'korban_id.unique' => 'Korban ini sudah memiliki jadwal konseling.',
            'nama_konselor.exists' => 'Nama konselor yang dipilih tidak valid untuk layanan ini.',
        ]);
    }

    private function authorizeAction(Konseling $konseling)
    {
        $user = Auth::user();
        abort_if($user->role === 'pelapor' && $konseling->pengaduan->user_id !== $user->id, 403, 'Unauthorized action.');
    }

    public static function getConfirmationStatusMap()
    {
        return [
            Konseling::STATUS_BUTUH_KONFIRMASI_STAFF => 'Butuh Konfirmasi Staff',
            Konseling::STATUS_MENUNGGU_KONFIRMASI_USER => 'Menunggu Konfirmasi User',
            Konseling::STATUS_TERKONFIRMASI => 'Terkonfirmasi',
            Konseling::STATUS_DIBATALKAN => 'Ditolak',
        ];
    }
}
