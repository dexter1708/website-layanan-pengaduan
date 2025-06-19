<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Buat Pengaduan Baru') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 text-gray-900">
                    @if ($errors->any())
                        <div class="bg-red-100 border border-red-400 text-red-700 px-4 py-3 rounded relative mb-4" role="alert">
                            <ul>
                                @foreach ($errors->all() as $error)
                                    <li>{{ $error }}</li>
                                @endforeach
                            </ul>
                        </div>
                    @endif

                    <form action="{{ route('pengaduan.store') }}" method="POST" enctype="multipart/form-data">
                        @csrf
                        
                        <!-- Informasi Pelapor (Read-only) -->
                        <div class="mb-6">
                            <h3 class="text-lg font-medium text-gray-900 mb-4">Informasi Pelapor</h3>
                            <div class="bg-gray-50 p-4 rounded-lg">
                                <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                                    <div>
                                        <label class="block text-sm font-medium text-gray-700">Nama</label>
                                        <p class="mt-1 text-sm text-gray-900">{{ $user->name }}</p>
                                    </div>
                                    <div>
                                        <label class="block text-sm font-medium text-gray-700">Email</label>
                                        <p class="mt-1 text-sm text-gray-900">{{ $user->email }}</p>
                                    </div>
                                    <div>
                                        <label class="block text-sm font-medium text-gray-700">Telepon</label>
                                        <p class="mt-1 text-sm text-gray-900">{{ $user->telepon }}</p>
                                    </div>
                                    <div>
                                        <label class="block text-sm font-medium text-gray-700">Alamat</label>
                                        <p class="mt-1 text-sm text-gray-900">{{ $user->alamat }}</p>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <!-- Informasi Pengaduan -->
                        <div class="mb-6">
                            <h3 class="text-lg font-medium text-gray-900 mb-4">Informasi Pengaduan</h3>
                            
                            <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                                <div>
                                    <label for="judul" class="block text-sm font-medium text-gray-700">Judul Pengaduan</label>
                                    <input type="text" name="judul" id="judul" value="{{ old('judul') }}" 
                                           class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500" required>
                                </div>

                                <div>
                                    <label for="kategori" class="block text-sm font-medium text-gray-700">Kategori</label>
                                    <select name="kategori" id="kategori" 
                                            class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500" required>
                                        <option value="">Pilih Kategori</option>
                                        <option value="kekerasan_fisik" {{ old('kategori') == 'kekerasan_fisik' ? 'selected' : '' }}>Kekerasan Fisik</option>
                                        <option value="kekerasan_psikis" {{ old('kategori') == 'kekerasan_psikis' ? 'selected' : '' }}>Kekerasan Psikis</option>
                                        <option value="kekerasan_seksual" {{ old('kategori') == 'kekerasan_seksual' ? 'selected' : '' }}>Kekerasan Seksual</option>
                                        <option value="penelantaran" {{ old('kategori') == 'penelantaran' ? 'selected' : '' }}>Penelantaran</option>
                                        <option value="lainnya" {{ old('kategori') == 'lainnya' ? 'selected' : '' }}>Lainnya</option>
                                    </select>
                                </div>
                            </div>

                            <div class="mt-4">
                                <label for="deskripsi" class="block text-sm font-medium text-gray-700">Deskripsi Kejadian</label>
                                <textarea name="deskripsi" id="deskripsi" rows="4" 
                                          class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500" required>{{ old('deskripsi') }}</textarea>
                            </div>

                            <div class="grid grid-cols-1 md:grid-cols-2 gap-4 mt-4">
                                <div>
                                    <label for="tanggal_kejadian" class="block text-sm font-medium text-gray-700">Tanggal Kejadian</label>
                                    <input type="date" name="tanggal_kejadian" id="tanggal_kejadian" value="{{ old('tanggal_kejadian') }}" 
                                           class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500" required>
                                </div>

                                <div>
                                    <label for="lokasi_kejadian" class="block text-sm font-medium text-gray-700">Lokasi Kejadian</label>
                                    <input type="text" name="lokasi_kejadian" id="lokasi_kejadian" value="{{ old('lokasi_kejadian') }}" 
                                           class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500" required>
                                </div>
                            </div>

                            <!-- Wilayah Kejadian -->
                            <div class="grid grid-cols-1 md:grid-cols-3 gap-4 mt-4">
                                <div>
                                    <label for="kota_id" class="block text-sm font-medium text-gray-700">Kota/Kabupaten</label>
                                    <select name="kota_id" id="kota_id" 
                                            class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500" required>
                                        <option value="">Pilih Kota</option>
                                        @foreach($kotas as $kota)
                                            <option value="{{ $kota->kota_id }}" {{ old('kota_id') == $kota->kota_id ? 'selected' : '' }}>
                                                {{ $kota->kota_nama }}
                                            </option>
                                        @endforeach
                                    </select>
                                </div>

                                <div>
                                    <label for="kecamatan_id" class="block text-sm font-medium text-gray-700">Kecamatan</label>
                                    <select name="kecamatan_id" id="kecamatan_id" 
                                            class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500" required>
                                        <option value="">Pilih Kecamatan</option>
                                    </select>
                                </div>

                                <div>
                                    <label for="desa_id" class="block text-sm font-medium text-gray-700">Desa/Kelurahan</label>
                                    <select name="desa_id" id="desa_id" 
                                            class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500" required>
                                        <option value="">Pilih Desa</option>
                                    </select>
                                </div>
                            </div>

                            <div class="mt-4">
                                <label for="bukti" class="block text-sm font-medium text-gray-700">Bukti Pendukung (Opsional)</label>
                                <input type="file" name="bukti" id="bukti" 
                                       class="mt-1 block w-full text-sm text-gray-500 file:mr-4 file:py-2 file:px-4 file:rounded-md file:border-0 file:text-sm file:font-semibold file:bg-indigo-50 file:text-indigo-700 hover:file:bg-indigo-100"
                                       accept=".jpg,.jpeg,.png,.pdf">
                                <p class="mt-1 text-sm text-gray-500">Format: JPG, JPEG, PNG, PDF (Max: 2MB)</p>
                            </div>
                        </div>

                        <!-- Informasi Korban -->
                        <div class="mb-6">
                            <h3 class="text-lg font-medium text-gray-900 mb-4">Informasi Korban</h3>
                            
                            <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                                <div>
                                    <label for="nama_korban" class="block text-sm font-medium text-gray-700">Nama Korban</label>
                                    <input type="text" name="nama_korban" id="nama_korban" value="{{ old('nama_korban') }}" 
                                           class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500" required>
                                </div>

                                <div>
                                    <label for="umur_korban" class="block text-sm font-medium text-gray-700">Umur Korban</label>
                                    <input type="number" name="umur_korban" id="umur_korban" value="{{ old('umur_korban') }}" 
                                           class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500" required>
                                </div>
                            </div>

                            <div class="grid grid-cols-1 md:grid-cols-2 gap-4 mt-4">
                                <div>
                                    <label for="no_telepon_korban" class="block text-sm font-medium text-gray-700">Nomor Telepon Korban</label>
                                    <input type="tel" name="no_telepon_korban" id="no_telepon_korban" value="{{ old('no_telepon_korban') }}" 
                                           class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500" 
                                           placeholder="08xxxxxxxxxx" required>
                                </div>

                                <div>
                                    <label for="jenis_kelamin_korban" class="block text-sm font-medium text-gray-700">Jenis Kelamin Korban</label>
                                    <select name="jenis_kelamin_korban" id="jenis_kelamin_korban" 
                                            class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500" required>
                                        <option value="">Pilih Jenis Kelamin</option>
                                        <option value="L" {{ old('jenis_kelamin_korban') == 'L' ? 'selected' : '' }}>Laki-laki</option>
                                        <option value="P" {{ old('jenis_kelamin_korban') == 'P' ? 'selected' : '' }}>Perempuan</option>
                                    </select>
                                </div>
                            </div>

                            <div class="grid grid-cols-1 md:grid-cols-2 gap-4 mt-4">
                                <div>
                                    <label for="hubungan_dengan_korban" class="block text-sm font-medium text-gray-700">Hubungan dengan Korban</label>
                                    <select name="hubungan_dengan_korban" id="hubungan_dengan_korban" 
                                            class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500" required>
                                        <option value="">Pilih Hubungan</option>
                                        <option value="keluarga" {{ old('hubungan_dengan_korban') == 'keluarga' ? 'selected' : '' }}>Keluarga</option>
                                        <option value="tetangga" {{ old('hubungan_dengan_korban') == 'tetangga' ? 'selected' : '' }}>Tetangga</option>
                                        <option value="teman" {{ old('hubungan_dengan_korban') == 'teman' ? 'selected' : '' }}>Teman</option>
                                        <option value="lainnya" {{ old('hubungan_dengan_korban') == 'lainnya' ? 'selected' : '' }}>Lainnya</option>
                                    </select>
                                </div>
                            </div>

                            <div class="mt-4">
                                <label for="alamat_korban" class="block text-sm font-medium text-gray-700">Alamat Korban</label>
                                <textarea name="alamat_korban" id="alamat_korban" rows="2" 
                                          class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500" required>{{ old('alamat_korban') }}</textarea>
                            </div>
                        </div>

                        <div class="flex justify-end">
                            <button type="submit" class="bg-indigo-600 hover:bg-indigo-700 text-white font-bold py-2 px-4 rounded">
                                Kirim Pengaduan
                            </button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>

    @push('scripts')
    <script>
        // Handle dynamic wilayah selection
        document.getElementById('kota_id').addEventListener('change', function() {
            const kotaId = this.value;
            const kecamatanSelect = document.getElementById('kecamatan_id');
            const desaSelect = document.getElementById('desa_id');

            // Clear kecamatan and desa options
            kecamatanSelect.innerHTML = '<option value="">Pilih Kecamatan</option>';
            desaSelect.innerHTML = '<option value="">Pilih Desa</option>';

            if (kotaId) {
                fetch(`/api/kecamatan/${kotaId}`)
                    .then(response => response.json())
                    .then(data => {
                        data.forEach(kecamatan => {
                            const option = new Option(kecamatan.nama, kecamatan.id);
                            kecamatanSelect.add(option);
                        });
                    });
            }
        });

        document.getElementById('kecamatan_id').addEventListener('change', function() {
            const kecamatanId = this.value;
            const desaSelect = document.getElementById('desa_id');

            // Clear desa options
            desaSelect.innerHTML = '<option value="">Pilih Desa</option>';

            if (kecamatanId) {
                fetch(`/api/desa/${kecamatanId}`)
                    .then(response => response.json())
                    .then(data => {
                        data.forEach(desa => {
                            const option = new Option(desa.nama, desa.id);
                            desaSelect.add(option);
                        });
                    });
            }
        });

        // Initialize wilayah selection if there are old values
        @if(old('kota_id'))
            document.getElementById('kota_id').dispatchEvent(new Event('change'));
            @if(old('kecamatan_id'))
                setTimeout(() => {
                    document.getElementById('kecamatan_id').value = '{{ old('kecamatan_id') }}';
                    document.getElementById('kecamatan_id').dispatchEvent(new Event('change'));
                    @if(old('desa_id'))
                        setTimeout(() => {
                            document.getElementById('desa_id').value = '{{ old('desa_id') }}';
                        }, 500);
                    @endif
                }, 500);
            @endif
        @endif
    </script>
    @endpush
</x-app-layout> 