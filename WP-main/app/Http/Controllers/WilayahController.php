<?php

namespace App\Http\Controllers;

use App\Models\Wilayah;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
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
        $desas = Wilayah::select('desa_id', 'desa_nama', 'kecamatan_id', 'kecamatan_nama', 'kota_id', 'kota_nama')
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
        ]);

        switch ($request->tipe) {
            case 'kota':
                // Check if kota already exists
                $existingKota = Wilayah::where('kota_nama', $request->nama)
                                      ->whereNotNull('kota_nama') // Check if it's a valid city entry
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
                ]);

                // Get next available global IDs
                $nextKotaId = (Wilayah::max('kota_id') ?? 0) + 1;
                $nextKecamatanId = (Wilayah::max('kecamatan_id') ?? 0) + 1;
                $nextDesaId = (Wilayah::max('desa_id') ?? 0) + 1;
                
                // Create a new wilayah entry for the kota with its default kecamatan and desa
                $wilayah = new Wilayah();
                $wilayah->kota_id = $nextKotaId;
                $wilayah->kota_nama = $request->nama;
                $wilayah->kecamatan_id = $nextKecamatanId;
                $wilayah->kecamatan_nama = $request->kecamatan_nama;
                $wilayah->desa_id = $nextDesaId;
                $wilayah->desa_nama = $request->desa_nama;
                $wilayah->save();
                break;

            case 'kecamatan':
                $request->validate([
                    'kota_id' => 'required|integer',
                    'desa_nama' => 'required|string|max:255',
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
                $nextDesaId = (Wilayah::max('desa_id') ?? 0) + 1;
                
                // Create a new wilayah entry for the kecamatan with its default desa
                $wilayah = new Wilayah();
                $wilayah->kota_id = $kotaInfo->kota_id;
                $wilayah->kota_nama = $kotaInfo->kota_nama;
                $wilayah->kecamatan_id = $nextKecamatanId;
                $wilayah->kecamatan_nama = $request->nama;
                $wilayah->desa_id = $nextDesaId;
                $wilayah->desa_nama = $request->desa_nama;
                $wilayah->save();
                break;

            case 'desa':
                $request->validate([
                    'kota_id' => 'required|integer',
                    'kecamatan_id' => 'required|integer',
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
        $wilayah = null;

        switch ($type) {
            case 'kota':
                $wilayah = Wilayah::where('kota_id', $id)->whereNotNull('kota_nama')->first();
                break;
            case 'kecamatan':
                $wilayah = Wilayah::where('kecamatan_id', $id)->whereNotNull('kecamatan_nama')->first();
                break;
            case 'desa':
                $wilayah = Wilayah::where('desa_id', $id)->whereNotNull('desa_nama')->first();
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

        return view('staff.wilayah.edit', compact('wilayah', 'type', 'kotas', 'kecamatans', 'id'));
    }

    public function update(Request $request, $id)
    {
        // Gunakan helper function untuk mencari wilayah
        $result = $this->findWilayahById($id);
        $wilayah = $result['wilayah'];
        $tipe = $result['tipe'];

        if (!$wilayah) {
            return redirect()->route('staff.wilayah.index')
                ->with('error', 'Wilayah tidak ditemukan');
        }

        $validated = $request->validate([
            'nama' => 'required|string|max:255',
        ]);

        try {
            switch ($tipe) {
                case 'kota':
                    // Update nama kota di semua record yang memiliki kota_id ini
                    Wilayah::where('kota_id', $id)->update(['kota_nama' => $request->nama]);
                    break;
                case 'kecamatan':
                    // Update nama kecamatan di semua record yang memiliki kecamatan_id ini
                    Wilayah::where('kota_id', $wilayah->kota_id)
                          ->where('kecamatan_id', $id)
                          ->update(['kecamatan_nama' => $request->nama]);
                    break;
                case 'desa':
                    // Update nama desa di record yang spesifik
                    Wilayah::where('kota_id', $wilayah->kota_id)
                          ->where('kecamatan_id', $wilayah->kecamatan_id)
                          ->where('desa_id', $id)
                          ->update(['desa_nama' => $request->nama]);
                    break;
            }

            return redirect()->route('staff.wilayah.index')
                ->with('success', 'Wilayah berhasil diperbarui');
        } catch (\Exception $e) {
            return redirect()->route('staff.wilayah.index')
                ->with('error', 'Gagal memperbarui wilayah: ' . $e->getMessage());
        }
    }

    public function destroy($id)
    {
        // Gunakan helper function untuk mencari wilayah
        $result = $this->findWilayahById($id);
        $wilayah = $result['wilayah'];
        $tipe = $result['tipe'];

        if (!$wilayah) {
            return redirect()->route('staff.wilayah.index')
                ->with('error', 'Wilayah tidak ditemukan');
        }

        try {
            switch ($tipe) {
                case 'kota':
                    // Hapus semua data yang terkait dengan kota ini
                    Wilayah::where('kota_id', $id)->delete();
                    break;
                case 'kecamatan':
                    // Hapus semua data yang terkait dengan kecamatan ini
                    Wilayah::where('kota_id', $wilayah->kota_id)
                          ->where('kecamatan_id', $id)
                          ->delete();
                    break;
                case 'desa':
                    // Hapus hanya desa ini
                    Wilayah::where('kota_id', $wilayah->kota_id)
                          ->where('kecamatan_id', $wilayah->kecamatan_id)
                          ->where('desa_id', $id)
                          ->delete();
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
        // Ambil pasangan unik kecamatan_id dan kecamatan_nama untuk kota yang dipilih
        // Hanya kecamatan yang memiliki desa (kecamatan yang aktif)
        $kecamatan = Wilayah::where('kota_id', $kotaId)
            ->select('kecamatan_id', 'kecamatan_nama')
            ->whereNotNull('kecamatan_nama') // Pastikan nama kecamatan tidak null
            ->whereNotNull('desa_nama') // Hanya kecamatan yang memiliki desa
            ->groupBy('kecamatan_id', 'kecamatan_nama') // Kelompokkan untuk mendapatkan pasangan unik
            ->orderBy('kecamatan_nama') // Urutkan untuk tampilan yang lebih baik
            ->get();

        // Format data agar sesuai dengan harapan frontend (JavaScript mengharapkan 'id' dan 'kecamatan_nama')
        $formattedKecamatan = $kecamatan->map(function ($item) {
            return [
                'id' => $item->kecamatan_id,
                'kecamatan_nama' => $item->kecamatan_nama,
            ];
        });

        return response()->json($formattedKecamatan);
    }

    public function getDesa($kecamatanId)
    {
        // Ambil id (primary key) dan desa_nama yang unik untuk kecamatan yang dipilih
        // Diasumsikan 'id' adalah identifier unik untuk setiap entri desa di tabel ini
        $desa = Wilayah::where('kecamatan_id', $kecamatanId)
            ->select('id', 'desa_nama')
            ->whereNotNull('desa_nama') // Pastikan nama desa tidak null
            ->groupBy('id', 'desa_nama') // Kelompokkan untuk mendapatkan pasangan unik (id, desa_nama)
            ->orderBy('desa_nama') // Urutkan untuk tampilan yang lebih baik
            ->get();

        // Tidak perlu memetakan 'id' karena kita sudah memilih kolom 'id' secara langsung.
        return response()->json($desa);
    }

    /**
     * Helper function untuk mencari wilayah berdasarkan ID
     */
    private function findWilayahById($id)
    {
    
        $desa = Wilayah::where('desa_id', $id)->first();
        if ($desa) {
            return ['wilayah' => $desa, 'tipe' => 'desa'];
        }

        // Cek apakah ada record dengan kecamatan_id = $id
        $kecamatan = Wilayah::where('kecamatan_id', $id)->first();
        if ($kecamatan) {
            return ['wilayah' => $kecamatan, 'tipe' => 'kecamatan'];
        }

        // Cek apakah ada record dengan kota_id = $id
        $kota = Wilayah::where('kota_id', $id)->first();
        if ($kota) {
            return ['wilayah' => $kota, 'tipe' => 'kota'];
        }

        return ['wilayah' => null, 'tipe' => null];
    }
}
