<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Ajukan Pendampingan') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 text-gray-900">
                    <form method="POST" action="{{ route('user.pendampingan.request') }}" class="space-y-6">
                        @csrf

                        <!-- ID Pengaduan -->
                        <div>
                            <x-input-label for="pengaduan_id" :value="__('Pilih Pengaduan')" />
                            <select id="pengaduan_id" name="pengaduan_id" class="mt-1 block w-full border-gray-300 focus:border-indigo-500 focus:ring-indigo-500 rounded-md shadow-sm">
                                <option value="">Pilih Pengaduan</option>
                                @foreach($pengaduans as $pengaduan)
                                    <option value="{{ $pengaduan->id }}" 
                                            {{ old('pengaduan_id') == $pengaduan->id ? 'selected' : '' }}>
                                        ID: {{ $pengaduan->id }} - {{ $pengaduan->nama_pelapor ?? 'N/A' }}
                                        @if($pengaduan->korban && $pengaduan->korban->count() > 0)
                                            ({{ $pengaduan->korban->count() }} korban)
                                        @else
                                            (Belum ada korban)
                                        @endif
                                    </option>
                                @endforeach
                            </select>
                            <x-input-error class="mt-2" :messages="$errors->get('pengaduan_id')" />
                        </div>

                        <!-- Nama Korban -->
                        <div>
                            <x-input-label for="korban_id" :value="__('Nama Korban')" />
                            <select id="korban_id" name="korban_id" class="mt-1 block w-full border-gray-300 focus:border-indigo-500 focus:ring-indigo-500 rounded-md shadow-sm" disabled>
                                <option value="">Pilih Korban</option>
                            </select>
                            <x-input-error class="mt-2" :messages="$errors->get('korban_id')" />
                            <p id="no-korban-message" class="mt-2 text-sm text-gray-600" style="display: none;">
                                Pengaduan ini belum memiliki data korban.
                            </p>
                        </div>

                        <!-- Jenis Layanan -->
                        <div>
                            <x-input-label for="jenis_layanan" :value="__('Jenis Layanan Pendampingan')" />
                            <select id="jenis_layanan" name="jenis_layanan" class="mt-1 block w-full border-gray-300 focus:border-indigo-500 focus:ring-indigo-500 rounded-md shadow-sm">
                                <option value="">Pilih Jenis Layanan</option>
                                @foreach($layanans as $layanan)
                                    <option value="{{ $layanan->nama_layanan }}" {{ old('jenis_layanan') == $layanan->nama_layanan ? 'selected' : '' }}>
                                        {{ $layanan->nama_layanan }}
                                    </option>
                                @endforeach
                            </select>
                            <x-input-error class="mt-2" :messages="$errors->get('jenis_layanan')" />
                        </div>

                        <!-- Tanggal dan Waktu Pendampingan -->
                        <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                            <div>
                                <x-input-label for="tanggal_pendampingan" :value="__('Tanggal Pendampingan')" />
                                <x-text-input id="tanggal_pendampingan" class="block mt-1 w-full" type="date" name="tanggal_pendampingan" :value="old('tanggal_pendampingan')" required autocomplete="tanggal_pendampingan" />
                                <p class="mt-1 text-sm text-gray-500">Pilih tanggal (format: DD/MM/YYYY)</p>
                                <x-input-error class="mt-2" :messages="$errors->get('tanggal_pendampingan')" />
                            </div>
                            <div>
                                <x-input-label for="waktu_pendampingan" :value="__('Waktu Pendampingan')" />
                                <x-text-input id="waktu_pendampingan" class="block mt-1 w-full" type="time" name="waktu_pendampingan" :value="old('waktu_pendampingan')" required autocomplete="waktu_pendampingan" />
                                <p class="mt-1 text-sm text-gray-500">Pilih waktu (format: HH:MM dalam 24 jam)</p>
                                <x-input-error class="mt-2" :messages="$errors->get('waktu_pendampingan')" />
                            </div>
                        </div>

                        <div class="flex items-center gap-4">
                            <x-primary-button>{{ __('Ajukan Pendampingan') }}</x-primary-button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>

    <!-- Hidden data container for JavaScript -->
    <div id="pengaduan-data" 
         data-pengaduan="{{ json_encode($pengaduans->map(function($pengaduan) {
             return [
                 'id' => $pengaduan->id,
                 'korban' => $pengaduan->korban ? $pengaduan->korban->map(function($korban) {
                     return [
                         'id' => $korban->id,
                         'nama' => $korban->nama ?? 'Nama tidak tersedia'
                     ];
                 }) : []
             ];
         })) }}"
         style="display: none;">
    </div>

    <script>
        document.addEventListener('DOMContentLoaded', function () {
            const pengaduanSelect = document.getElementById('pengaduan_id');
            const korbanSelect = document.getElementById('korban_id');
            const noKorbanMessage = document.getElementById('no-korban-message');
            const dataContainer = document.getElementById('pengaduan-data');
            const waktuInput = document.getElementById('waktu_pendampingan');

            // Get data from hidden container
            const pengaduanData = JSON.parse(dataContainer.getAttribute('data-pengaduan'));

            console.log('Data pengaduan:', pengaduanData); // Debug

            function updateKorbanOptions() {
                const selectedPengaduanId = pengaduanSelect.value;
                
                // Reset korban dropdown
                korbanSelect.innerHTML = '<option value="">Pilih Korban</option>';
                korbanSelect.disabled = true;
                noKorbanMessage.style.display = 'none';

                if (selectedPengaduanId) {
                    // Cari pengaduan yang dipilih
                    const selectedPengaduan = pengaduanData.find(p => p.id == selectedPengaduanId);
                    
                    console.log('Pengaduan terpilih:', selectedPengaduan); // Debug
                    
                    if (selectedPengaduan) {
                        if (selectedPengaduan.korban && selectedPengaduan.korban.length > 0) {
                            // Tambah semua korban untuk pengaduan ini
                            selectedPengaduan.korban.forEach(function(korban) {
                                const option = document.createElement('option');
                                option.value = korban.id;
                                option.textContent = korban.nama;
                                korbanSelect.appendChild(option);
                            });
                            korbanSelect.disabled = false;
                        } else {
                            // Tidak ada korban
                            noKorbanMessage.style.display = 'block';
                        }
                    }
                }
            }

            // Format waktu dengan WIB (24 jam)
            function formatWaktuIndonesia(waktu) {
                if (!waktu) return '';
                return `${waktu} WIB`;
            }

            // Event listener untuk format waktu
            waktuInput.addEventListener('change', function() {
                const waktu = this.value;
                const waktuFormatted = formatWaktuIndonesia(waktu);
                
                // Tampilkan format Indonesia di bawah input
                let displayElement = document.getElementById('waktu-display');
                if (!displayElement) {
                    displayElement = document.createElement('div');
                    displayElement.id = 'waktu-display';
                    displayElement.className = 'mt-1 text-sm text-blue-600 font-medium';
                    this.parentNode.appendChild(displayElement);
                }
                
                if (waktuFormatted) {
                    displayElement.textContent = `Waktu yang dipilih: ${waktuFormatted}`;
                } else {
                    displayElement.textContent = '';
                }
            });

            // Event listener untuk perubahan pengaduan
            pengaduanSelect.addEventListener('change', updateKorbanOptions);

            // Initialize if there are old values
            const oldPengaduanId = "{{ old('pengaduan_id') }}";
            const oldKorbanId = "{{ old('korban_id') }}";
            const oldWaktu = "{{ old('waktu_pendampingan') }}";
            
            if (oldPengaduanId) {
                updateKorbanOptions();
                if (oldKorbanId) {
                    // Set selected korban if there's old input
                    setTimeout(function() {
                        if (oldKorbanId) {
                            korbanSelect.value = oldKorbanId;
                        }
                    }, 100);
                }
            }

            // Trigger waktu format if there's old input
            if (oldWaktu) {
                setTimeout(function() {
                    waktuInput.dispatchEvent(new Event('change'));
                }, 100);
            }
        });
    </script>
</x-app-layout>