<?php

namespace App\Http\Controllers;

use App\Models\instruktur;
use App\Models\layanan;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;

class InstrukturController extends Controller
{
    public function index()
    {
        if (Auth::user()->role !== 'staff') {
            abort(403, 'Anda tidak memiliki izin untuk mengakses halaman ini.');
        }

        $instrukturs = instruktur::with('layanan')->orderBy('nama', 'asc')->get();
        return view('instruktur.index', compact('instrukturs'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        if (Auth::user()->role !== 'staff') {
            abort(403, 'Anda tidak memiliki izin untuk mengakses halaman ini.');
        }

        $layanans = layanan::orderBy('nama_layanan', 'asc')->get();
        return view('instruktur.create', compact('layanans'));
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
            'nama' => 'required|string|max:255|unique:instruktur,nama',
            'posisi' => 'required|string|max:255',
            'foto' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
            'nama_layanan' => 'required|exists:layanan,nama_layanan',
        ], [
            'nama.required' => 'Nama instruktur harus diisi',
            'nama.unique' => 'Nama instruktur sudah ada',
            'posisi.required' => 'Posisi harus diisi',
            'foto.image' => 'File harus berupa gambar',
            'foto.mimes' => 'Format gambar harus jpeg, png, jpg, atau gif',
            'foto.max' => 'Ukuran gambar maksimal 2MB',
            'nama_layanan.required' => 'Layanan harus dipilih',
            'nama_layanan.exists' => 'Layanan yang dipilih tidak valid',
        ]);

        $data = [
            'nama' => $request->nama,
            'posisi' => $request->posisi,
            'nama_layanan' => $request->nama_layanan,
        ];

        if ($request->hasFile('foto')) {
            $foto = $request->file('foto');
            $fotoName = time() . '_' . $foto->getClientOriginalName();
            $foto->storeAs('public/instruktur', $fotoName);
            $data['foto'] = $fotoName;
        }

        instruktur::create($data);

        return redirect()->route('staff.instruktur.index')
            ->with('success', 'Instruktur berhasil ditambahkan.');
    }

    /**
     * Display the specified resource.
     */
    public function show($id)
    {
        if (Auth::user()->role !== 'staff') {
            abort(403, 'Anda tidak memiliki izin untuk mengakses halaman ini.');
        }

        $instruktur = instruktur::with('layanan')->findOrFail($id);
        return view('instruktur.show', compact('instruktur'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit($id)
    {
        if (Auth::user()->role !== 'staff') {
            abort(403, 'Anda tidak memiliki izin untuk mengakses halaman ini.');
        }

        $instruktur = instruktur::findOrFail($id);
        $layanans = layanan::orderBy('nama_layanan', 'asc')->get();
        return view('instruktur.edit', compact('instruktur', 'layanans'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, $id)
    {
        if (Auth::user()->role !== 'staff') {
            abort(403, 'Anda tidak memiliki izin untuk melakukan tindakan ini.');
        }

        $instruktur = instruktur::findOrFail($id);

        $request->validate([
            'nama' => 'required|string|max:255|unique:instruktur,nama,' . $id,
            'posisi' => 'required|string|max:255',
            'foto' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
            'nama_layanan' => 'required|exists:layanan,nama_layanan',
        ], [
            'nama.required' => 'Nama instruktur harus diisi',
            'nama.unique' => 'Nama instruktur sudah ada',
            'posisi.required' => 'Posisi harus diisi',
            'foto.image' => 'File harus berupa gambar',
            'foto.mimes' => 'Format gambar harus jpeg, png, jpg, atau gif',
            'foto.max' => 'Ukuran gambar maksimal 2MB',
            'nama_layanan.required' => 'Layanan harus dipilih',
            'nama_layanan.exists' => 'Layanan yang dipilih tidak valid',
        ]);

        $data = [
            'nama' => $request->nama,
            'posisi' => $request->posisi,
            'nama_layanan' => $request->nama_layanan,
        ];

        if ($request->hasFile('foto')) {
            // Hapus foto lama jika ada
            if ($instruktur->foto) {
                Storage::delete('public/instruktur/' . $instruktur->foto);
            }

            $foto = $request->file('foto');
            $fotoName = time() . '_' . $foto->getClientOriginalName();
            $foto->storeAs('public/instruktur', $fotoName);
            $data['foto'] = $fotoName;
        }

        $instruktur->update($data);

        return redirect()->route('staff.instruktur.index')
            ->with('success', 'Instruktur berhasil diperbarui.');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy($id)
    {
        if (Auth::user()->role !== 'staff') {
            abort(403, 'Anda tidak memiliki izin untuk melakukan tindakan ini.');
        }

        $instruktur = instruktur::findOrFail($id);

        // Hapus foto jika ada
        if ($instruktur->foto) {
            Storage::delete('public/instruktur/' . $instruktur->foto);
        }

        $instruktur->delete();

        return redirect()->route('staff.instruktur.index')
            ->with('success', 'Instruktur berhasil dihapus.');
    }
}
