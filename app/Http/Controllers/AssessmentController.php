<?php

namespace App\Http\Controllers;

use App\Models\Assessment;
use App\Models\Pengaduan;
use App\Models\Korban;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class AssessmentController extends Controller
{
    public function index()
    {
        $user = Auth::user();
        
        if (!$user) {
            $assessments = collect();
            return view('assessment.index', compact('assessments'));
        }
        
        if ($user->role === 'staff') {
            $assessments = Assessment::with(['pengaduan', 'korban'])
                ->orderBy('tanggal_assesment', 'desc')
                ->get();
        } else {
            $assessments = Assessment::whereHas('pengaduan', function($query) use ($user) {
                $query->where('user_id', $user->id);
            })
            ->with(['pengaduan', 'korban'])
            ->orderBy('tanggal_assesment', 'desc')
            ->get();
        }
        
        return view('assessment.index', compact('assessments'));
    }

    public function create()
    {
        // Only staff can create assessment schedules
        if (Auth::user()->role !== 'staff') {
            abort(403, 'Unauthorized action.');
        }
// Get all cases that might need assessment - filter korban yang belum punya assessment
        $pengaduans = Pengaduan::with(['korban' => function($query) {
            // Hanya ambil korban yang belum memiliki jadwal assessment
            $query->whereDoesntHave('assessment');
        }])
        ->whereHas('korban') // Hanya ambil pengaduan yang punya korban
        ->get();

        return view('assessment.create', compact('pengaduans'));
    }

    public function store(Request $request)
    {
        // Only staff can create assessment schedules
        if (Auth::user()->role !== 'staff') {
            abort(403, 'Unauthorized action.');
        }

        $validated = $request->validate([
            'pengaduan_id' => 'required|exists:pengaduan,id',
            'korban_id' => 'required|exists:korban,id',
            'nama_assessor' => 'required|string|max:255',
            'tanggal_assesment' => 'required|date',
            'tempat_assessment' => 'required|string|max:255',
        ], [
            'pengaduan_id.required' => 'Pengaduan harus dipilih',
            'pengaduan_id.exists' => 'Pengaduan tidak ditemukan',
            'korban_id.required' => 'Korban harus dipilih',
            'korban_id.exists' => 'Korban tidak ditemukan',
            'nama_assessor.required' => 'Nama assessor harus diisi',
            'tanggal_assesment.required' => 'Tanggal assessment harus diisi',
            'tempat_assessment.required' => 'Tempat assessment harus diisi',
        ]);

        $korban = Korban::findOrFail($request->korban_id);

        // Cek apakah korban sudah memiliki assessment
        $existingAssessment = Assessment::where('korban_id', $request->korban_id)->first();
        if ($existingAssessment) {
            return back()
                ->withInput()
                ->withErrors(['korban_id' => 'Korban ini sudah memiliki jadwal assessment']);
        }

        $assessment = Assessment::create([
            'pengaduan_id' => $request->pengaduan_id,
            'korban_id' => $request->korban_id,
            'nama_korban' => $korban->nama,
            'nama_assessor' => $request->nama_assessor,
            'tanggal_assesment' => $request->tanggal_assesment,
            'tempat_assessment' => $request->tempat_assessment,
            'konfirmasi' => 'menunggu'
        ]);

        return redirect()->route('assessment.index')
            ->with('success', 'Jadwal assessment berhasil dibuat.');
    }

    public function show($id)
    {
        $assessment = Assessment::with(['pengaduan', 'korban'])->findOrFail($id);
        
        // Check if user has permission to view this assessment
        $user = Auth::user();
        if ($user->role !== 'staff' && $assessment->pengaduan->user_id !== $user->id) {
            abort(403, 'Unauthorized action.');
        }

        return view('assessment.show', compact('assessment'));
    }

    public function edit($id)
    {
        // Only staff can edit assessment schedules
        if (Auth::user()->role !== 'staff') {
            abort(403, 'Unauthorized action.');
        }

        $assessment = Assessment::with(['pengaduan', 'korban'])->findOrFail($id);
        
        // Hanya ambil pengaduan yang relevan - allow current korban, filter yang lain
        $pengaduans = Pengaduan::with(['korban' => function($query) use ($id) {
            // Biarkan korban yang sedang di-edit, tapi filter yang lain
            $query->whereDoesntHave('assessment', function($subQuery) use ($id) {
                $subQuery->where('id', '!=', $id);
            });
        }])
        ->whereHas('korban')
        ->get();

        return view('assessment.edit', compact('assessment', 'pengaduans'));
    }

    public function update(Request $request, $id)
    {
        // Only staff can update assessment schedules
        if (Auth::user()->role !== 'staff') {
            abort(403, 'Unauthorized action.');
        }

        $validated = $request->validate([
            'pengaduan_id' => 'required|exists:pengaduan,id',
            'korban_id' => 'required|exists:korban,id',
            'nama_assessor' => 'required|string|max:255',
            'tanggal_assesment' => 'required|date',
            'tempat_assessment' => 'required|string|max:255',
        ], [
            'pengaduan_id.required' => 'Pengaduan harus dipilih',
            'pengaduan_id.exists' => 'Pengaduan tidak ditemukan',
            'korban_id.required' => 'Korban harus dipilih',
            'korban_id.exists' => 'Korban tidak ditemukan',
            'nama_assessor.required' => 'Nama assessor harus diisi',
            'tanggal_assesment.required' => 'Tanggal assessment harus diisi',
            'tempat_assessment.required' => 'Tempat assessment harus diisi',
        ]);

        $assessment = Assessment::findOrFail($id);
        
        // Update dengan nama korban yang baru jika korban diganti
        $korban = Korban::findOrFail($request->korban_id);
        
        $assessment->update([
            ...$validated,
            'nama_korban' => $korban->nama
        ]);

        return redirect()->route('assessment.show', $assessment->id)
            ->with('success', 'Jadwal assessment berhasil diperbarui.');
    }

    public function destroy($id)
    {
        // Only staff can delete assessment schedules
        if (Auth::user()->role !== 'staff') {
            abort(403, 'Unauthorized action.');
        }

        $assessment = Assessment::findOrFail($id);
        $assessment->delete();

        return redirect()->route('assessment.index')
            ->with('success', 'Jadwal assessment berhasil dihapus.');
    }

    public function updateKonfirmasi(Request $request, $id)
    {
        $assessment = Assessment::findOrFail($id);
        
        // Check if user has permission to confirm this assessment
        $user = Auth::user();
        if ($user->role === 'staff') {
            abort(403, 'Staff tidak dapat mengkonfirmasi assessment.');
        }
        
        if ($assessment->pengaduan->user_id !== $user->id) {
            abort(403, 'Anda tidak memiliki akses untuk mengkonfirmasi assessment ini.');
        }

        $request->validate([
            'konfirmasi' => 'required|in:setuju,tolak'
        ]);

        $assessment->update([
            'konfirmasi' => $request->konfirmasi
        ]);

        return redirect()->route('assessment.show', $assessment->id)
            ->with('success', 'Status konfirmasi berhasil diperbarui.');
    }
} 