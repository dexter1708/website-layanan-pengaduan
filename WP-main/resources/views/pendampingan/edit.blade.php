<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Edit Jadwal Pendampingan') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 text-gray-900">
                    <form method="POST" action="{{ route('staff.pendampingan.update', $pendampingan->id) }}" class="space-y-6">
                        @csrf
                        @method('PUT')

                        <!-- ID Pengaduan -->
                        <div>
                            <x-input-label for="pengaduan_id" :value="__('ID Pengaduan')" />
                            <select id="pengaduan_id" name="pengaduan_id" class="mt-1 block w-full border-gray-300 focus:border-indigo-500 focus:ring-indigo-500 rounded-md shadow-sm">
                                <option value="">Pilih ID Pengaduan</option>
                                @foreach($pengaduans as $pengaduan)
                                    <option value="{{ $pengaduan->id }}" {{ old('pengaduan_id', $pendampingan->pengaduan_id) == $pengaduan->id ? 'selected' : '' }}>
                                        {{ $pengaduan->id }} - {{ $pengaduan->nama_pelapor }}
                                    </option>
                                @endforeach
                            </select>
                            <x-input-error class="mt-2" :messages="$errors->get('pengaduan_id')" />
                        </div>

                        <!-- Nama Korban (akan diisi via JS/Ajax berdasarkan pengaduan_id) -->
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
                                    <option value="{{ $layanan->nama_layanan }}" {{ old('jenis_layanan', $pendampingan->jenis_layanan) == $layanan->nama_layanan ? 'selected' : '' }}>
                                        {{ $layanan->nama_layanan }}
                                    </option>
                                @endforeach
                            </select>
                            <x-input-error class="mt-2" :messages="$errors->get('jenis_layanan')" />
                        </div>

                        <!-- Nama Pendamping -->
                        <div>
                            <x-input-label for="nama_pendamping" :value="__('Nama Pendamping')" />
                            <select id="nama_pendamping" name="nama_pendamping" class="mt-1 block w-full border-gray-300 focus:border-indigo-500 focus:ring-indigo-500 rounded-md shadow-sm" disabled>
                                <option value="">Pilih Jenis Layanan terlebih dahulu</option>
                            </select>
                            <x-input-error class="mt-2" :messages="$errors->get('nama_pendamping')" />
                        </div>

                        <!-- Tanggal Pendampingan -->
                        <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                            <div>
                                <x-input-label for="tanggal_pendampingan" :value="__('Tanggal Pendampingan')" />
                                <x-text-input id="tanggal_pendampingan" class="block mt-1 w-full" type="date" name="tanggal_pendampingan" :value="old('tanggal_pendampingan', \Carbon\Carbon::parse($pendampingan->tanggal_pendampingan)->format('Y-m-d'))" required autocomplete="tanggal_pendampingan" />
                                <p class="mt-1 text-sm text-gray-500">Pilih tanggal (format: DD/MM/YYYY)</p>
                                <x-input-error class="mt-2" :messages="$errors->get('tanggal_pendampingan')" />
                            </div>
                            <div>
                                <x-input-label for="waktu_pendampingan" :value="__('Waktu Pendampingan')" />
                                <x-text-input id="waktu_pendampingan" class="block mt-1 w-full" type="time" name="waktu_pendampingan" :value="old('waktu_pendampingan', \Carbon\Carbon::parse($pendampingan->tanggal_pendampingan)->format('H:i'))" required autocomplete="waktu_pendampingan" />
                                <p class="mt-1 text-sm text-gray-500">Pilih waktu (format: HH:MM dalam 24 jam)</p>
                                <x-input-error class="mt-2" :messages="$errors->get('waktu_pendampingan')" />
                            </div>
                        </div>

                        <!-- Tempat Pendampingan -->
                        <div>
                            <x-input-label for="tempat_pendampingan" :value="__('Tempat Pendampingan')" />
                            <x-text-input id="tempat_pendampingan" class="block mt-1 w-full" type="text" name="tempat_pendampingan" :value="old('tempat_pendampingan', $pendampingan->tempat_pendampingan)" required autocomplete="tempat_pendampingan" />
                            <x-input-error class="mt-2" :messages="$errors->get('tempat_pendampingan')" />
                        </div>

                        <!-- Status Konfirmasi -->
                        <div>
                            <x-input-label for="konfirmasi" :value="__('Status Konfirmasi')" />
                            <select id="konfirmasi" name="konfirmasi" class="mt-1 block w-full border-gray-300 focus:border-indigo-500 focus:ring-indigo-500 rounded-md shadow-sm">
                                <option value="">Pilih Status (Opsional)</option>
                                <option value="{{ \App\Models\Pendampingan::STATUS_BUTUH_KONFIRMASI_STAFF }}" {{ old('konfirmasi', $pendampingan->konfirmasi) == \App\Models\Pendampingan::STATUS_BUTUH_KONFIRMASI_STAFF ? 'selected' : '' }}>
                                    Butuh Konfirmasi Staff
                                </option>
                                <option value="{{ \App\Models\Pendampingan::STATUS_MENUNGGU_KONFIRMASI_USER }}" {{ old('konfirmasi', $pendampingan->konfirmasi) == \App\Models\Pendampingan::STATUS_MENUNGGU_KONFIRMASI_USER ? 'selected' : '' }}>
                                    Menunggu Konfirmasi User
                                </option>
                                <option value="{{ \App\Models\Pendampingan::STATUS_TERKONFIRMASI }}" {{ old('konfirmasi', $pendampingan->konfirmasi) == \App\Models\Pendampingan::STATUS_TERKONFIRMASI ? 'selected' : '' }}>
                                    Terkonfirmasi
                                </option>
                                <option value="{{ \App\Models\Pendampingan::STATUS_DIBATALKAN }}" {{ old('konfirmasi', $pendampingan->konfirmasi) == \App\Models\Pendampingan::STATUS_DIBATALKAN ? 'selected' : '' }}>
                                    Dibatalkan
                                </option>
                            </select>
                            <p class="mt-1 text-sm text-gray-500">Biarkan kosong untuk mempertahankan status saat ini</p>
                            <x-input-error class="mt-2" :messages="$errors->get('konfirmasi')" />
                        </div>

                        <!-- Catatan -->
                        <!-- <div>
                            <x-input-label for="catatan" :value="__('Catatan')" />
                            <textarea id="catatan" name="catatan" class="mt-1 block w-full border-gray-300 focus:border-indigo-500 focus:ring-indigo-500 rounded-md shadow-sm">{{ old('catatan', $pendampingan->catatan) }}</textarea>
                            <x-input-error class="mt-2" :messages="$errors->get('catatan')" />
                        </div> -->

                        <div class="flex items-center gap-4">
                            <x-primary-button>{{ __('Perbarui') }}</x-primary-button>
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
         data-current-korban-id="{{ $pendampingan->korban_id }}"
         data-layanan="{{ json_encode($layanans) }}"
         data-instruktur="{{ json_encode($instrukturs) }}"
         data-current-nama-pendamping="{{ $pendampingan->nama_pendamping }}"
         data-old-jenis-layanan="{{ old('jenis_layanan', $pendampingan->jenis_layanan) }}"
         data-old-nama-pendamping="{{ old('nama_pendamping', $pendampingan->nama_pendamping) }}"
         style="display: none;">
    </div>

    @push('scripts')
        <script>
            document.addEventListener('DOMContentLoaded', function () {
                const pengaduanSelect = document.getElementById('pengaduan_id');
                const korbanSelect = document.getElementById('korban_id');
                const noKorbanMessage = document.getElementById('no-korban-message');
                const dataContainer = document.getElementById('pengaduan-data');
                const waktuInput = document.getElementById('waktu_pendampingan');
                const jenisLayananSelect = document.getElementById('jenis_layanan');
                const namaPendampingSelect = document.getElementById('nama_pendamping');

                // Get data from hidden container
                const pengaduanData = JSON.parse(dataContainer.getAttribute('data-pengaduan'));
                const currentKorbanId = dataContainer.getAttribute('data-current-korban-id');
                const layananData = JSON.parse(dataContainer.getAttribute('data-layanan'));
                const instrukturData = JSON.parse(dataContainer.getAttribute('data-instruktur'));
                const currentNamaPendamping = dataContainer.getAttribute('data-current-nama-pendamping');
                const oldJenisLayanan = dataContainer.getAttribute('data-old-jenis-layanan');
                const oldNamaPendamping = dataContainer.getAttribute('data-old-nama-pendamping');

                function updateKorbanOptions() {
                    const selectedPengaduanId = pengaduanSelect.value;
                    
                    // Reset korban dropdown
                    korbanSelect.innerHTML = '<option value="">Pilih Korban</option>';
                    korbanSelect.disabled = true;
                    noKorbanMessage.style.display = 'none';

                    if (selectedPengaduanId) {
                        // Cari pengaduan yang dipilih
                        const selectedPengaduan = pengaduanData.find(p => p.id == selectedPengaduanId);
                        
                        if (selectedPengaduan) {
                            if (selectedPengaduan.korban && selectedPengaduan.korban.length > 0) {
                                // Tambah semua korban untuk pengaduan ini
                                selectedPengaduan.korban.forEach(function(korban) {
                                    const option = document.createElement('option');
                                    option.value = korban.id;
                                    option.textContent = korban.nama;
                                    // Set selected if it's the current korban for this pendampingan
                                    if (korban.id == currentKorbanId) {
                                        option.selected = true;
                                    }
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

                function updateNamaPendampingOptions() {
                    const selectedLayanan = jenisLayananSelect.value;
                    
                    // Reset nama pendamping dropdown
                    namaPendampingSelect.innerHTML = '<option value="">Pilih Nama Pendamping</option>';
                    namaPendampingSelect.disabled = true;

                    if (selectedLayanan) {
                        // Filter instruktur berdasarkan nama_layanan yang sama dengan jenis_layanan yang dipilih
                        const filteredInstrukturs = instrukturData.filter(function(instruktur) {
                            return instruktur.nama_layanan === selectedLayanan;
                        });

                        if (filteredInstrukturs.length > 0) {
                            // Tambah instruktur yang sesuai
                            filteredInstrukturs.forEach(function(instruktur) {
                                const option = document.createElement('option');
                                option.value = instruktur.nama;
                                option.textContent = instruktur.nama + ' - ' + instruktur.posisi;
                                
                                // Set selected if it's the current nama pendamping or old value
                                if (instruktur.nama === currentNamaPendamping || instruktur.nama === oldNamaPendamping) {
                                    option.selected = true;
                                }
                                
                                namaPendampingSelect.appendChild(option);
                            });
                            namaPendampingSelect.disabled = false;
                        } else {
                            // Tidak ada instruktur untuk layanan ini
                            namaPendampingSelect.innerHTML = '<option value="">Tidak ada pendamping untuk layanan ini</option>';
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

                pengaduanSelect.addEventListener('change', updateKorbanOptions);
                jenisLayananSelect.addEventListener('change', updateNamaPendampingOptions);

                // Initial call on page load to set correct korban and nama pendamping for existing data
                updateKorbanOptions();
                updateNamaPendampingOptions();

                // Trigger waktu format on page load
                setTimeout(function() {
                    waktuInput.dispatchEvent(new Event('change'));
                }, 100);
            });
        </script>
    @endpush

    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/flatpickr/dist/flatpickr.min.css">
    <script src="https://cdn.jsdelivr.net/npm/flatpickr"></script>
</x-app-layout> 