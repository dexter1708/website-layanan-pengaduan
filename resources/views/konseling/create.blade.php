<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Buat Jadwal Konseling') }}
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
                    <form method="POST" action="{{ route('staff.konseling.store') }}" class="space-y-6" id="konselingForm">
                        @csrf

                        <!-- Hidden Korban ID - Pindahkan ke atas -->
                        <input type="hidden" name="korban_id" id="korban_id" value="{{ old('korban_id') }}" required>

                        <!-- Pengaduan -->
                        <div>
                            <x-input-label for="pengaduan_id" :value="__('Pilih Pengaduan')" />
                            <select id="pengaduan_id" name="pengaduan_id" class="mt-1 block w-full border-gray-300 focus:border-indigo-500 focus:ring-indigo-500 rounded-md shadow-sm" required>
                                <option value="">Pilih Pengaduan</option>
                                @foreach($pengaduans as $pengaduan)
                                    @foreach($pengaduan->korban as $korban)
                                        <option value="{{ $pengaduan->id }}" 
                                                data-korban-id="{{ $korban->id }}" 
                                                data-korban-nama="{{ $korban->nama }}"
                                                {{ old('pengaduan_id') == $pengaduan->id ? 'selected' : '' }}>
                                            {{ $pengaduan->nomor_pengaduan }} - {{ $korban->nama }}
                                        </option>
                                    @endforeach
                                @endforeach
                            </select>
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
                                         :value="old('nama_konselor')" 
                                         required />
                            <x-input-error :messages="$errors->get('nama_konselor')" class="mt-2" />
                        </div>

                        <!-- Jadwal Konseling -->
                        <div>
                            <x-input-label for="jadwal_konseling" :value="__('Jadwal Konseling')" />
                            <x-text-input id="jadwal_konseling" 
                                         class="block mt-1 w-full" 
                                         type="datetime-local" 
                                         name="jadwal_konseling" 
                                         :value="old('jadwal_konseling')" 
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
                                         :value="old('tempat_konseling')" 
                                         required />
                            <x-input-error :messages="$errors->get('tempat_konseling')" class="mt-2" />
                        </div>

                        <div class="flex items-center justify-end mt-4">
                            <x-secondary-button onclick="window.history.back()" class="mr-3">
                                {{ __('Batal') }}
                            </x-secondary-button>
                            <x-primary-button>
                                {{ __('Buat Jadwal') }}
                            </x-primary-button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>

    @push('scripts')
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            const pengaduanSelect = document.getElementById('pengaduan_id');
            const korbanIdInput = document.getElementById('korban_id');
            const form = document.getElementById('konselingForm');

            // Fungsi untuk mengupdate korban_id
            function updateKorbanId() {
                const selectedOption = pengaduanSelect.options[pengaduanSelect.selectedIndex];
                if (selectedOption && selectedOption.dataset.korbanId) {
                    const korbanId = selectedOption.dataset.korbanId;
                    korbanIdInput.value = korbanId;
                    console.log('Updated korban_id to:', korbanId);
                    
                    // Tambahkan visual feedback
                    if (korbanId) {
                        korbanIdInput.classList.remove('border-red-500');
                        korbanIdInput.classList.add('border-green-500');
                    }
                } else {
                    korbanIdInput.value = '';
                    console.log('No korban_id found for selected pengaduan');
                    
                    // Visual feedback untuk error
                    korbanIdInput.classList.remove('border-green-500');
                    korbanIdInput.classList.add('border-red-500');
                }
            }

            // Update korban_id saat pengaduan dipilih
            pengaduanSelect.addEventListener('change', function() {
                updateKorbanId();
                // Log untuk debugging
                console.log('Pengaduan selected:', {
                    pengaduan_id: this.value,
                    korban_id: korbanIdInput.value,
                    selected_option: this.options[this.selectedIndex].text
                });
            });

            // Update korban_id saat halaman dimuat
            updateKorbanId();

            // Validasi form sebelum submit
            form.addEventListener('submit', function(e) {
                const korbanId = korbanIdInput.value;
                const pengaduanId = pengaduanSelect.value;
                
                console.log('Form submission attempt:', {
                    pengaduan_id: pengaduanId,
                    korban_id: korbanId
                });

                if (!korbanId || !pengaduanId) {
                    e.preventDefault();
                    alert('Silakan pilih pengaduan terlebih dahulu');
                    
                    // Highlight field yang error
                    if (!pengaduanId) {
                        pengaduanSelect.classList.add('border-red-500');
                    }
                    if (!korbanId) {
                        korbanIdInput.classList.add('border-red-500');
                    }
                    return false;
                }

                // Log final values sebelum submit
                console.log('Form submitted with:', {
                    pengaduan_id: pengaduanId,
                    korban_id: korbanId,
                    form_data: new FormData(form)
                });
            });

            // Tambahkan visual feedback saat input berubah
            pengaduanSelect.addEventListener('focus', function() {
                this.classList.remove('border-red-500');
            });
        });
    </script>
    @endpush
</x-app-layout> 