<?php

namespace App\Http\Controllers;

use App\Models\BentukKekerasan;
use Illuminate\Http\Request;

class BentukKekerasanController extends Controller
{
    public function index()
    {
        $bentukKekerasan = BentukKekerasan::all();
        return view('staff.bentuk-kekerasan.index', compact('bentukKekerasan'));
    }

    public function create()
    {
        return view('staff.bentuk-kekerasan.create');
    }

    public function store(Request $request)
    {
        $request->validate([
            'bentuk_kekerasan' => 'required|string|max:255|unique:bentuk_kekerasan',
        ], [
            'bentuk_kekerasan.required' => 'Nama bentuk kekerasan wajib diisi.',
            'bentuk_kekerasan.string' => 'Nama bentuk kekerasan harus berupa teks.',
            'bentuk_kekerasan.max' => 'Nama bentuk kekerasan tidak boleh lebih dari 255 karakter.',
            'bentuk_kekerasan.unique' => 'Nama bentuk kekerasan sudah ada.',
        ]);

        BentukKekerasan::create($request->all());

        return redirect()->route('staff.bentuk-kekerasan.index')
            ->with('success', 'Bentuk kekerasan berhasil ditambahkan');
    }

    public function edit(BentukKekerasan $bentukKekerasan)
    {
        return view('staff.bentuk-kekerasan.edit', compact('bentukKekerasan'));
    }

    public function update(Request $request, BentukKekerasan $bentukKekerasan)
    {
        $request->validate([
            'bentuk_kekerasan' => 'required|string|max:255|unique:bentuk_kekerasan,bentuk_kekerasan,' . $bentukKekerasan->id,
        ], [
            'bentuk_kekerasan.required' => 'Nama bentuk kekerasan wajib diisi.',
            'bentuk_kekerasan.string' => 'Nama bentuk kekerasan harus berupa teks.',
            'bentuk_kekerasan.max' => 'Nama bentuk kekerasan tidak boleh lebih dari 255 karakter.',
            'bentuk_kekerasan.unique' => 'Nama bentuk kekerasan sudah ada.',
        ]);

        $bentukKekerasan->update($request->all());

        return redirect()->route('staff.bentuk-kekerasan.index')
            ->with('success', 'Bentuk kekerasan berhasil diperbarui');
    }

    public function destroy(BentukKekerasan $bentukKekerasan)
    {
        $bentukKekerasan->delete();

        return redirect()->route('staff.bentuk-kekerasan.index')
            ->with('success', 'Bentuk kekerasan berhasil dihapus');
    }
} 