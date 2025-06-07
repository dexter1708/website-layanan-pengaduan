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