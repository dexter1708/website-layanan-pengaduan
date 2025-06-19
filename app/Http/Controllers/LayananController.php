<?php

namespace App\Http\Controllers;

use App\Models\layanan;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class LayananController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        if (Auth::user()->role !== 'staff') {
            abort(403, 'Anda tidak memiliki izin untuk mengakses halaman ini.');
        }

        $layanans = layanan::orderBy('nama_layanan', 'asc')->get();
        return view('layanan.index', compact('layanans'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        if (Auth::user()->role !== 'staff') {
            abort(403, 'Anda tidak memiliki izin untuk mengakses halaman ini.');
        }

        return view('layanan.create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        if (Auth::user()->role !== 'staff') {
            abort(403, 'Anda tidak memiliki izin untuk melakukan tindakan ini.');
        }

        $request->validate([
            'nama_layanan' => 'required|string|max:255|unique:layanan,nama_layanan',
            'jenis_layanan' => 'required|in:pendampingan,konseling',
        ], [
            'nama_layanan.required' => 'Nama layanan harus diisi',
            'nama_layanan.unique' => 'Nama layanan sudah ada',
            'jenis_layanan.required' => 'Jenis layanan harus dipilih',
            'jenis_layanan.in' => 'Jenis layanan harus pendampingan atau konseling',
        ]);

        layanan::create([
            'nama_layanan' => $request->nama_layanan,
            'jenis_layanan' => $request->jenis_layanan,
        ]);

        return redirect()->route('staff.layanan.index')
            ->with('success', 'Layanan berhasil ditambahkan.');
    }

    /**
     * Display the specified resource.
     */
    public function show($id)
    {
        if (Auth::user()->role !== 'staff') {
            abort(403, 'Anda tidak memiliki izin untuk mengakses halaman ini.');
        }

        $layanan = layanan::findOrFail($id);
        return view('layanan.show', compact('layanan'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit($id)
    {
        if (Auth::user()->role !== 'staff') {
            abort(403, 'Anda tidak memiliki izin untuk mengakses halaman ini.');
        }

        $layanan = layanan::findOrFail($id);
        return view('layanan.edit', compact('layanan'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, $id)
    {
        if (Auth::user()->role !== 'staff') {
            abort(403, 'Anda tidak memiliki izin untuk melakukan tindakan ini.');
        }

        $layanan = layanan::findOrFail($id);

        $request->validate([
            'nama_layanan' => 'required|string|max:255|unique:layanan,nama_layanan,' . $id,
            'jenis_layanan' => 'required|in:pendampingan,konseling',
        ], [
            'nama_layanan.required' => 'Nama layanan harus diisi',
            'nama_layanan.unique' => 'Nama layanan sudah ada',
            'jenis_layanan.required' => 'Jenis layanan harus dipilih',
            'jenis_layanan.in' => 'Jenis layanan harus pendampingan atau konseling',
        ]);

        $layanan->update([
            'nama_layanan' => $request->nama_layanan,
            'jenis_layanan' => $request->jenis_layanan,
        ]);

        return redirect()->route('staff.layanan.index')
            ->with('success', 'Layanan berhasil diperbarui.');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy($id)
    {
        if (Auth::user()->role !== 'staff') {
            abort(403, 'Anda tidak memiliki izin untuk melakukan tindakan ini.');
        }

        $layanan = layanan::findOrFail($id);

        // Cek apakah layanan masih digunakan oleh instruktur
        $instrukturCount = \App\Models\instruktur::where('nama_layanan', $layanan->nama_layanan)->count();
        if ($instrukturCount > 0) {
            return redirect()->route('staff.layanan.index')
                ->with('error', 'Layanan tidak dapat dihapus karena masih digunakan oleh ' . $instrukturCount . ' instruktur.');
        }

        $layanan->delete();

        return redirect()->route('staff.layanan.index')
            ->with('success', 'Layanan berhasil dihapus.');
    }
}
