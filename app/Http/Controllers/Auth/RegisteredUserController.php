<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Models\User;
use App\Models\Alamat;
use App\Models\Wilayah; 
use Illuminate\Auth\Events\Registered;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\Rules;
use Illuminate\View\View;

class RegisteredUserController extends Controller
{
    /**
     * Display the registration view.
     */
    public function create(): View
    {
        $kotas = Wilayah::select('kota_id', 'kota_nama')
                        ->whereNotNull('kota_nama')
                        ->groupBy('kota_id', 'kota_nama')
                        ->orderBy('kota_nama')
                        ->get();
        return view('auth.register', compact('kotas'));
    }

    /**
     * Handle an incoming registration request.
     */
    public function store(Request $request): RedirectResponse
    {
        // Validasi input
        $request->validate([
            'name' => ['required', 'string', 'max:255'],
            'email' => ['required', 'string', 'lowercase', 'email', 'max:255', 'unique:'.User::class],
            'nik' => ['required', 'string', 'unique:users,nik'],
            'no_telepon' => ['required', 'string', 'regex:/^08[0-9]{8,11}$/', 'unique:users,no_telepon'],
            'password' => ['required', 'confirmed', Rules\Password::defaults()],
            'kota' => ['required', 'exists:wilayah,kota_id'],
            'kecamatan' => ['required', 'exists:wilayah,kecamatan_id'],  // Validasi kecamatan berdasarkan kota
            'desa' => ['required', 'exists:wilayah,desa_id'],  // Validasi desa berdasarkan kecamatan
            'RT' => ['required', 'numeric'],
            'RW' => ['required', 'numeric'],
        ]);
        
        $wilayah = Wilayah::where('kota_id', $request->kota)
            ->where('kecamatan_id', $request->kecamatan)
            ->where('desa_id', 'like', $request->desa . '%')
            ->firstOrFail();
        
        // Simpan user
        $user = User::create([
            'name' => $request->name,
            'email' => $request->email,
            'nik' => $request->nik,
            'no_telepon' => $request->no_telepon,
            'password' => Hash::make($request->password),
            'role' => 'pelapor',
        ]);

        // Simpan alamat berelasi ke user (polymorphic)
        $user->alamat()->create([
            'nama' => $user->name,
            'sebagai' => 'user',
            'kota' => $wilayah->kota_nama,
            'kecamatan' => $wilayah->kecamatan_nama,
            'desa' => $wilayah->desa_nama,
            'RT' => $request->RT,
            'RW' => $request->RW,
        ]);

        event(new Registered($user));

        // Jangan login user secara otomatis
        // Auth::login($user);

        // Redirect ke halaman login dengan pesan sukses
        return redirect()->route('login')->with('status', 'Registrasi berhasil! Silakan login dengan akun Anda.');
    }
}
