@extends('template.main')
@section('content_template')

<div class="py-12">
    <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
        <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
            <div class="p-6 text-gray-900">
                <!-- Header -->
                <div class="mb-6">
                    <h1 class="text-3xl font-bold text-gray-900 mb-2">
                        Tambah Wilayah
                    </h1>
                    <p class="text-gray-600">
                        Tambahkan data wilayah baru (Kota, Kecamatan, Desa) ke dalam sistem.
                    </p>
                </div>

                <!-- Informasi Hierarki -->
                <div class="mb-6 p-4 bg-blue-50 border border-blue-200 rounded-lg">
                    <h3 class="text-lg font-semibold text-blue-800 mb-2">Informasi Hierarki Wilayah:</h3>
                    <ul class="text-blue-700 space-y-1">
                        <li>• <strong>Kota:</strong> Harus memiliki minimal 1 Kecamatan</li>
                        <li>• <strong>Kecamatan:</strong> Harus memiliki minimal 1 Desa</li>
                        <li>• <strong>Desa:</strong> Dapat ditambahkan ke Kecamatan yang sudah ada</li>
                    </ul>
                </div>

                <form action="{{ route('staff.wilayah.store') }}" method="POST">
                    @csrf

                    <div class="mb-4">
                        <label for="tipe" class="block text-sm font-medium text-gray-700 mb-2">Jenis Wilayah</label>
                        <select name="tipe" id="tipe" class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500" required onchange="toggleFields()">
                            <option value="">Pilih Jenis Wilayah</option>
                            <option value="kota" {{ old('tipe') == 'kota' ? 'selected' : '' }}>Kota</option>
                            <option value="kecamatan" {{ old('tipe') == 'kecamatan' ? 'selected' : '' }}>Kecamatan</option>
                            <option value="desa" {{ old('tipe') == 'desa' ? 'selected' : '' }}>Desa</option>
                        </select>
                        @error('tipe')
                            <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                        @enderror
                    </div>

                    <!-- Informasi Hierarki -->
                    <div class="mb-4 p-3 bg-blue-50 border border-blue-200 rounded-lg">
                        <p class="text-blue-800 text-sm">
                            <strong>Informasi:</strong> 
                            <span id="hierarchy-info">Pilih jenis wilayah untuk melihat informasi hierarki</span>
                        </p>
                    </div>

                    <!-- Kota Fields -->
                    <div id="kota-fields" class="hidden">
                        <div class="mb-4">
                            <label for="nama_kota" class="block text-sm font-medium text-gray-700 mb-2">Nama Kota</label>
                            <input type="text" name="nama" id="nama_kota" value="{{ old('nama') }}" class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500" placeholder="Masukkan nama kota">
                            @error('kota_nama')
                                <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                            @enderror
                        </div>

                        <div class="mb-4">
                            <label for="kecamatan_nama" class="block text-sm font-medium text-gray-700 mb-2">Nama Kecamatan Pertama</label>
                            <input type="text" name="kecamatan_nama" id="kecamatan_nama" value="{{ old('kecamatan_nama') }}" class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500" placeholder="Masukkan nama kecamatan">
                            <p class="mt-1 text-sm text-gray-500">Kota baru harus memiliki minimal 1 kecamatan</p>
                            @error('kecamatan_nama')
                                <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                            @enderror
                        </div>

                        <div class="mb-4">
                            <label for="desa_nama_kota" class="block text-sm font-medium text-gray-700 mb-2">Nama Desa Pertama</label>
                            <input type="text" name="desa_nama" id="desa_nama_kota" value="{{ old('desa_nama') }}" class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500" placeholder="Masukkan nama desa">
                            <p class="mt-1 text-sm text-gray-500">Kecamatan baru harus memiliki minimal 1 desa</p>
                            @error('desa_nama')
                                <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                            @enderror
                        </div>
                    </div>

                    <!-- Kecamatan Fields -->
                    <div id="kecamatan-fields" class="hidden">
                        <div class="mb-4">
                            <label for="kota_id" class="block text-sm font-medium text-gray-700 mb-2">Kota</label>
                            <select name="kota_id" id="kota_id" class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500">
                                <option value="">Pilih Kota</option>
                                @foreach($kotas ?? [] as $item)
                                    <option value="{{ $item->kota_id }}" {{ old('kota_id') == $item->kota_id ? 'selected' : '' }}>{{ $item->kota_nama }}</option>
                                @endforeach
                            </select>
                            @error('kota_id')
                                <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                            @enderror
                        </div>

                        <div class="mb-4">
                            <label for="nama_kecamatan" class="block text-sm font-medium text-gray-700 mb-2">Nama Kecamatan</label>
                            <input type="text" name="nama" id="nama_kecamatan" value="{{ old('nama') }}" class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500" placeholder="Masukkan nama kecamatan">
                            @error('kecamatan_nama')
                                <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                            @enderror
                        </div>

                        <div class="mb-4">
                            <label for="desa_nama_kecamatan" class="block text-sm font-medium text-gray-700 mb-2">Nama Desa Pertama</label>
                            <input type="text" name="desa_nama" id="desa_nama_kecamatan" value="{{ old('desa_nama') }}" class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500" placeholder="Masukkan nama desa">
                            <p class="mt-1 text-sm text-gray-500">Kecamatan baru harus memiliki minimal 1 desa</p>
                            @error('desa_nama')
                                <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                            @enderror
                        </div>
                    </div>

                    <!-- Desa Fields -->
                    <div id="desa-fields" class="hidden">
                        <div class="mb-4">
                            <label for="kota_id_desa" class="block text-sm font-medium text-gray-700 mb-2">Kota</label>
                            <select name="kota_id" id="kota_id_desa" class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500" onchange="loadKecamatan()">
                                <option value="">Pilih Kota</option>
                                @foreach($kotas ?? [] as $item)
                                    <option value="{{ $item->kota_id }}" {{ old('kota_id') == $item->kota_id ? 'selected' : '' }}>{{ $item->kota_nama }}</option>
                                @endforeach
                            </select>
                            @error('kota_id')
                                <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                            @enderror
                        </div>

                        <div class="mb-4">
                            <label for="kecamatan_id" class="block text-sm font-medium text-gray-700 mb-2">Kecamatan</label>
                            <select name="kecamatan_id" id="kecamatan_id" class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500">
                                <option value="">Pilih Kecamatan</option>
                            </select>
                            @error('kecamatan_id')
                                <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                            @enderror
                        </div>

                        <div class="mb-4">
                            <label for="nama_desa" class="block text-sm font-medium text-gray-700 mb-2">Nama Desa</label>
                            <input type="text" name="nama" id="nama_desa" value="{{ old('nama') }}" class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500" placeholder="Masukkan nama desa">
                            @error('desa_nama')
                                <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                            @enderror
                        </div>
                    </div>

                    <div class="flex items-center justify-end mt-6">
                        <a href="{{ route('staff.wilayah.index') }}" class="bg-gray-500 hover:bg-gray-700 text-white font-bold py-2 px-4 rounded mr-2">
                            Batal
                        </a>
                        <button type="submit" class="bg-blue-500 hover:bg-blue-700 text-white font-bold py-2 px-4 rounded" onclick="return validateForm()">
                            Simpan
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>

<script>
    function toggleFields() {
        const tipe = document.getElementById('tipe').value;
        const hierarchyInfo = document.getElementById('hierarchy-info');
        
        // Hide all field groups and remove required attributes
        const kotaFields = document.getElementById('kota-fields');
        const kecamatanFields = document.getElementById('kecamatan-fields');
        const desaFields = document.getElementById('desa-fields');
        
        kotaFields.classList.add('hidden');
        kecamatanFields.classList.add('hidden');
        desaFields.classList.add('hidden');
        
        // Remove required from all fields in hidden sections
        kotaFields.querySelectorAll('input, select').forEach(field => {
            field.removeAttribute('required');
        });
        kecamatanFields.querySelectorAll('input, select').forEach(field => {
            field.removeAttribute('required');
        });
        desaFields.querySelectorAll('input, select').forEach(field => {
            field.removeAttribute('required');
        });

        // Show selected field group and add required attributes
        if (tipe === 'kota') {
            kotaFields.classList.remove('hidden');
            kotaFields.querySelectorAll('input, select').forEach(field => {
                field.setAttribute('required', 'required');
            });
            hierarchyInfo.textContent = 'Kota baru akan otomatis membuat 1 Kecamatan dan 1 Desa pertama';
        } else if (tipe === 'kecamatan') {
            kecamatanFields.classList.remove('hidden');
            kecamatanFields.querySelectorAll('input, select').forEach(field => {
                field.setAttribute('required', 'required');
            });
            hierarchyInfo.textContent = 'Kecamatan baru akan otomatis membuat 1 Desa pertama';
        } else if (tipe === 'desa') {
            desaFields.classList.remove('hidden');
            desaFields.querySelectorAll('input, select').forEach(field => {
                field.setAttribute('required', 'required');
            });
            hierarchyInfo.textContent = 'Desa baru akan ditambahkan ke Kecamatan yang sudah ada';
        } else {
            hierarchyInfo.textContent = 'Pilih jenis wilayah untuk melihat informasi hierarki';
        }
    }

    function loadKecamatan() {
        const kotaId = document.getElementById('kota_id_desa').value;
        const kecamatanSelect = document.getElementById('kecamatan_id');
        
        // Clear kecamatan options
        kecamatanSelect.innerHTML = '<option value="">Pilih Kecamatan</option>';
        
        if (kotaId) {
            // Fetch kecamatan data via AJAX
            fetch(`/staff/wilayah/get-kecamatan/${kotaId}`)
                .then(response => response.json())
                .then(data => {
                    data.forEach(kecamatan => {
                        const option = document.createElement('option');
                        option.value = kecamatan.kecamatan_id;
                        option.textContent = kecamatan.kecamatan_nama;
                        kecamatanSelect.appendChild(option);
                    });
                })
                .catch(error => {
                    console.error('Error loading kecamatan:', error);
                });
        }
    }

    function validateForm() {
        const tipe = document.getElementById('tipe').value;
        
        if (!tipe) {
            alert('Silakan pilih jenis wilayah');
            return false;
        }
        
        return true;
    }

    // Initialize on page load
    document.addEventListener('DOMContentLoaded', function() {
        toggleFields();
    });
</script>

@endsection 