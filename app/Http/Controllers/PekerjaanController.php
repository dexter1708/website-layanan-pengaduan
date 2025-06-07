<?php

namespace App\Http\Controllers;

use App\Models\Pekerjaan;
use Illuminate\Http\Request;

class PekerjaanController extends Controller
{
    public function index()
    {
        $pekerjaan = Pekerjaan::all();
        return view('staff.pekerjaan.index', compact('pekerjaan'));
    }

    public function create()
    {
        return view('staff.pekerjaan.create');
    }

    public function store(Request $request)
    {
        $request->validate([
            'pekerjaan' => 'required|string|max:255|unique:pekerjaan',
        ]);

        Pekerjaan::create($request->all());

        return redirect()->route('staff.pekerjaan.index')
            ->with('success', 'Pekerjaan berhasil ditambahkan');
    }

    public function edit(Pekerjaan $pekerjaan)
    {
        return view('staff.pekerjaan.edit', compact('pekerjaan'));
    }

    public function update(Request $request, Pekerjaan $pekerjaan)
    {
        $request->validate([
            'pekerjaan' => 'required|string|max:255|unique:pekerjaan,pekerjaan,' . $pekerjaan->id,
        ]);

        $pekerjaan->update($request->all());

        return redirect()->route('staff.pekerjaan.index')
            ->with('success', 'Pekerjaan berhasil diperbarui');
    }

    public function destroy(Pekerjaan $pekerjaan)
    {
        $pekerjaan->delete();

        return redirect()->route('staff.pekerjaan.index')
            ->with('success', 'Pekerjaan berhasil dihapus');
    }
} 