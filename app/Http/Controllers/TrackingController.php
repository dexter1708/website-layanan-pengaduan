<?php

namespace App\Http\Controllers;

use App\Models\Pengaduan;
use App\Models\HistoriTracking;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class TrackingController extends Controller
{
    public function index()
    {
        $user = Auth::user();
        
        // Jika user adalah pelapor, hanya tampilkan pengaduan miliknya
        if ($user->role === 'pelapor') {
            $pengaduans = Pengaduan::with(['pelapor.alamat', 'korban'])
                ->where('user_id', $user->id)
                ->orderBy('created_at', 'desc')
                ->get();
        } else {
            // Jika admin/petugas, tampilkan semua pengaduan
            $pengaduans = Pengaduan::with(['pelapor.alamat', 'korban'])
                ->orderBy('created_at', 'desc')
                ->get();
        }

        return view('Pelapor.tracking', compact('pengaduans'));
    }

    public function show($id)
    {
        $user = Auth::user();
        $pengaduan = Pengaduan::with(['pelapor.alamat', 'korban', 'historiTracking.changedByUser'])
            ->findOrFail($id);

        // Pastikan user hanya bisa melihat pengaduan miliknya (jika role pelapor)
        if ($user->role === 'pelapor' && $pengaduan->user_id !== $user->id) {
            abort(403, 'Unauthorized action.');
        }

        return view('Pelapor.tracking-detail', compact('pengaduan'));
    }

    public function edit($id)
    {
        // Hanya admin/petugas yang bisa mengakses halaman edit
        if (Auth::user()->role === 'pelapor') {
            abort(403, 'Unauthorized action.');
        }

        $pengaduan = Pengaduan::with(['pelapor.alamat', 'korban'])
            ->findOrFail($id);
            
        return view('Pelapor.tracking-edit', compact('pengaduan'));
    }

    public function updateStatus(Request $request, $id)
    {
        // Hanya admin/petugas yang bisa update status
        if (Auth::user()->role === 'pelapor') {
            abort(403, 'Unauthorized action.');
        }

        $request->validate([
            'status' => 'required|in:menunggu,diproses,selesai,di_reskrim,di_kejaksaan'
        ]);

        $pengaduan = Pengaduan::findOrFail($id);
        $oldStatus = $pengaduan->status;
        
        // Update status pengaduan
        $pengaduan->status = $request->status;
        $pengaduan->save();

        // Simpan riwayat perubahan status
        HistoriTracking::create([
            'pengaduan_id' => $pengaduan->id,
            'status_sebelum' => $oldStatus,
            'status_sesudah' => $request->status,
            'changed_by_user_id' => Auth::id(),
            'keterangan' => $request->keterangan
        ]);

        return redirect()->route('tracking.index')->with('success', 'Status pengaduan berhasil diperbarui');
    }
} 