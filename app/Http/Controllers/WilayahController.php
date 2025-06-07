<?php

namespace App\Http\Controllers;

use App\Models\Wilayah;
use Illuminate\Http\Request;

class WilayahController extends Controller
{
    public function index()
    {
        $kota = Wilayah::ofKota()->get();
        $kecamatan = Wilayah::ofKecamatan()->with('kota')->get();
        $desa = Wilayah::ofDesa()->with('kota', 'kecamatan')->get();
        
        return view('staff.wilayah.index', compact('kota', 'kecamatan', 'desa'));
    }

    public function create()
    {
        $kota = Wilayah::ofKota()->get();
        $kecamatan = Wilayah::ofKecamatan()->get();
        return view('staff.wilayah.create', compact('kota', 'kecamatan'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'tipe' => 'required|in:kota,kecamatan,desa',
            'nama' => 'required|string|max:255',
            'kota_id' => 'required_if:tipe,kecamatan,desa|exists:wilayah,id',
            'kecamatan_id' => 'required_if:tipe,desa|exists:wilayah,id',
        ]);

        $wilayah = new Wilayah();

        switch ($request->tipe) {
            case 'kota':
                $wilayah->kota_nama = $request->nama;
                break;
            case 'kecamatan':
                $wilayah->kota_id = $request->kota_id;
                $wilayah->kecamatan_nama = $request->nama;
                break;
            case 'desa':
                $wilayah->kota_id = $request->kota_id;
                $wilayah->kecamatan_id = $request->kecamatan_id;
                $wilayah->desa_nama = $request->nama;
                break;
        }

        $wilayah->save();

        return redirect()->route('staff.wilayah.index')
            ->with('success', 'Wilayah berhasil ditambahkan');
    }

    public function edit(Wilayah $wilayah)
    {
        // Eager load relationships
        $wilayah->load('kota', 'kecamatan');

        $kota = Wilayah::ofKota()->get();
        $kecamatan = Wilayah::ofKecamatan()->get();
        
        $tipe = 'kota';
        if ($wilayah->desa_nama) {
            $tipe = 'desa';
        } elseif ($wilayah->kecamatan_nama) {
            $tipe = 'kecamatan';
        }

        return view('staff.wilayah.edit', compact('wilayah', 'kota', 'kecamatan', 'tipe'));
    }

    public function update(Request $request, Wilayah $wilayah)
    {
        $wilayah->load('kota', 'kecamatan'); // Eager load relationships

        $request->validate([
            'tipe' => 'required|in:kota,kecamatan,desa',
            'nama' => 'required|string|max:255',
            'kota_id' => 'required_if:tipe,kecamatan,desa|exists:wilayah,id',
            'kecamatan_id' => 'required_if:tipe,desa|exists:wilayah,id',
        ]);

        // Reset all fields
        $wilayah->kota_id = null;
        $wilayah->kecamatan_id = null;
        $wilayah->kota_nama = null;
        $wilayah->kecamatan_nama = null;
        $wilayah->desa_nama = null;

        switch ($request->tipe) {
            case 'kota':
                $wilayah->kota_nama = $request->nama;
                break;
            case 'kecamatan':
                $wilayah->kota_id = $request->kota_id;
                $wilayah->kecamatan_nama = $request->nama;
                break;
            case 'desa':
                $wilayah->kota_id = $request->kota_id;
                $wilayah->kecamatan_id = $request->kecamatan_id;
                $wilayah->desa_nama = $request->nama;
                break;
        }

        $wilayah->save();

        return redirect()->route('staff.wilayah.index')
            ->with('success', 'Wilayah berhasil diperbarui');
    }

    public function destroy(Wilayah $wilayah)
    {
        $wilayah->load('kota', 'kecamatan'); // Eager load relationships

        // Check if this wilayah has any child records
        if ($wilayah->kota_nama) {
            $hasKecamatan = Wilayah::where('kota_id', $wilayah->id)->exists();
            if ($hasKecamatan) {
                return redirect()->route('staff.wilayah.index')
                    ->with('error', 'Tidak dapat menghapus kota yang memiliki kecamatan');
            }
        }

        if ($wilayah->kecamatan_nama) {
            $hasDesa = Wilayah::where('kecamatan_id', $wilayah->id)->exists();
            if ($hasDesa) {
                return redirect()->route('staff.wilayah.index')
                    ->with('error', 'Tidak dapat menghapus kecamatan yang memiliki desa');
            }
        }

        $wilayah->delete();

        return redirect()->route('staff.wilayah.index')
            ->with('success', 'Wilayah berhasil dihapus');
    }

    // API endpoints for dynamic dropdowns
    public function getKecamatan($kotaId)
    {
        $kecamatan = Wilayah::where('kota_id', $kotaId)
            ->whereNotNull('kecamatan_nama')
            ->get();
        return response()->json($kecamatan);
    }

    public function getDesa($kecamatanId)
    {
        $desa = Wilayah::where('kecamatan_id', $kecamatanId)
            ->whereNotNull('desa_nama')
            ->get();
        return response()->json($desa);
    }
}
