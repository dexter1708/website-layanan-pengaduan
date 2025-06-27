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
            'kecamatan' => ['required', 'exists:wilayah,kecamatan_id'],
            'desa' => ['required', 'exists:wilayah,desa_id'],
            'RT' => ['required', 'numeric'],
            'RW' => ['required', 'numeric'],
        ], [
            'name.required' => 'Nama wajib diisi.',
            'name.string' => 'Nama harus berupa teks.',
            'name.max' => 'Nama tidak boleh lebih dari 255 karakter.',
            
            'email.required' => 'Email wajib diisi.',
            'email.string' => 'Email harus berupa teks.',
            'email.lowercase' => 'Email harus menggunakan huruf kecil.',
            'email.email' => 'Format email tidak valid.',
            'email.max' => 'Email tidak boleh lebih dari 255 karakter.',
            'email.unique' => 'Email sudah digunakan.',
            
            'nik.required' => 'NIK wajib diisi.',
            'nik.string' => 'NIK harus berupa teks.',
            'nik.unique' => 'NIK sudah digunakan.',
            
            'no_telepon.required' => 'Nomor telepon wajib diisi.',
            'no_telepon.string' => 'Nomor telepon harus berupa teks.',
            'no_telepon.regex' => 'Format nomor telepon tidak valid (gunakan format 08xxxxxxxxxx).',
            'no_telepon.unique' => 'Nomor telepon sudah digunakan.',
            
            'password.required' => 'Password wajib diisi.',
            'password.confirmed' => 'Konfirmasi password tidak cocok.',
            
            'kota.required' => 'Kota wajib dipilih.',
            'kota.exists' => 'Kota yang dipilih tidak valid.',
            
            'kecamatan.required' => 'Kecamatan wajib dipilih.',
            'kecamatan.exists' => 'Kecamatan yang dipilih tidak valid.',
            
            'desa.required' => 'Desa wajib dipilih.',
            'desa.exists' => 'Desa yang dipilih tidak valid.',
            
            'RT.required' => 'RT wajib diisi.',
            'RT.numeric' => 'RT harus berupa angka.',
            
            'RW.required' => 'RW wajib diisi.',
            'RW.numeric' => 'RW harus berupa angka.',
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
