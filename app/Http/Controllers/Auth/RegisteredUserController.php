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
        $kotas = Wilayah::select('kota_id', 'kota_nama')->distinct()->get();
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
            'foto_ktp' => ['nullable', 'image', 'max:2048'],
            'password' => ['required', 'confirmed', Rules\Password::defaults()],
            'kota' => ['required', 'exists:wilayah,kota_id'],
            'kecamatan' => ['required', 'exists:wilayah,kecamatan_id'],  // Validasi kecamatan berdasarkan kota
            'desa' => ['required', 'exists:wilayah,desa_id'],  // Validasi desa berdasarkan kecamatan
            'RT' => ['required', 'integer'],
            'RW' => ['required', 'integer'],
        ]);
        $wilayah = Wilayah::where('kota_id', $request->kota)
        ->where('kecamatan_id', $request->kecamatan)
        ->where('desa_id', $request->desa)
        ->firstOrFail();
;
        // Menyimpan foto KTP jika ada
        $fotoKtpPath = null;
        if ($request->hasFile('foto_ktp')) {
            $fotoKtpPath = $request->file('foto_ktp')->store('ktp', 'public');
        }

        
        // Simpan user
        $user = User::create([
            'name' => $request->name,
            'email' => $request->email,
            'nik' => $request->nik,
            'foto_ktp' => $fotoKtpPath,
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

        // Login user yang baru dibuat
        Auth::login($user);

        // Redirect ke halaman dashboard
        return redirect(route('dashboard', absolute: false));
    }
}
