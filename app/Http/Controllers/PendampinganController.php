<?php

namespace App\Http\Controllers;

use App\Models\Pendampingan;
use App\Models\Pengaduan;
use App\Models\Korban;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class PendampinganController extends Controller
{
    public function index()
    {
        $user = Auth::user();
        
        if (!$user) {
            $pendampingans = collect(); 
            return view('pendampingan.index', compact('pendampingans'));
        }
        
        if ($user->role === 'staff') {
            $pendampingans = Pendampingan::with(['pengaduan', 'korban'])
                ->orderBy('tanggal_pendampingan', 'desc')
                ->get();
        } else {
            $pendampingans = Pendampingan::whereHas('pengaduan', function($query) use ($user) {
                $query->where('user_id', $user->id);
            })
            ->with(['pengaduan', 'korban'])
            ->orderBy('tanggal_pendampingan', 'desc')
            ->get();
        }
        
        return view('pendampingan.index', compact('pendampingans'));
    }

    public function create()
    {
        // Only staff can create accompaniment schedules
        if (Auth::user()->role !== 'staff') {
            abort(403, 'Unauthorized action.');
        }

        // Get all cases that might need accompaniment - filter korban yang belum punya pendampingan
        $pengaduans = Pengaduan::with(['korban' => function($query) {
            // Hanya ambil korban yang belum memiliki jadwal pendampingan
            $query->whereDoesntHave('pendampingan');
        }])
        ->whereHas('korban') // Hanya ambil pengaduan yang punya korban
        ->get();

        return view('pendampingan.create', compact('pengaduans'));
    }

    public function store(Request $request)
    {
        // Only staff can create accompaniment schedules
        if (Auth::user()->role !== 'staff') {
            abort(403, 'Unauthorized action.');
        }

        $validated = $request->validate([
            'pengaduan_id' => 'required|exists:pengaduan,id',
            'korban_id' => 'required|exists:korban,id',
            'nama_pendamping' => 'required|string|max:255',
            'tanggal_pendampingan' => 'required|date',
            'tempat_pendampingan' => 'required|string|max:255',
        ], [
            'pengaduan_id.required' => 'Pengaduan harus dipilih',
            'pengaduan_id.exists' => 'Pengaduan tidak ditemukan',
            'korban_id.required' => 'Korban harus dipilih',
            'korban_id.exists' => 'Korban tidak ditemukan',
            'nama_pendamping.required' => 'Nama pendamping harus diisi',
            'tanggal_pendampingan.required' => 'Tanggal pendampingan harus diisi',
            'tempat_pendampingan.required' => 'Tempat pendampingan harus diisi',
        ]);

        $korban = Korban::findOrFail($request->korban_id);

        // Cek apakah korban sudah memiliki pendampingan
        $existingPendampingan = Pendampingan::where('korban_id', $request->korban_id)->first();
        if ($existingPendampingan) {
            return back()
                ->withInput()
                ->withErrors(['korban_id' => 'Korban ini sudah memiliki jadwal pendampingan']);
        }

        $pendampingan = Pendampingan::create([
            'pengaduan_id' => $request->pengaduan_id,
            'korban_id' => $request->korban_id,
            'nama_korban' => $korban->nama,
            'nama_pendamping' => $request->nama_pendamping,
            'tanggal_pendampingan' => $request->tanggal_pendampingan,
            'tempat_pendampingan' => $request->tempat_pendampingan,
            'konfirmasi' => 'menunggu'
        ]);

        return redirect()->route('pendampingan.index')
            ->with('success', 'Jadwal pendampingan berhasil dibuat.');
    }

    public function show($id)
    {
        $pendampingan = Pendampingan::with(['pengaduan', 'korban'])->findOrFail($id);
        
        // Check if user has permission to view this accompaniment
        $user = Auth::user();
        if ($user->role !== 'staff' && $pendampingan->pengaduan->user_id !== $user->id) {
            abort(403, 'Unauthorized action.');
        }

        return view('pendampingan.show', compact('pendampingan'));
    }

    public function edit($id)
    {
        // Only staff can edit accompaniment schedules
        if (Auth::user()->role !== 'staff') {
            abort(403, 'Unauthorized action.');
        }

        $pendampingan = Pendampingan::with(['pengaduan', 'korban'])->findOrFail($id);
        
        // Hanya ambil pengaduan yang relevan - allow current korban, filter yang lain
        $pengaduans = Pengaduan::with(['korban' => function($query) use ($id) {
            // Biarkan korban yang sedang di-edit, tapi filter yang lain
            $query->whereDoesntHave('pendampingan', function($subQuery) use ($id) {
                $subQuery->where('id', '!=', $id);
            });
        }])
        ->whereHas('korban')
        ->get();

        return view('pendampingan.edit', compact('pendampingan', 'pengaduans'));
    }

    public function update(Request $request, $id)
    {
        // Only staff can update accompaniment schedules
        if (Auth::user()->role !== 'staff') {
            abort(403, 'Unauthorized action.');
        }

        $validated = $request->validate([
            'pengaduan_id' => 'required|exists:pengaduan,id',
            'korban_id' => 'required|exists:korban,id',
            'nama_pendamping' => 'required|string|max:255',
            'tanggal_pendampingan' => 'required|date',
            'tempat_pendampingan' => 'required|string|max:255',
        ], [
            'pengaduan_id.required' => 'Pengaduan harus dipilih',
            'pengaduan_id.exists' => 'Pengaduan tidak ditemukan',
            'korban_id.required' => 'Korban harus dipilih',
            'korban_id.exists' => 'Korban tidak ditemukan',
            'nama_pendamping.required' => 'Nama pendamping harus diisi',
            'tanggal_pendampingan.required' => 'Tanggal pendampingan harus diisi',
            'tempat_pendampingan.required' => 'Tempat pendampingan harus diisi',
        ]);

        $pendampingan = Pendampingan::findOrFail($id);
        
        // Update dengan nama korban yang baru jika korban diganti
        $korban = Korban::findOrFail($request->korban_id);
        
        $pendampingan->update([
            ...$validated,
            'nama_korban' => $korban->nama
        ]);

        return redirect()->route('pendampingan.show', $pendampingan->id)
            ->with('success', 'Jadwal pendampingan berhasil diperbarui.');
    }

    public function destroy($id)
    {
        // Only staff can delete accompaniment schedules
        if (Auth::user()->role !== 'staff') {
            abort(403, 'Unauthorized action.');
        }

        $pendampingan = Pendampingan::findOrFail($id);
        $pendampingan->delete();

        return redirect()->route('pendampingan.index')
            ->with('success', 'Jadwal pendampingan berhasil dihapus.');
    }

    public function updateKonfirmasi(Request $request, $id)
    {
        $pendampingan = Pendampingan::findOrFail($id);
        
        // Check if user has permission to confirm this accompaniment
        $user = Auth::user();
        if ($user->role === 'staff') {
            abort(403, 'Staff tidak dapat mengkonfirmasi pendampingan.');
        }
        
        if ($pendampingan->pengaduan->user_id !== $user->id) {
            abort(403, 'Anda tidak memiliki akses untuk mengkonfirmasi pendampingan ini.');
        }

        $request->validate([
            'konfirmasi' => 'required|in:setuju,tolak'
        ]);

        $pendampingan->update([
            'konfirmasi' => $request->konfirmasi
        ]);

        return redirect()->route('pendampingan.show', $pendampingan->id)
            ->with('success', 'Status konfirmasi berhasil diperbarui.');
    }
}