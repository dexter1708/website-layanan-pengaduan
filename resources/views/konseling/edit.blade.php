<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Edit Jadwal Konseling') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            @if($errors->any())
                <div class="bg-red-100 border border-red-400 text-red-700 px-4 py-3 rounded relative mb-4" role="alert">
                    <ul>
                        @foreach($errors->all() as $error)
                            <li>{{ $error }}</li>
                        @endforeach
                    </ul>
                </div>
            @endif

            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 text-gray-900">
                    <form method="POST" action="{{ route('staff.konseling.update', $konseling->id) }}" class="space-y-6">
                        @csrf
                        @method('PUT')

                        <!-- Hidden Korban ID -->
                         <input type="hidden" name="korban_id" id="korban_id" value="{{ old('korban_id', $konseling->korban_id) }}" required>

                        <!-- Pengaduan -->
                        <div>
                            <x-input-label for="pengaduan_id" :value="__('Pilih Pengaduan')" />
                            {{-- Dropdown pengaduan akan menampilkan pengaduan yang terkait dengan konseling ini --}}
                            {{-- dan mungkin pengaduan lain yang belum memiliki konseling --}}
                            {{-- Kita bisa disable dropdown setelah dipilih untuk mencegah perubahan korban --}}
                            <select id="pengaduan_id" name="pengaduan_id" class="mt-1 block w-full border-gray-300 focus:border-indigo-500 focus:ring-indigo-500 rounded-md shadow-sm" required disabled>
                                <option value="">Pilih Pengaduan</option>
                                @foreach($pengaduans as $pengaduan)
                                    @foreach($pengaduan->korban as $korban)
                                         <option value="{{ $pengaduan->id }}" 
                                                 data-korban-id="{{ $korban->id }}" 
                                                 {{ old('pengaduan_id', $konseling->pengaduan_id) == $pengaduan->id ? 'selected' : '' }}>
                                            {{ $pengaduan->id }} - {{ $korban->nama }}
                                        </option>
                                    @endforeach
                                @endforeach
                            </select>
                            {{-- Kirim pengaduan_id dan korban_id via hidden input karena dropdown disabled --}}
                             <input type="hidden" name="pengaduan_id" value="{{ old('pengaduan_id', $konseling->pengaduan_id) }}">
                            <x-input-error :messages="$errors->get('pengaduan_id')" class="mt-2" />
                            <x-input-error :messages="$errors->get('korban_id')" class="mt-2" />
                        </div>

                        <!-- Nama Konselor -->
                        <div>
                            <x-input-label for="nama_konselor" :value="__('Nama Konselor')" />
                            <x-text-input id="nama_konselor" 
                                         class="block mt-1 w-full" 
                                         type="text" 
                                         name="nama_konselor" 
                                         :value="old('nama_konselor', $konseling->nama_konselor)" 
                                         required />
                            <x-input-error :messages="$errors->get('nama_konselor')" class="mt-2" />
                        </div>

                        <!-- Jadwal Konseling -->
                        <div>
                            <x-input-label for="jadwal_konseling" :value="__('Jadwal Konseling')" />
                             {{-- Format jadwal konseling untuk input datetime-local --}}
                             @php
                                $jadwal_konseling_value = old('jadwal_konseling', $konseling->jadwal_konseling ? \Carbon\Carbon::parse($konseling->jadwal_konseling)->format('Y-m-d\TH:i') : '');
                             @endphp
                            <x-text-input id="jadwal_konseling" 
                                         class="block mt-1 w-full" 
                                         type="datetime-local" 
                                         name="jadwal_konseling" 
                                         :value="$jadwal_konseling_value" 
                                         required />
                            <x-input-error :messages="$errors->get('jadwal_konseling')" class="mt-2" />
                        </div>

                        <!-- Tempat Konseling -->
                        <div>
                            <x-input-label for="tempat_konseling" :value="__('Tempat Konseling')" />
                            <x-text-input id="tempat_konseling" 
                                         class="block mt-1 w-full" 
                                         type="text" 
                                         name="tempat_konseling" 
                                         :value="old('tempat_konseling', $konseling->tempat_konseling)" 
                                         required />
                            <x-input-error :messages="$errors->get('tempat_konseling')" class="mt-2" />
                        </div>

                        <div class="flex items-center justify-end mt-4">
                            <x-secondary-button onclick="window.history.back()" class="mr-3">
                                {{ __('Batal') }}
                            </x-secondary-button>
                            <x-primary-button>
                                {{ __('Update Jadwal') }}
                            </x-primary-button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
    
    @push('scripts')
    <script>
        // Script untuk memastikan hidden korban_id terisi saat form dimuat
        document.addEventListener('DOMContentLoaded', function() {
            const pengaduanSelect = document.getElementById('pengaduan_id');
            const korbanIdInput = document.getElementById('korban_id');
            
            // Set hidden korban_id based on the selected pengaduan on load
            if (pengaduanSelect.value) {
                 const selectedOption = pengaduanSelect.options[pengaduanSelect.selectedIndex];
                 if (selectedOption && selectedOption.dataset.korbanId) {
                    korbanIdInput.value = selectedOption.dataset.korbanId;
                    console.log('Initial korban_id set to:', korbanIdInput.value);
                 }
             }

            // Opsional: Jika ingin enable kembali dropdown pengaduan dan update korban_id
            // pengaduanSelect.addEventListener('change', function() {
            //     const selectedOption = this.options[this.selectedIndex];
            //     if (selectedOption && selectedOption.dataset.korbanId) {
            //         korbanIdInput.value = selectedOption.dataset.korbanId;
            //         console.log('Updated korban_id to:', korbanIdInput.value);
            //     } else {
            //         korbanIdInput.value = '';
            //         console.log('No korban_id found for selected pengaduan');
            //     }
            // });

             // Karena dropdown pengaduan disabled, validasi korban_id akan mengandalkan value dari old() atau $konseling->korban_id
             // Pastikan hidden input korban_id punya required atribut.
        });
    </script>
    @endpush
</x-app-layout> 