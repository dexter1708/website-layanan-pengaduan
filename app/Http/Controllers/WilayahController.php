<?php

namespace App\Http\Controllers;

use App\Models\Wilayah;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use Illuminate\Validation\Rule;

class WilayahController extends Controller
{
    public function index()
    {
        // Ambil daftar kota yang memiliki kecamatan (kota yang aktif)
        $kotas = Wilayah::select('kota_id', 'kota_nama')
                        ->whereNotNull('kota_nama')
                        ->groupBy('kota_id', 'kota_nama')
                        ->orderBy('kota_nama')
                        ->get();

        // Ambil daftar kecamatan yang memiliki desa (kecamatan yang aktif)
        $kecamatans = Wilayah::select('kecamatan_id', 'kecamatan_nama', 'kota_id', 'kota_nama')
                             ->whereNotNull('kecamatan_nama')
                             ->groupBy('kecamatan_id', 'kecamatan_nama', 'kota_id', 'kota_nama')
                             ->orderBy('kota_nama')
                             ->orderBy('kecamatan_nama')
                             ->get();

        // Ambil daftar desa
        $desas = Wilayah::select('id', 'desa_id', 'desa_nama', 'kecamatan_id', 'kecamatan_nama', 'kota_id', 'kota_nama')
                        ->whereNotNull('desa_nama')
                        ->orderBy('kota_nama')
                        ->orderBy('kecamatan_nama')
                        ->orderBy('desa_nama')
                        ->get();

        return view('staff.wilayah.index', compact('kotas', 'kecamatans', 'desas'));
    }

    public function create()
    {
        // Ambil daftar semua kota yang ada
        $kotas = Wilayah::select('kota_id', 'kota_nama')
                        ->whereNotNull('kota_nama')
                        ->groupBy('kota_id', 'kota_nama')
                        ->orderBy('kota_nama')
                        ->get();

        // Untuk form create, dropdown kecamatan awalnya kosong dan akan diisi via AJAX
        $kecamatans = collect(); 

        return view('staff.wilayah.create', compact('kotas', 'kecamatans'));
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'tipe' => 'required|in:kota,kecamatan,desa',
            'nama' => 'required|string|max:255',
        ], [
            'tipe.required' => 'Tipe wilayah wajib dipilih.',
            'tipe.in' => 'Tipe wilayah harus berupa kota, kecamatan, atau desa.',
            'nama.required' => 'Nama wilayah wajib diisi.',
            'nama.string' => 'Nama wilayah harus berupa teks.',
            'nama.max' => 'Nama wilayah tidak boleh lebih dari 255 karakter.',
        ]);

        switch ($request->tipe) {
            case 'kota':
                // Check if kota already exists
                $existingKota = Wilayah::where('kota_nama', $request->nama)
                                      ->whereNotNull('kota_nama')
                                      ->first();
                
                if ($existingKota) {
                    return redirect()->back()
                        ->withInput()
                        ->with('error', 'Kota dengan nama tersebut sudah ada.');
                }

                // Validate required fields for kota
                $request->validate([
                    'kecamatan_nama' => 'required|string|max:255',
                    'desa_nama' => 'required|string|max:255',
                ], [
                    'kecamatan_nama.required' => 'Nama kecamatan wajib diisi.',
                    'kecamatan_nama.string' => 'Nama kecamatan harus berupa teks.',
                    'kecamatan_nama.max' => 'Nama kecamatan tidak boleh lebih dari 255 karakter.',
                    'desa_nama.required' => 'Nama desa wajib diisi.',
                    'desa_nama.string' => 'Nama desa harus berupa teks.',
                    'desa_nama.max' => 'Nama desa tidak boleh lebih dari 255 karakter.',
                ]);

                // Get next available global IDs
                $nextKotaId = (Wilayah::max('kota_id') ?? 0) + 1;
                $nextKecamatanId = (Wilayah::max('kecamatan_id') ?? 0) + 1;
                $nextDesaId = (Wilayah::max('id') ?? 0) + 1;

                // 1. Insert/cek data desa (parent) dulu, isi juga kolom id
                $desa = Wilayah::firstOrCreate(
                    ['id' => $nextDesaId],
                    [
                        'desa_id' => $nextDesaId,
                        'desa_nama' => $request->desa_nama
                    ]
                );

                // 2. Baru insert data kota (child)
                $wilayah = new Wilayah();
                $wilayah->kota_id = $nextKotaId;
                $wilayah->kota_nama = $request->nama;
                $wilayah->kecamatan_id = $nextKecamatanId;
                $wilayah->kecamatan_nama = $request->kecamatan_nama;
                $wilayah->desa_id = $desa->id;
                $wilayah->desa_nama = $desa->desa_nama;
                $wilayah->save();
                break;

            case 'kecamatan':
                $request->validate([
                    'kota_id' => 'required|integer',
                    'desa_nama' => 'required|string|max:255',
                ], [
                    'kota_id.required' => 'Kota wajib dipilih.',
                    'kota_id.integer' => 'ID kota harus berupa angka.',
                    'desa_nama.required' => 'Nama desa wajib diisi.',
                    'desa_nama.string' => 'Nama desa harus berupa teks.',
                    'desa_nama.max' => 'Nama desa tidak boleh lebih dari 255 karakter.',
                ]);
                
                // Check if kota exists
                $kotaInfo = Wilayah::where('kota_id', $request->kota_id)
                                    ->whereNotNull('kota_nama')
                                    ->select('kota_id', 'kota_nama')
                                    ->first();
                
                if (!$kotaInfo) {
                    return redirect()->back()
                        ->withInput()
                        ->with('error', 'Kota yang dipilih tidak ditemukan.');
                }
                
                // Check if kecamatan already exists for this kota
                $existingKecamatan = Wilayah::where('kota_id', $request->kota_id)
                                           ->where('kecamatan_nama', $request->nama)
                                           ->whereNotNull('kecamatan_nama') // Check if it's a valid district entry
                                           ->first();
                
                if ($existingKecamatan) {
                    return redirect()->back()
                        ->withInput()
                        ->with('error', 'Kecamatan dengan nama tersebut sudah ada di kota ini.');
                }

                // Get next available global IDs for kecamatan and its default desa
                $nextKecamatanId = (Wilayah::max('kecamatan_id') ?? 0) + 1;
                $nextDesaId = (Wilayah::max('id') ?? 0) + 1;

                // 1. Insert/cek data desa (parent) dulu, isi juga kolom id
                $desa = Wilayah::firstOrCreate(
                    ['id' => $nextDesaId],
                    [
                        'desa_id' => $nextDesaId,
                        'desa_nama' => $request->desa_nama
                    ]
                );

                // 2. Baru insert data kecamatan (child)
                $wilayah = new Wilayah();
                $wilayah->kota_id = $kotaInfo->kota_id;
                $wilayah->kota_nama = $kotaInfo->kota_nama;
                $wilayah->kecamatan_id = $nextKecamatanId;
                $wilayah->kecamatan_nama = $request->nama;
                $wilayah->desa_id = $desa->id;
                $wilayah->desa_nama = $desa->desa_nama;
                $wilayah->save();
                break;

            case 'desa':
                $request->validate([
                    'kota_id' => 'required|integer',
                    'kecamatan_id' => 'required|integer',
                ], [
                    'kota_id.required' => 'Kota wajib dipilih.',
                    'kota_id.integer' => 'ID kota harus berupa angka.',
                    'kecamatan_id.required' => 'Kecamatan wajib dipilih.',
                    'kecamatan_id.integer' => 'ID kecamatan harus berupa angka.',
                ]);

                // Check if kota exists
                $kotaInfo = Wilayah::where('kota_id', $request->kota_id)
                                    ->whereNotNull('kota_nama')
                                    ->select('kota_id', 'kota_nama')
                                    ->first();
                
                if (!$kotaInfo) {
                    return redirect()->back()
                        ->withInput()
                        ->with('error', 'Kota yang dipilih tidak ditemukan.');
                }

                // Check if kecamatan exists under this kota
                $kecamatanInfo = Wilayah::where('kota_id', $request->kota_id)
                                        ->where('kecamatan_id', $request->kecamatan_id)
                                        ->whereNotNull('kecamatan_nama')
                                        ->select('kecamatan_id', 'kecamatan_nama')
                                        ->first();
                
                if (!$kecamatanInfo) {
                    return redirect()->back()
                        ->withInput()
                        ->with('error', 'Kecamatan yang dipilih tidak ditemukan di kota ini.');
                }

                // Check if desa already exists in this kecamatan
                $existingDesa = Wilayah::where('kota_id', $request->kota_id)
                                      ->where('kecamatan_id', $request->kecamatan_id)
                                      ->where('desa_nama', $request->nama)
                                      ->first();
                
                if ($existingDesa) {
                    return redirect()->back()
                        ->withInput()
                        ->with('error', 'Desa dengan nama tersebut sudah ada di kecamatan ini.');
                }

                // Get next available global desa_id
                $nextDesaId = (Wilayah::max('desa_id') ?? 0) + 1;
                
                // Create a new wilayah entry for the desa
                $wilayah = new Wilayah();
                $wilayah->kota_id = $kotaInfo->kota_id;
                $wilayah->kota_nama = $kotaInfo->kota_nama;
                $wilayah->kecamatan_id = $kecamatanInfo->kecamatan_id;
                $wilayah->kecamatan_nama = $kecamatanInfo->kecamatan_nama;
                $wilayah->desa_id = $nextDesaId;
                $wilayah->desa_nama = $request->nama;
                $wilayah->save();
                break;
        }

        return redirect()->route('staff.wilayah.index')
            ->with('success', 'Wilayah berhasil ditambahkan');
    }

    public function edit($type, $id)
    {
        // Debug selesai, hapus dd()
        // $allData = Wilayah::all();
        // $specificData = Wilayah::where('id', $id)->first();
        // $desaData = Wilayah::where('id', $id)->whereNotNull('desa_nama')->first();
        // dd([
        //     'type' => $type,
        //     'id' => $id,
        //     'all_data_count' => $allData->count(),
        //     'specific_data' => $specificData ? $specificData->toArray() : null,
        //     'desa_data' => $desaData ? $desaData->toArray() : null,
        //     'first_5_records' => $allData->take(5)->toArray()
        // ]);
        
        $wilayah = null;

        switch ($type) {
            case 'kota':
                $wilayah = Wilayah::where('kota_id', $id)->whereNotNull('kota_nama')->first();
                break;
            case 'kecamatan':
                $wilayah = Wilayah::where('kecamatan_id', $id)->whereNotNull('kecamatan_nama')->first();
                break;
            case 'desa':
                // Untuk desa, cari berdasarkan primary key (id) bukan desa_id
                $wilayah = Wilayah::where('id', $id)->whereNotNull('desa_nama')->first();
                break;
            default:
                return redirect()->route('staff.wilayah.index')
                    ->with('error', 'Tipe wilayah tidak valid.');
        }

        if (!$wilayah) {
            return redirect()->route('staff.wilayah.index')
                ->with('error', 'Wilayah dengan ID ' . $id . ' dan tipe ' . $type . ' tidak ditemukan');
        }

        // Ambil daftar kota untuk dropdown
        $kotas = Wilayah::select('kota_id', 'kota_nama')
                        ->whereNotNull('kota_nama')
                        ->groupBy('kota_id', 'kota_nama')
                        ->orderBy('kota_nama')
                        ->get();

        // Ambil daftar kecamatan untuk dropdown (jika edit desa)
        $kecamatans = collect();
        if ($type === 'desa' && $wilayah->kota_id) {
            $kecamatans = Wilayah::where('kota_id', $wilayah->kota_id)
                                ->select('kecamatan_id', 'kecamatan_nama')
                                ->whereNotNull('kecamatan_nama')
                                ->groupBy('kecamatan_id', 'kecamatan_nama')
                                ->orderBy('kecamatan_nama')
                                ->get();
        }

        // Menggunakan $tipe alih-alih $type untuk konsistensi dengan view
        $tipe = $type;

        return view('staff.wilayah.edit', compact('wilayah', 'tipe', 'kotas', 'kecamatans', 'id'));
    }

    public function update(Request $request, $type, $id)
    {
        // Cari wilayah sesuai tipe
        $wilayah = null;
        switch ($type) {
            case 'kota':
                $wilayah = Wilayah::where('kota_id', $id)->whereNotNull('kota_nama')->first();
                break;
            case 'kecamatan':
                $wilayah = Wilayah::where('kecamatan_id', $id)->whereNotNull('kecamatan_nama')->first();
                break;
            case 'desa':
                $wilayah = Wilayah::where('id', $id)->whereNotNull('desa_nama')->first();
                break;
            default:
                return redirect()->route('staff.wilayah.index')
                    ->with('error', 'Tipe wilayah tidak valid.');
        }

        if (!$wilayah) {
            return redirect()->route('staff.wilayah.index')
                ->with('error', 'Wilayah tidak ditemukan');
        }

        $validated = $request->validate([
            'nama' => 'required|string|max:255',
        ]);

        try {
            switch ($type) {
                case 'kota':
                    // Update nama kota di semua record yang memiliki kota_id ini
                    Wilayah::where('kota_id', $id)->update(['kota_nama' => $request->nama]);
                    break;
                case 'kecamatan':
                    // Update nama kecamatan di semua record yang memiliki kecamatan_id ini
                    Wilayah::where('kecamatan_id', $id)->update(['kecamatan_nama' => $request->nama]);
                    break;
                case 'desa':
                    // Update nama desa di record yang spesifik
                    Wilayah::where('id', $id)->update(['desa_nama' => $request->nama]);
                    break;
            }

            return redirect()->route('staff.wilayah.index')
                ->with('success', 'Wilayah berhasil diperbarui');
        } catch (\Exception $e) {
            return redirect()->route('staff.wilayah.index')
                ->with('error', 'Gagal memperbarui wilayah: ' . $e->getMessage());
        }
    }

    public function destroy($type, $id)
    {
        $wilayah = null;

        switch ($type) {
            case 'kota':
                $wilayah = Wilayah::where('kota_id', $id)->whereNotNull('kota_nama')->first();
                break;
            case 'kecamatan':
                $wilayah = Wilayah::where('kecamatan_id', $id)->whereNotNull('kecamatan_nama')->first();
                break;
            case 'desa':
                // Untuk desa, cari berdasarkan primary key (id) bukan desa_id
                $wilayah = Wilayah::where('id', $id)->whereNotNull('desa_nama')->first();
                break;
            default:
                return redirect()->route('staff.wilayah.index')
                    ->with('error', 'Tipe wilayah tidak valid.');
        }

        if (!$wilayah) {
            return redirect()->route('staff.wilayah.index')
                ->with('error', 'Wilayah tidak ditemukan');
        }

        try {
            switch ($type) {
                case 'kota':
                    // Hapus semua record yang memiliki kota_id ini
                    Wilayah::where('kota_id', $id)->delete();
                    break;
                case 'kecamatan':
                    // Hapus semua record yang memiliki kecamatan_id ini
                    Wilayah::where('kecamatan_id', $id)->delete();
                    break;
                case 'desa':
                    // Hapus record desa spesifik
                    $wilayah->delete();
                    break;
            }
            
            return redirect()->route('staff.wilayah.index')
                ->with('success', 'Wilayah berhasil dihapus');
        } catch (\Exception $e) {
            return redirect()->route('staff.wilayah.index')
                ->with('error', 'Gagal menghapus wilayah: ' . $e->getMessage());
        }
    }

    // API endpoints for dynamic dropdowns
    public function getKecamatan($kotaId)
    {
        $kecamatans = Wilayah::where('kota_id', $kotaId)
                            ->select('kecamatan_id', 'kecamatan_nama')
                            ->whereNotNull('kecamatan_nama')
                            ->groupBy('kecamatan_id', 'kecamatan_nama')
                            ->orderBy('kecamatan_nama')
                            ->get();

        return response()->json($kecamatans);
    }

    public function getDesa($kecamatanId)
    {
        $desas = Wilayah::where('kecamatan_id', $kecamatanId)
                        ->select('desa_id', 'desa_nama')
                        ->whereNotNull('desa_nama')
                        ->groupBy('desa_id', 'desa_nama')
                        ->orderBy('desa_nama')
                        ->get();

        return response()->json($desas);
    }
}
