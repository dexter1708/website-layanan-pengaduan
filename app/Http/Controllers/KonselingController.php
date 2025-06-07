<?php

namespace App\Http\Controllers;

use App\Models\Konseling;
use App\Models\Pengaduan;
use App\Models\Korban;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

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

        return view('konseling.create', compact('pengaduans'));
    }

    public function store(Request $request)
    {
        // Only staff can create counseling sessions
        if (Auth::user()->role !== 'staff') {
            abort(403, 'Unauthorized action.');
        }

        $validated = $request->validate([
            'pengaduan_id' => 'required|exists:pengaduan,id',
            'korban_id' => 'required|exists:korban,id',
            'nama_konselor' => 'required|string|max:255',
            'jadwal_konseling' => 'required|date',
            'tempat_konseling' => 'required|string|max:255',
        ], [
            'pengaduan_id.required' => 'Pengaduan harus dipilih',
            'pengaduan_id.exists' => 'Pengaduan tidak ditemukan',
            'korban_id.required' => 'Korban harus dipilih',
            'korban_id.exists' => 'Korban tidak ditemukan',
            'nama_konselor.required' => 'Nama konselor harus diisi',
            'jadwal_konseling.required' => 'Jadwal konseling harus diisi',
            'tempat_konseling.required' => 'Tempat konseling harus diisi',
        ]);

        $korban = Korban::findOrFail($request->korban_id);

        // Cek apakah korban sudah memiliki konseling
        $existingKonseling = Konseling::where('korban_id', $request->korban_id)->first();
        if ($existingKonseling) {
            return back()
                ->withInput()
                ->withErrors(['korban_id' => 'Korban ini sudah memiliki jadwal konseling']);
        }

        $konseling = Konseling::create([
            'pengaduan_id' => $request->pengaduan_id,
            'korban_id' => $request->korban_id,
            'nama_korban' => $korban->nama,
            'nama_konselor' => $request->nama_konselor,
            'jadwal_konseling' => $request->jadwal_konseling,
            'tempat_konseling' => $request->tempat_konseling,
            'konfirmasi' => 'menunggu'
        ]);

        return redirect()->route('konseling.index')
            ->with('success', 'Jadwal konseling berhasil dibuat.');
    }

    public function show($id)
    {
        $konseling = Konseling::with(['pengaduan', 'korban'])->findOrFail($id);
        
        // Check if user has permission to view this counseling session
        $user = Auth::user();
        if ($user->role !== 'staff' && $konseling->pengaduan->user_id !== $user->id) {
            abort(403, 'Unauthorized action.');
        }

        return view('konseling.show', compact('konseling'));
    }

    public function edit($id)
    {
        // Only staff can edit counseling sessions
        if (Auth::user()->role !== 'staff') {
            abort(403, 'Unauthorized action.');
        }

        $konseling = Konseling::with(['pengaduan', 'korban'])->findOrFail($id);
        $pengaduans = Pengaduan::with('korban')->get(); // Mungkin perlu disaring

        return view('konseling.edit', compact('konseling', 'pengaduans'));
    }

    public function update(Request $request, $id)
    {
        // Only staff can update counseling sessions
        if (Auth::user()->role !== 'staff') {
            abort(403, 'Unauthorized action.');
        }

        // Validasi data yang masuk
        $validated = $request->validate([
            'pengaduan_id' => 'required|exists:pengaduan,id',
            'korban_id' => 'required|exists:korban,id',
            'nama_konselor' => 'required|string|max:255',
            'jadwal_konseling' => 'required|date',
            'tempat_konseling' => 'required|string|max:255',
        ], [
            'pengaduan_id.required' => 'Pengaduan harus dipilih',
            'pengaduan_id.exists' => 'Pengaduan tidak ditemukan',
            'korban_id.required' => 'Korban harus dipilih',
            'korban_id.exists' => 'Korban tidak ditemukan',
            'nama_konselor.required' => 'Nama konselor harus diisi',
            'jadwal_konseling.required' => 'Jadwal konseling harus diisi',
            'tempat_konseling.required' => 'Tempat konseling harus diisi',
        ]);

        // Cari jadwal konseling yang akan diupdate
        $konseling = Konseling::findOrFail($id);

        // Update data jadwal konseling
        $konseling->update($validated);

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
        $konseling = Konseling::findOrFail($id);
        
        // Check if user has permission to confirm this counseling session
        $user = Auth::user();
        if ($user->role !== 'staff' && $konseling->pengaduan->user_id !== $user->id) {
            abort(403, 'Unauthorized action.');
        }

        $request->validate([
            'konfirmasi' => 'required|in:setuju,tolak'
        ]);

        $konseling->update([
            'konfirmasi' => $request->konfirmasi
        ]);

        return redirect()->route('konseling.show', $konseling->id)
            ->with('success', 'Status konfirmasi berhasil diperbarui.');
    }
}