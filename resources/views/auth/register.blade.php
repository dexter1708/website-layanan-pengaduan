<x-guest-layout>
    <!-- Add jQuery before the form -->
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    
    <form method="POST" action="{{ route('register') }}">
        @csrf

        <!-- Name -->
        <div>
            <x-input-label for="name" :value="__('Name')" />
            <x-text-input id="name" class="block mt-1 w-full" type="text" name="name" :value="old('name')" required autofocus autocomplete="name" />
            <x-input-error :messages="$errors->get('name')" class="mt-2" />
        </div>

        <!-- Email -->
        <div class="mt-4">
            <x-input-label for="email" :value="__('Email')" />
            <x-text-input id="email" class="block mt-1 w-full" type="email" name="email" :value="old('email')" required autocomplete="username" />
            <x-input-error :messages="$errors->get('email')" class="mt-2" />
        </div>

        <!-- NIK -->
        <div class="mt-4">
            <x-input-label for="nik" :value="__('NIK')" />
            <x-text-input id="nik" class="block mt-1 w-full" type="text" name="nik" :value="old('nik')" required />
            <x-input-error :messages="$errors->get('nik')" class="mt-2" />
        </div>

        <!-- Nomor Telepon -->
        <div class="mt-4">
            <x-input-label for="no_telepon" :value="__('Nomor Telepon')" />
            <x-text-input id="no_telepon" class="block mt-1 w-full" type="tel" name="no_telepon" :value="old('no_telepon')" required placeholder="08xxxxxxxxxx" />
            <x-input-error :messages="$errors->get('no_telepon')" class="mt-2" />
        </div>

        <!-- Kota -->
        <div class="mt-4">
            <x-input-label for="kota" :value="__('Kota')" />
            <select id="kota" name="kota" class="block mt-1 w-full" required>
                <option value="">--Pilih Kota--</option>
                @foreach ($kotas as $kota)
                    <option value="{{ $kota->kota_id }}">{{ $kota->kota_nama }}</option>
                @endforeach
            </select>
            <x-input-error :messages="$errors->get('kota')" class="mt-2" />
        </div>

        <!-- Kecamatan -->
        <div class="mt-4">
            <x-input-label for="kecamatan" :value="__('Kecamatan')" />
            <select id="kecamatan" name="kecamatan" class="block mt-1 w-full" required>
                <option value="">--Pilih Kecamatan--</option>
            </select>
            <x-input-error :messages="$errors->get('kecamatan')" class="mt-2" />
        </div>

        <!-- Desa -->
        <div class="mt-4">
            <x-input-label for="desa" :value="__('Desa')" />
            <select id="desa" name="desa" class="block mt-1 w-full" required>
                <option value="">--Pilih Desa--</option>
            </select>
            <x-input-error :messages="$errors->get('desa')" class="mt-2" />
        </div>

        <!-- RT -->
        <div class="mt-4">
            <x-input-label for="RT" :value="__('RT')" />
            <x-text-input id="RT" class="block mt-1 w-full" type="text" name="RT" :value="old('RT')" required />
            <x-input-error :messages="$errors->get('RT')" class="mt-2" />
        </div>

        <!-- RW -->
        <div class="mt-4">
            <x-input-label for="RW" :value="__('RW')" />
            <x-text-input id="RW" class="block mt-1 w-full" type="text" name="RW" :value="old('RW')" required />
            <x-input-error :messages="$errors->get('RW')" class="mt-2" />
        </div>

        <!-- Password -->
        <div class="mt-4">
            <x-input-label for="password" :value="__('Password')" />
            <x-text-input id="password" class="block mt-1 w-full" type="password" name="password" required autocomplete="new-password" />
            <x-input-error :messages="$errors->get('password')" class="mt-2" />
        </div>

        <!-- Confirm Password -->
        <div class="mt-4">
            <x-input-label for="password_confirmation" :value="__('Confirm Password')" />
            <x-text-input id="password_confirmation" class="block mt-1 w-full" type="password" name="password_confirmation" required autocomplete="new-password" />
            <x-input-error :messages="$errors->get('password_confirmation')" class="mt-2" />
        </div>

        <div class="flex items-center justify-end mt-4">
            <a class="underline text-sm text-gray-600 hover:text-gray-900 rounded-md focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500" href="{{ route('login') }}">
                {{ __('Already registered?') }}
            </a>

            <x-primary-button class="ms-4">
                {{ __('Register') }}
            </x-primary-button>
        </div>
    </form>

    <script type="text/javascript">
        $(document).ready(function() {
            // Ketika kota dipilih, ambil kecamatan yang sesuai
            $('#kota').on('change', function() {
                var kota_id = $(this).val();
                if (kota_id) {
                    $.ajax({
                        url: '/api/kecamatan/' + kota_id,
                        type: 'GET',
                        success: function(data) {
                            $('#kecamatan').empty();
                            $('#kecamatan').append('<option value="">--Pilih Kecamatan--</option>');
                            $.each(data, function(key, value) {
                                $('#kecamatan').append('<option value="'+ value.id +'">' + value.kecamatan_nama +'</option>');
                            });
                            // Reset desa dropdown
                            $('#desa').empty();
                            $('#desa').append('<option value="">--Pilih Desa--</option>');
                        },
                        error: function() {
                            alert('Terjadi kesalahan saat mengambil data kecamatan');
                        }
                    });
                } else {
                    // Reset both dropdowns if no kota selected
                    $('#kecamatan').empty();
                    $('#kecamatan').append('<option value="">--Pilih Kecamatan--</option>');
                    $('#desa').empty();
                    $('#desa').append('<option value="">--Pilih Desa--</option>');
                }
            });

            // Ketika kecamatan dipilih, ambil desa yang sesuai
            $('#kecamatan').on('change', function() {
                var kecamatan_id = $(this).val();
                if (kecamatan_id) {
                    $.ajax({
                        url: '/api/desa/' + kecamatan_id,
                        type: 'GET',
                        success: function(data) {
                            $('#desa').empty();
                            $('#desa').append('<option value="">--Pilih Desa--</option>');
                            $.each(data, function(key, value) {
                                $('#desa').append('<option value="'+ value.id +'">' + value.desa_nama +'</option>');
                            });
                        },
                        error: function() {
                            alert('Terjadi kesalahan saat mengambil data desa');
                        }
                    });
                } else {
                    // Reset desa dropdown if no kecamatan selected
                    $('#desa').empty();
                    $('#desa').append('<option value="">--Pilih Desa--</option>');
                }
            });
        });
    </script>
</x-guest-layout>
