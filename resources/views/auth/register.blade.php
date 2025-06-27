<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Register</title>
    <!-- Tailwind CDN -->
    <script src="https://cdn.tailwindcss.com"></script>
    <!-- Font Awesome untuk ikon -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/all.min.css" />
</head>
<body class="min-h-screen flex items-center justify-center bg-cover bg-center" style="background-image: url('{{ asset('assets/image7.jpg') }}')">
    <div class="w-full max-w-3xl bg-white rounded-xl shadow-lg p-8 md:p-12 mx-auto">
        <div class="flex flex-col items-center mb-6">
            <img src="{{ asset('assets/image.png') }}" alt="Logo" class="h-16 mb-2">
            <h2 class="text-3xl font-bold text-gray-900 mb-2">Register</h2>
        </div>
        <form method="POST" action="{{ route('register') }}" class="mt-4">
            @csrf
            <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                <!-- Nama Lengkap -->
                <div>
                    <label for="name" class="block text-sm font-medium text-gray-700 mb-1">Nama Lengkap</label>
                    <input id="name" type="text" name="name" :value="old('name')" required autofocus autocomplete="name" class="w-full px-3 py-2 border border-gray-300 rounded-md focus:ring-blue-500 focus:border-blue-500" placeholder="Nama">
                    <x-input-error :messages="$errors->get('name')" class="mt-2" />
                </div>
                <!-- NIK -->
                <div>
                    <label for="nik" class="block text-sm font-medium text-gray-700 mb-1">NIK</label>
                    <input id="nik" type="text" name="nik" :value="old('nik')" required class="w-full px-3 py-2 border border-gray-300 rounded-md focus:ring-blue-500 focus:border-blue-500" placeholder="NIK">
                    <x-input-error :messages="$errors->get('nik')" class="mt-2" />
                </div>
                <!-- Email -->
                <div>
                    <label for="email" class="block text-sm font-medium text-gray-700 mb-1">Email</label>
                    <input id="email" type="email" name="email" :value="old('email')" required autocomplete="username" class="w-full px-3 py-2 border border-gray-300 rounded-md focus:ring-blue-500 focus:border-blue-500" placeholder="Email">
                    <x-input-error :messages="$errors->get('email')" class="mt-2" />
                </div>
                <!-- No Handphone -->
                <div>
                    <label for="no_telepon" class="block text-sm font-medium text-gray-700 mb-1">No Handphone</label>
                    <input id="no_telepon" type="tel" name="no_telepon" :value="old('no_telepon')" required class="w-full px-3 py-2 border border-gray-300 rounded-md focus:ring-blue-500 focus:border-blue-500" placeholder="No Handphone">
                    <x-input-error :messages="$errors->get('no_telepon')" class="mt-2" />
                </div>
                <!-- Password -->
                <div>
                    <label for="password" class="block text-sm font-medium text-gray-700 mb-1">Password</label>
                    <div class="relative">
                        <input id="password" type="password" name="password" required autocomplete="new-password" class="w-full px-3 py-2 border border-gray-300 rounded-md focus:ring-blue-500 focus:border-blue-500 pr-10" placeholder="Password">
                        <button type="button" class="absolute right-2 top-1/2 -translate-y-1/2 text-gray-500" onclick="togglePassword('password', 'eyeIcon1')">
                            <i id="eyeIcon1" class="fas fa-eye"></i>
                        </button>
                    </div>
                    <x-input-error :messages="$errors->get('password')" class="mt-2" />
                </div>
                <!-- Konfirmasi Password -->
                <div>
                    <label for="password_confirmation" class="block text-sm font-medium text-gray-700 mb-1">Konfirmasi Password</label>
                    <div class="relative">
                        <input id="password_confirmation" type="password" name="password_confirmation" required autocomplete="new-password" class="w-full px-3 py-2 border border-gray-300 rounded-md focus:ring-blue-500 focus:border-blue-500 pr-10" placeholder="Konfirmasi Password">
                        <button type="button" class="absolute right-2 top-1/2 -translate-y-1/2 text-gray-500" onclick="togglePassword('password_confirmation', 'eyeIcon2')">
                            <i id="eyeIcon2" class="fas fa-eye"></i>
                        </button>
                    </div>
                    <x-input-error :messages="$errors->get('password_confirmation')" class="mt-2" />
                </div>
                <!-- Kabupaten/Kota -->
                <div>
                    <label for="kota" class="block text-sm font-medium text-gray-700 mb-1">Kabupaten/ Kota</label>
                    <select id="kota" name="kota" required class="w-full px-3 py-2 border border-gray-300 rounded-md focus:ring-blue-500 focus:border-blue-500">
                        <option value="">--Pilih Kabupaten/ Kota--</option>
                        @foreach ($kotas as $kota)
                            <option value="{{ $kota->kota_id }}" {{ old('kota') == $kota->kota_id ? 'selected' : '' }}>{{ $kota->kota_nama }}</option>
                        @endforeach
                    </select>
                    <x-input-error :messages="$errors->get('kota')" class="mt-2" />
                </div>
                <!-- Kecamatan -->
                <div>
                    <label for="kecamatan" class="block text-sm font-medium text-gray-700 mb-1">Kecamatan</label>
                    <select id="kecamatan" name="kecamatan" required class="w-full px-3 py-2 border border-gray-300 rounded-md focus:ring-blue-500 focus:border-blue-500">
                        <option value="">--Pilih Kecamatan--</option>
                    </select>
                    <x-input-error :messages="$errors->get('kecamatan')" class="mt-2" />
                </div>
                <!-- Kelurahan -->
                <div>
                    <label for="desa" class="block text-sm font-medium text-gray-700 mb-1">Kelurahan</label>
                    <select id="desa" name="desa" required class="w-full px-3 py-2 border border-gray-300 rounded-md focus:ring-blue-500 focus:border-blue-500">
                        <option value="">--Pilih Kelurahan--</option>
                    </select>
                    <x-input-error :messages="$errors->get('desa')" class="mt-2" />
                </div>
                <!-- RT -->
                <div>
                    <label for="RT" class="block text-sm font-medium text-gray-700 mb-1">RT</label>
                    <input id="RT" type="text" name="RT" value="{{ old('RT') }}" required class="w-full px-3 py-2 border border-gray-300 rounded-md focus:ring-blue-500 focus:border-blue-500" placeholder="RT">
                    <x-input-error :messages="$errors->get('RT')" class="mt-2" />
                </div>
                <!-- RW -->
                <div>
                    <label for="RW" class="block text-sm font-medium text-gray-700 mb-1">RW</label>
                    <input id="RW" type="text" name="RW" value="{{ old('RW') }}" required class="w-full px-3 py-2 border border-gray-300 rounded-md focus:ring-blue-500 focus:border-blue-500" placeholder="RW">
                    <x-input-error :messages="$errors->get('RW')" class="mt-2" />
                </div>
            </div>
            <button type="submit" class="w-full mt-8 py-3 rounded-lg bg-blue-600 text-white font-semibold text-lg hover:bg-blue-700 transition">Registrasi</button>
            <div class="text-center mt-4 text-sm text-gray-600">
                Sudah punya akun? <a href="{{ route('login') }}" class="text-blue-500 hover:underline">Login disini</a>
            </div>
        </form>
    </div>
    <script>
        function togglePassword(inputId, iconId) {
            const input = document.getElementById(inputId);
            const icon = document.getElementById(iconId);
            if (input.type === 'password') {
                input.type = 'text';
                icon.classList.remove('fa-eye');
                icon.classList.add('fa-eye-slash');
            } else {
                input.type = 'password';
                icon.classList.remove('fa-eye-slash');
                icon.classList.add('fa-eye');
            }
        }

        document.addEventListener('DOMContentLoaded', function() {
            const kotaSelect = document.getElementById('kota');
            const kecamatanSelect = document.getElementById('kecamatan');
            const desaSelect = document.getElementById('desa');

            const oldKecamatan = "{{ old('kecamatan') }}";
            const oldDesa = "{{ old('desa') }}";

            async function fetchKecamatan(kotaId) {
                kecamatanSelect.innerHTML = '<option value="">Memuat...</option>';
                desaSelect.innerHTML = '<option value="">--Pilih Kelurahan--</option>';
                try {
                    const response = await fetch(`/api/kecamatan/${kotaId}`);
                    if (!response.ok) throw new Error('Network response was not ok');
                    const data = await response.json();
                    
                    kecamatanSelect.innerHTML = '<option value="">--Pilih Kecamatan--</option>';
                    data.forEach(item => {
                        const option = new Option(item.kecamatan_nama, item.kecamatan_id);
                        kecamatanSelect.add(option);
                    });
                    
                    if (oldKecamatan) {
                        kecamatanSelect.value = oldKecamatan;
                        kecamatanSelect.dispatchEvent(new Event('change')); // Trigger change to load desa
                    }
                } catch (error) {
                    console.error('Error fetching kecamatan:', error);
                    kecamatanSelect.innerHTML = '<option value="">Gagal memuat</option>';
                }
            }

            async function fetchDesa(kecamatanId) {
                desaSelect.innerHTML = '<option value="">Memuat...</option>';
                try {
                    const response = await fetch(`/api/desa/${kecamatanId}`);
                    if (!response.ok) throw new Error('Network response was not ok');
                    const data = await response.json();
                    
                    desaSelect.innerHTML = '<option value="">--Pilih Kelurahan--</option>';
                    data.forEach(item => {
                        const option = new Option(item.desa_nama, item.desa_id);
                        desaSelect.add(option);
                    });
                    
                    if (oldDesa) {
                        desaSelect.value = oldDesa;
                    }

                } catch (error) {
                    console.error('Error fetching desa:', error);
                    desaSelect.innerHTML = '<option value="">Gagal memuat</option>';
                }
            }

            kotaSelect.addEventListener('change', function() {
                if (this.value) {
                    fetchKecamatan(this.value);
                } else {
                    kecamatanSelect.innerHTML = '<option value="">--Pilih Kecamatan--</option>';
                    desaSelect.innerHTML = '<option value="">--Pilih Kelurahan--</option>';
                }
            });

            kecamatanSelect.addEventListener('change', function() {
                if (this.value) {
                    fetchDesa(this.value);
                } else {
                    desaSelect.innerHTML = '<option value="">--Pilih Kelurahan--</option>';
                }
            });

            // If there's an old value for kota, trigger the load for kecamatan
            if (kotaSelect.value) {
                fetchKecamatan(kotaSelect.value);
            }
        });
    </script>
</body>
</html>
