<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Tambah Wilayah') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 text-gray-900">
                    <form action="{{ route('staff.wilayah.store') }}" method="POST">
                        @csrf

                        <div class="mb-4">
                            <label for="type" class="block text-sm font-medium text-gray-700">Jenis Wilayah</label>
                            <select name="type" id="type" class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500" required onchange="toggleFields()">
                                <option value="">Pilih Jenis Wilayah</option>
                                <option value="kota" {{ old('type') == 'kota' ? 'selected' : '' }}>Kota</option>
                                <option value="kecamatan" {{ old('type') == 'kecamatan' ? 'selected' : '' }}>Kecamatan</option>
                                <option value="desa" {{ old('type') == 'desa' ? 'selected' : '' }}>Desa</option>
                            </select>
                            @error('type')
                                <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                            @enderror
                        </div>

                        <!-- Kota Fields -->
                        <div id="kota-fields" class="hidden">
                            <div class="mb-4">
                                <label for="kota_nama" class="block text-sm font-medium text-gray-700">Nama Kota</label>
                                <input type="text" name="kota_nama" id="kota_nama" value="{{ old('kota_nama') }}" class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500" required>
                                @error('kota_nama')
                                    <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                                @enderror
                            </div>
                        </div>

                        <!-- Kecamatan Fields -->
                        <div id="kecamatan-fields" class="hidden">
                            <div class="mb-4">
                                <label for="kota_id" class="block text-sm font-medium text-gray-700">Kota</label>
                                <select name="kota_id" id="kota_id" class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500" required>
                                    <option value="">Pilih Kota</option>
                                    @foreach($kota as $item)
                                        <option value="{{ $item->id }}" {{ old('kota_id') == $item->id ? 'selected' : '' }}>{{ $item->kota_nama }}</option>
                                    @endforeach
                                </select>
                                @error('kota_id')
                                    <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                                @enderror
                            </div>

                            <div class="mb-4">
                                <label for="kecamatan_nama" class="block text-sm font-medium text-gray-700">Nama Kecamatan</label>
                                <input type="text" name="kecamatan_nama" id="kecamatan_nama" value="{{ old('kecamatan_nama') }}" class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500" required>
                                @error('kecamatan_nama')
                                    <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                                @enderror
                            </div>
                        </div>

                        <!-- Desa Fields -->
                        <div id="desa-fields" class="hidden">
                            <div class="mb-4">
                                <label for="kota_id_desa" class="block text-sm font-medium text-gray-700">Kota</label>
                                <select name="kota_id" id="kota_id_desa" class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500" required onchange="loadKecamatan()">
                                    <option value="">Pilih Kota</option>
                                    @foreach($kota as $item)
                                        <option value="{{ $item->id }}" {{ old('kota_id') == $item->id ? 'selected' : '' }}>{{ $item->kota_nama }}</option>
                                    @endforeach
                                </select>
                                @error('kota_id')
                                    <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                                @enderror
                            </div>

                            <div class="mb-4">
                                <label for="kecamatan_id" class="block text-sm font-medium text-gray-700">Kecamatan</label>
                                <select name="kecamatan_id" id="kecamatan_id" class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500" required>
                                    <option value="">Pilih Kecamatan</option>
                                </select>
                                @error('kecamatan_id')
                                    <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                                @enderror
                            </div>

                            <div class="mb-4">
                                <label for="desa_nama" class="block text-sm font-medium text-gray-700">Nama Desa</label>
                                <input type="text" name="desa_nama" id="desa_nama" value="{{ old('desa_nama') }}" class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500" required>
                                @error('desa_nama')
                                    <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                                @enderror
                            </div>
                        </div>

                        <div class="flex items-center justify-end mt-4">
                            <a href="{{ route('staff.wilayah.index') }}" class="bg-gray-500 hover:bg-gray-700 text-white font-bold py-2 px-4 rounded mr-2">
                                Batal
                            </a>
                            <button type="submit" class="bg-blue-500 hover:bg-blue-700 text-white font-bold py-2 px-4 rounded">
                                Simpan
                            </button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>

    @push('scripts')
    <script>
        function toggleFields() {
            const type = document.getElementById('type').value;
            
            // Hide all field groups
            document.getElementById('kota-fields').classList.add('hidden');
            document.getElementById('kecamatan-fields').classList.add('hidden');
            document.getElementById('desa-fields').classList.add('hidden');

            // Show selected field group
            if (type) {
                document.getElementById(type + '-fields').classList.remove('hidden');
            }

            // If desa is selected and kota is already chosen, load kecamatan
            if (type === 'desa' && document.getElementById('kota_id_desa').value) {
                loadKecamatan();
            }
        }

        function loadKecamatan() {
            const kotaId = document.getElementById('kota_id_desa').value;
            const kecamatanSelect = document.getElementById('kecamatan_id');
            
            // Clear current options
            kecamatanSelect.innerHTML = '<option value="">Pilih Kecamatan</option>';

            if (kotaId) {
                // Fetch kecamatan data
                fetch(`/staff/wilayah/kecamatan/${kotaId}`)
                    .then(response => response.json())
                    .then(data => {
                        data.forEach(kecamatan => {
                            const option = document.createElement('option');
                            option.value = kecamatan.id;
                            option.textContent = kecamatan.kecamatan_nama;
                            kecamatanSelect.appendChild(option);
                        });

                        // If there's an old value, select it
                        const oldKecamatanId = '{{ old('kecamatan_id') }}';
                        if (oldKecamatanId) {
                            kecamatanSelect.value = oldKecamatanId;
                        }
                    });
            }
        }

        // Initialize fields on page load
        document.addEventListener('DOMContentLoaded', function() {
            toggleFields();
        });
    </script>
    @endpush
</x-app-layout> 