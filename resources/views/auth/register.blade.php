<x-guest-layout>
    <style>
        body {
            background-color: #f0f2f5;
        }
        .register-container {
            background-color: white;
            padding: 2.5rem;
            width: 75%;
            margin: 2rem auto;
            border-radius: 0.75rem;
            box-shadow: 0 4px 6px -1px rgb(0 0 0 / 0.1), 0 2px 4px -2px rgb(0 0 0 / 0.1);
        }
        .register-logo {
            display: flex;
            justify-content: center;
            margin-bottom: 1rem;
        }
        .register-logo img {
            height: 5rem;
        }
        .form-grid {
            display: grid;
            grid-template-columns: repeat(1, minmax(0, 1fr));
            gap: 1.5rem;
        }
        @media (min-width: 768px) {
            .form-grid {
                grid-template-columns: repeat(2, minmax(0, 1fr));
            }
        }
        .form-group {
            margin-bottom: 0;
        }
        .form-group.full-width {
            grid-column: 1 / -1;
        }
        .form-label {
            display: block;
            margin-bottom: 0.5rem;
            font-weight: 500;
            color: #4a5568;
            font-size: 0.875rem;
        }
        .form-input {
            width: 100%;
            padding: 0.75rem;
            border: 1px solid #e2e8f0;
            border-radius: 0.375rem;
            background-color: #f7fafc;
            transition: border-color 0.2s;
        }
        .form-input:focus {
            outline: none;
            border-color: #4299e1;
            box-shadow: 0 0 0 1px #4299e1;
        }
        .btn-register {
            width: 100%;
            padding: 0.75rem;
            border-radius: 0.375rem;
            background-color: #3b82f6;
            color: white;
            font-weight: 600;
            border: none;
            cursor: pointer;
            transition: background-color 0.2s;
        }
        .btn-register:hover {
            background-color: #2563eb;
        }
        .login-link {
            text-align: center;
            margin-top: 1rem;
            font-size: 0.875rem;
            color: #4a5568;
        }
        .login-link a {
            color: #3b82f6;
            font-weight: 500;
            text-decoration: none;
        }
        .login-link a:hover {
            text-decoration: underline;
        }
    </style>

    <div class="register-container">
        <div class="register-logo">
            <img src="{{ asset('assets/image.png') }}" alt="Logo">
        </div>
        
        <form method="POST" action="{{ route('register') }}" class="mt-8">
            @csrf
            <h2 class="text-2xl font-bold text-gray-900 mb-6">Register</h2>
            <div class="form-grid">
                <!-- Nama Lengkap -->
                <div class="form-group">
                    <label for="name" class="form-label">Nama Lengkap</label>
                    <input id="name" type="text" name="name" :value="old('name')" required autofocus autocomplete="name" class="form-input" placeholder="Nama">
                    <x-input-error :messages="$errors->get('name')" class="mt-2" />
                </div>
                
                <!-- NIK -->
                <div class="form-group">
                    <label for="nik" class="form-label">NIK</label>
                    <input id="nik" type="text" name="nik" :value="old('nik')" required class="form-input" placeholder="NIK">
                    <x-input-error :messages="$errors->get('nik')" class="mt-2" />
                </div>
                
                <!-- Email -->
                <div class="form-group">
                    <label for="email" class="form-label">Email</label>
                    <input id="email" type="email" name="email" :value="old('email')" required autocomplete="username" class="form-input" placeholder="Email">
                    <x-input-error :messages="$errors->get('email')" class="mt-2" />
                </div>
                
                <!-- No Handphone -->
                <div class="form-group">
                    <label for="no_telepon" class="form-label">No Handphone</label>
                    <input id="no_telepon" type="tel" name="no_telepon" :value="old('no_telepon')" required class="form-input" placeholder="No Handphone">
                    <x-input-error :messages="$errors->get('no_telepon')" class="mt-2" />
                </div>
                
                <!-- Password -->
                <div class="form-group">
                    <label for="password" class="form-label">Password</label>
                    <input id="password" type="password" name="password" required autocomplete="new-password" class="form-input" placeholder="Password">
                    <x-input-error :messages="$errors->get('password')" class="mt-2" />
                </div>
                
                <!-- Konfirmasi Password -->
                <div class="form-group">
                    <label for="password_confirmation" class="form-label">Konfirmasi Password</label>
                    <input id="password_confirmation" type="password" name="password_confirmation" required autocomplete="new-password" class="form-input" placeholder="Konfirmasi Password">
                    <x-input-error :messages="$errors->get('password_confirmation')" class="mt-2" />
                </div>
                
                <!-- Kabupaten/Kota -->
                <div class="form-group">
                    <label for="kota" class="form-label">Kabupaten/ Kota</label>
                    <select id="kota" name="kota" required class="form-input">
                        <option value="">--Pilih Kabupaten/ Kota--</option>
                        @foreach ($kotas as $kota)
                            <option value="{{ $kota->kota_id }}" {{ old('kota') == $kota->kota_id ? 'selected' : '' }}>{{ $kota->kota_nama }}</option>
                        @endforeach
                    </select>
                    <x-input-error :messages="$errors->get('kota')" class="mt-2" />
                </div>
                
                <!-- Kecamatan -->
                <div class="form-group">
                    <label for="kecamatan" class="form-label">Kecamatan</label>
                    <select id="kecamatan" name="kecamatan" required class="form-input">
                        <option value="">--Pilih Kecamatan--</option>
                    </select>
                    <x-input-error :messages="$errors->get('kecamatan')" class="mt-2" />
                </div>

                <!-- Kelurahan/Desa -->
                <div class="form-group">
                    <label for="desa" class="form-label">Kelurahan</label>
                    <select id="desa" name="desa" required class="form-input">
                        <option value="">--Pilih Kelurahan--</option>
                    </select>
                    <x-input-error :messages="$errors->get('desa')" class="mt-2" />
                </div>
                
                <!-- RT -->
                <div class="form-group">
                    <label for="RT" class="form-label">RT</label>
                    <input id="RT" type="text" name="RT" value="{{ old('RT') }}" required class="form-input" placeholder="RT">
                    <x-input-error :messages="$errors->get('RT')" class="mt-2" />
                </div>

                <!-- RW -->
                <div class="form-group">
                    <label for="RW" class="form-label">RW</label>
                    <input id="RW" type="text" name="RW" value="{{ old('RW') }}" required class="form-input" placeholder="RW">
                    <x-input-error :messages="$errors->get('RW')" class="mt-2" />
                </div>

                <div class="form-group full-width">
                    <button type="submit" class="btn-register">
                        Registrasi
                    </button>
                </div>
            </div>
        </form>

        <div class="login-link">
            Sudah punya akun? <a href="{{ route('login') }}">Login disini</a>
        </div>
    </div>

    <script>
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
</x-guest-layout>
