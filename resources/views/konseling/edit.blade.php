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

                        <!-- ID Pengaduan -->
                        <div>
                            <x-input-label for="pengaduan_id" :value="__('ID Pengaduan')" />
                            <select id="pengaduan_id" name="pengaduan_id" class="mt-1 block w-full border-gray-300 focus:border-indigo-500 focus:ring-indigo-500 rounded-md shadow-sm">
                                <option value="">Pilih ID Pengaduan</option>
                                @foreach($pengaduans as $pengaduan)
                                    <option value="{{ $pengaduan->id }}" {{ old('pengaduan_id', $konseling->pengaduan_id) == $pengaduan->id ? 'selected' : '' }}>
                                        {{ $pengaduan->id }} - {{ $pengaduan->nama_pelapor }}
                                    </option>
                                @endforeach
                            </select>
                            <x-input-error class="mt-2" :messages="$errors->get('pengaduan_id')" />
                        </div>

                        <!-- Nama Korban -->
                        <div>
                            <x-input-label for="korban_id" :value="__('Nama Korban')" />
                            <select id="korban_id" name="korban_id" class="mt-1 block w-full border-gray-300 focus:border-indigo-500 focus:ring-indigo-500 rounded-md shadow-sm" readonly>
                                <option value="">Pilih Korban</option>
                            </select>
                            <x-input-error class="mt-2" :messages="$errors->get('korban_id')" />
                            <p id="no-korban-message" class="mt-2 text-sm text-gray-600" style="display: none;">
                                Pengaduan ini belum memiliki data korban.
                            </p>
                        </div>

                        <!-- Jenis Layanan -->
                        <div>
                            <x-input-label for="jenis_layanan" :value="__('Jenis Layanan Konseling')" />
                            <select id="jenis_layanan" name="jenis_layanan" class="mt-1 block w-full border-gray-300 focus:border-indigo-500 focus:ring-indigo-500 rounded-md shadow-sm">
                                <option value="">Pilih Jenis Layanan</option>
                                @foreach($layanans as $layanan)
                                    <option value="{{ $layanan->nama_layanan }}" {{ old('jenis_layanan', $konseling->jenis_layanan) == $layanan->nama_layanan ? 'selected' : '' }}>
                                        {{ $layanan->nama_layanan }}
                                    </option>
                                @endforeach
                            </select>
                            <x-input-error class="mt-2" :messages="$errors->get('jenis_layanan')" />
                        </div>

                        <!-- Nama Konselor -->
                        <div>
                            <x-input-label for="nama_konselor" :value="__('Nama Konselor')" />
                            <select id="nama_konselor" name="nama_konselor" class="mt-1 block w-full border-gray-300 focus:border-indigo-500 focus:ring-indigo-500 rounded-md shadow-sm" disabled>
                                <option value="">Pilih Jenis Layanan terlebih dahulu</option>
                            </select>
                            <x-input-error class="mt-2" :messages="$errors->get('nama_konselor')" />
                        </div>

                        <!-- Tanggal & Waktu Konseling -->
                        <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                            <div>
                                <x-input-label for="tanggal_konseling" :value="__('Tanggal Konseling')" />
                                <x-text-input id="tanggal_konseling" class="block mt-1 w-full" type="date" name="tanggal_konseling" :value="old('tanggal_konseling', \Carbon\Carbon::parse($konseling->jadwal_konseling)->format('Y-m-d'))" required />
                                <x-input-error class="mt-2" :messages="$errors->get('tanggal_konseling')" />
                            </div>
                            <div>
                                <x-input-label for="waktu_konseling" :value="__('Waktu Konseling')" />
                                <select id="waktu_konseling" name="waktu_konseling" class="mt-1 block w-full border-gray-300 focus:border-indigo-500 focus:ring-indigo-500 rounded-md shadow-sm" required>
                                    @for ($i = 8; $i <= 15; $i++)
                                        @if ($i === 12) @continue @endif
                                        @php $time = str_pad($i, 2, '0', STR_PAD_LEFT) . ':00'; @endphp
                                        <option value="{{ $time }}" {{ old('waktu_konseling', \Carbon\Carbon::parse($konseling->jadwal_konseling)->format('H:i')) == $time ? 'selected' : '' }}>
                                            {{ $time }} WIB
                                        </option>
                                    @endfor
                                </select>
                                <x-input-error class="mt-2" :messages="$errors->get('waktu_konseling')" />
                            </div>
                        </div>

                        <!-- Tempat Konseling -->
                        <div>
                            <x-input-label for="tempat_konseling" :value="__('Tempat Konseling')" />
                            <x-text-input id="tempat_konseling" class="block mt-1 w-full" type="text" name="tempat_konseling" :value="old('tempat_konseling', $konseling->tempat_konseling)" required />
                            <x-input-error class="mt-2" :messages="$errors->get('tempat_konseling')" />
                        </div>

                        <!-- Status Konfirmasi -->
                        <div>
                            <x-input-label for="konfirmasi" :value="__('Status Konfirmasi')" />
                            @php
                                $isAwaitingStaff = $konseling->konfirmasi === \App\Models\Konseling::STATUS_BUTUH_KONFIRMASI_STAFF;
                            @endphp
                            <select id="konfirmasi" name="konfirmasi" class="mt-1 block w-full border-gray-300 focus:border-indigo-500 focus:ring-indigo-500 rounded-md shadow-sm" @if($isAwaitingStaff) readonly @endif>
                                @if($isAwaitingStaff)
                                    <option value="{{ \App\Models\Konseling::STATUS_MENUNGGU_KONFIRMASI_USER }}" selected>
                                        Kirim Jadwal ke User untuk Dikonfirmasi
                                    </option>
                                @else
                                    <option value="">Pilih Status (Opsional)</option>
                                    <option value="{{ \App\Models\Konseling::STATUS_MENUNGGU_KONFIRMASI_USER }}" {{ old('konfirmasi', $konseling->konfirmasi) == \App\Models\Konseling::STATUS_MENUNGGU_KONFIRMASI_USER ? 'selected' : '' }}>
                                        Menunggu Konfirmasi User
                                    </option>
                                    <option value="{{ \App\Models\Konseling::STATUS_TERKONFIRMASI }}" {{ old('konfirmasi', $konseling->konfirmasi) == \App\Models\Konseling::STATUS_TERKONFIRMASI ? 'selected' : '' }}>
                                        Terkonfirmasi
                                    </option>
                                    <option value="{{ \App\Models\Konseling::STATUS_DIBATALKAN }}" {{ old('konfirmasi', $konseling->konfirmasi) == \App\Models\Konseling::STATUS_DIBATALKAN ? 'selected' : '' }}>
                                        Dibatalkan
                                    </option>
                                @endif
                            </select>
                            @if($isAwaitingStaff)
                                <p class="mt-1 text-sm text-gray-500">Status akan diubah menjadi "Menunggu Konfirmasi User".</p>
                            @else
                                <p class="mt-1 text-sm text-gray-500">Biarkan kosong untuk mempertahankan status saat ini.</p>
                            @endif
                            <x-input-error class="mt-2" :messages="$errors->get('konfirmasi')" />
                        </div>

                        <div class="flex items-center gap-4">
                            <x-primary-button>{{ __('Perbarui') }}</x-primary-button>
                        </div>
                    </form>

                    @if(auth()->user()->role === 'staff' && $konseling->konfirmasi === 'butuh_konfirmasi_staff')
                    <!-- Form Konfirmasi Terpisah -->
                    <div class="mt-6 p-4 bg-gray-50 rounded-lg">
                        <h3 class="text-lg font-semibold mb-4">Aksi Konfirmasi</h3>
                        <form action="{{ route('konseling.update-konfirmasi', $konseling->id) }}" method="POST" class="space-y-4">
                            @csrf
                            @method('PUT')
                            
                            <div class="flex space-x-2">
                                <button type="submit" name="konfirmasi" value="setuju" class="bg-green-500 hover:bg-green-700 text-white font-bold py-2 px-4 rounded">
                                    Setujui & Konfirmasi
                                </button>
                                <button type="submit" name="konfirmasi" value="menunggu_konfirmasi_user" class="bg-indigo-500 hover:bg-indigo-700 text-white font-bold py-2 px-4 rounded">
                                    Jadwal Ulang & Minta Konfirmasi User
                                </button>
                                <button type="submit" name="konfirmasi" value="tolak" class="bg-red-500 hover:bg-red-700 text-white font-bold py-2 px-4 rounded" onclick="return confirm('Apakah Anda yakin ingin menolak permintaan ini?');">
                                    Tolak Permintaan
                                </button>
                            </div>
                        </form>
                    </div>
                    @endif
                </div>
            </div>
        </div>
    </div>

    <!-- Hidden data container for JavaScript -->
    <div id="pengaduan-data"
         data-pengaduan="{{ json_encode($pengaduans->mapWithKeys(function($p) {
            if ($p->korban) {
                return [$p->id => ['id' => $p->korban->id, 'nama' => $p->korban->nama]];
            }
            return [$p->id => null];
         })) }}"
         data-current-korban-id="{{ $konseling->korban_id }}"
         data-layanan="{{ json_encode($layanans) }}"
         data-instruktur="{{ json_encode($instrukturs) }}"
         data-current-nama-konselor="{{ $konseling->nama_konselor }}"
         style="display: none;">
    </div>

    @push('scripts')
        <script>
        document.addEventListener('DOMContentLoaded', function () {
            const pengaduanSelect = document.getElementById('pengaduan_id');
            const korbanSelect = document.getElementById('korban_id');
            const noKorbanMessage = document.getElementById('no-korban-message');
            const dataContainer = document.getElementById('pengaduan-data');
            const jenisLayananSelect = document.getElementById('jenis_layanan');
            const namaKonselorSelect = document.getElementById('nama_konselor');

            const pengaduanData = JSON.parse(dataContainer.getAttribute('data-pengaduan'));
            const currentKorbanId = dataContainer.getAttribute('data-current-korban-id');
            const layananData = JSON.parse(dataContainer.getAttribute('data-layanan'));
            const instrukturData = JSON.parse(dataContainer.getAttribute('data-instruktur'));
            const currentNamaKonselor = dataContainer.getAttribute('data-current-nama-konselor');

            function updateKorbanOptions() {
                const selectedPengaduanId = pengaduanSelect.value;
                korbanSelect.innerHTML = '<option value="">Pilih Korban</option>';
                korbanSelect.disabled = true;
                noKorbanMessage.style.display = 'none';

                if (selectedPengaduanId) {
                    const selectedPengaduan = pengaduanData.find(p => p.id == selectedPengaduanId);
                    const korban = selectedPengaduan ? selectedPengaduan.korban : null;

                    if (korban) {
                        const option = document.createElement('option');
                        option.value = korban.id;
                        option.textContent = korban.nama;
                        if (korban.id == currentKorbanId) {
                            option.selected = true;
                        }
                        korbanSelect.appendChild(option);
                        korbanSelect.disabled = false;
                    } else {
                        noKorbanMessage.style.display = 'block';
                    }
                }
            }

            function updateNamaKonselorOptions() {
                const selectedLayanan = jenisLayananSelect.value;
                namaKonselorSelect.innerHTML = '<option value="">Pilih Nama Konselor</option>';
                namaKonselorSelect.disabled = true;

                if (selectedLayanan) {
                    const filteredInstrukturs = instrukturData.filter(instruktur => instruktur.nama_layanan === selectedLayanan);
                    if (filteredInstrukturs.length > 0) {
                        filteredInstrukturs.forEach(function(instruktur) {
                            const option = document.createElement('option');
                            option.value = instruktur.nama;
                            option.textContent = instruktur.nama + ' - ' + instruktur.posisi;
                            if (instruktur.nama === currentNamaKonselor) {
                                option.selected = true;
                            }
                            namaKonselorSelect.appendChild(option);
                        });
                        namaKonselorSelect.disabled = false;
                    }
                }
            }

            pengaduanSelect.addEventListener('change', updateKorbanOptions);
            jenisLayananSelect.addEventListener('change', updateNamaKonselorOptions);

            // Initial calls to populate on page load
            updateKorbanOptions();
            updateNamaKonselorOptions();
        });
        </script>
    @endpush
</x-app-layout> 