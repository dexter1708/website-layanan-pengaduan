<?php

namespace App\Http\Controllers;

use App\Models\Alamat;
use Illuminate\Http\Request;

class AlamatController extends Controller
{
    public function index()
    {
        $alamat = Alamat::all();
        return view('staff.alamat.index', compact('alamat'));
    }

    public function create()
    {
        return view('staff.alamat.create');
    }

    public function store(Request $request)
    {
        $request->validate([
            'nama' => 'required|string|max:255',
            'sebagai' => 'required|string|max:255',
            'kota' => 'required|string|max:255',
            'kecamatan' => 'required|string|max:255',
            'desa' => 'required|string|max:255',
            'RT' => 'required|integer',
            'RW' => 'required|integer',
        ], [
            'nama.required' => 'Nama wajib diisi.',
            'nama.string' => 'Nama harus berupa teks.',
            'nama.max' => 'Nama tidak boleh lebih dari 255 karakter.',
            
            'sebagai.required' => 'Sebagai wajib diisi.',
            'sebagai.string' => 'Sebagai harus berupa teks.',
            'sebagai.max' => 'Sebagai tidak boleh lebih dari 255 karakter.',
            
            'kota.required' => 'Kota wajib diisi.',
            'kota.string' => 'Kota harus berupa teks.',
            'kota.max' => 'Kota tidak boleh lebih dari 255 karakter.',
            
            'kecamatan.required' => 'Kecamatan wajib diisi.',
            'kecamatan.string' => 'Kecamatan harus berupa teks.',
            'kecamatan.max' => 'Kecamatan tidak boleh lebih dari 255 karakter.',
            
            'desa.required' => 'Desa wajib diisi.',
            'desa.string' => 'Desa harus berupa teks.',
            'desa.max' => 'Desa tidak boleh lebih dari 255 karakter.',
            
            'RT.required' => 'RT wajib diisi.',
            'RT.integer' => 'RT harus berupa angka.',
            
            'RW.required' => 'RW wajib diisi.',
            'RW.integer' => 'RW harus berupa angka.',
        ]);

        Alamat::create($request->all());

        return redirect()->route('staff.alamat.index')
            ->with('success', 'Alamat berhasil ditambahkan');
    }

    public function edit(Alamat $alamat)
    {
        return view('staff.alamat.edit', compact('alamat'));
    }

    public function update(Request $request, Alamat $alamat)
    {
        $request->validate([
            'nama' => 'required|string|max:255',
            'sebagai' => 'required|string|max:255',
            'kota' => 'required|string|max:255',
            'kecamatan' => 'required|string|max:255',
            'desa' => 'required|string|max:255',
            'RT' => 'required|integer',
            'RW' => 'required|integer',
        ], [
            'nama.required' => 'Nama wajib diisi.',
            'nama.string' => 'Nama harus berupa teks.',
            'nama.max' => 'Nama tidak boleh lebih dari 255 karakter.',
            
            'sebagai.required' => 'Sebagai wajib diisi.',
            'sebagai.string' => 'Sebagai harus berupa teks.',
            'sebagai.max' => 'Sebagai tidak boleh lebih dari 255 karakter.',
            
            'kota.required' => 'Kota wajib diisi.',
            'kota.string' => 'Kota harus berupa teks.',
            'kota.max' => 'Kota tidak boleh lebih dari 255 karakter.',
            
            'kecamatan.required' => 'Kecamatan wajib diisi.',
            'kecamatan.string' => 'Kecamatan harus berupa teks.',
            'kecamatan.max' => 'Kecamatan tidak boleh lebih dari 255 karakter.',
            
            'desa.required' => 'Desa wajib diisi.',
            'desa.string' => 'Desa harus berupa teks.',
            'desa.max' => 'Desa tidak boleh lebih dari 255 karakter.',
            
            'RT.required' => 'RT wajib diisi.',
            'RT.integer' => 'RT harus berupa angka.',
            
            'RW.required' => 'RW wajib diisi.',
            'RW.integer' => 'RW harus berupa angka.',
        ]);

        $alamat->update($request->all());

        return redirect()->route('staff.alamat.index')
            ->with('success', 'Alamat berhasil diperbarui');
    }

    public function destroy(Alamat $alamat)
    {
        $alamat->delete();

        return redirect()->route('staff.alamat.index')
            ->with('success', 'Alamat berhasil dihapus');
    }
} 