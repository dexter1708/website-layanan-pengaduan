<x-app-layout>
    <x-slot name="header">
        <div class="flex justify-between items-center">
            <h2 class="font-semibold text-xl text-gray-800 leading-tight">
                {{ __('Detail Pendampingan') }}
            </h2>
            @if(auth()->user()->role !== 'staff' && $pendampingan->isMenungguKonfirmasiUser())
            <div class="flex space-x-2">
                <form action="{{ route('pendampingan.update-konfirmasi', $pendampingan->id) }}" method="POST" class="inline">
                    @csrf
                    @method('PUT')
                    <input type="hidden" name="konfirmasi" value="{{ \App\Models\Pendampingan::STATUS_TERKONFIRMASI }}">
                    <x-primary-button>
                        {{ __('Setuju') }}
                    </x-primary-button>
                </form>
                <form action="{{ route('pendampingan.update-konfirmasi', $pendampingan->id) }}" method="POST" class="inline">
                    @csrf
                    @method('PUT')
                    <input type="hidden" name="konfirmasi" value="{{ \App\Models\Pendampingan::STATUS_DIBATALKAN }}">
                    <x-danger-button>
                        {{ __('Tolak') }}
                    </x-danger-button>
                </form>
            </div>
            @endif
        </div>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            @if(session('success'))
                <div class="bg-green-100 border border-green-400 text-green-700 px-4 py-3 rounded relative mb-4" role="alert">
                    <span class="block sm:inline">{{ session('success') }}</span>
                </div>
            @endif

            <!-- Informasi Pendampingan -->
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg mb-6">
                <div class="p-6 text-gray-900">
                    <h3 class="text-lg font-semibold mb-4">Informasi Pendampingan</h3>
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                        <div>
                            <p class="text-sm text-gray-600">ID Pengaduan</p>
                            <p class="font-medium">{{ $pendampingan->pengaduan->id }}</p>
                        </div>
                        <div>
                            <p class="text-sm text-gray-600">Status</p>
                            <span class="px-2 inline-flex text-xs leading-5 font-semibold rounded-full 
                                @if($pendampingan->isTerkonfirmasi()) bg-green-100 text-green-800
                                @elseif($pendampingan->isDibatalkan()) bg-red-100 text-red-800
                                @elseif($pendampingan->isMenungguKonfirmasiUser()) bg-blue-100 text-blue-800
                                @else bg-yellow-100 text-yellow-800
                                @endif">
                                {{ $pendampingan->getStatusLabel() }}
                            </span>
                        </div>
                        <div>
                            <p class="text-sm text-gray-600">Nama Korban</p>
                            <p class="font-medium">{{ $pendampingan->korban->nama ?? 'N/A' }}</p>
                        </div>
                        <div>
                            <p class="text-sm text-gray-600">Nama Pendamping</p>
                            <p class="font-medium">
                                @if($pendampingan->nama_pendamping === 'Belum ditentukan')
                                    <span class="text-gray-500 italic">Belum ditentukan</span>
                                @else
                                    {{ $pendampingan->nama_pendamping }}
                                @endif
                            </p>
                        </div>
                        <div>
                            <p class="text-sm text-gray-600">Tanggal Pendampingan</p>
                            <p class="font-medium">{{ $pendampingan->getTanggalPendampinganFormatted() }}</p>
                        </div>
                        <div>
                            <p class="text-sm text-gray-600">Waktu Pendampingan</p>
                            <p class="font-medium">{{ $pendampingan->getWaktuPendampinganFormatted() }}</p>
                        </div>
                        <div>
                            <p class="text-sm text-gray-600">Tempat Pendampingan</p>
                            <p class="font-medium">
                                @if($pendampingan->tempat_pendampingan === 'Belum ditentukan')
                                    <span class="text-gray-500 italic">Belum ditentukan</span>
                                @else
                                    {{ $pendampingan->tempat_pendampingan }}
                                @endif
                            </p>
                        </div>
                        <div>
                            <p class="text-sm text-gray-600">Jenis Layanan</p>
                            <p class="font-medium">{{ $pendampingan->getJenisLayananLabel() }}</p>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Informasi Pengaduan -->
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 text-gray-900">
                    <h3 class="text-lg font-semibold mb-4">Informasi Pengaduan</h3>
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                        <div>
                            <p class="text-sm text-gray-600">Tanggal Pengaduan</p>
                            <p class="font-medium">{{ $pendampingan->getTanggalPengaduanFormatted() }}</p>
                        </div>
                        <div>
                            <p class="text-sm text-gray-600">Status Pengaduan</p>
                            <span class="px-2 inline-flex text-xs leading-5 font-semibold rounded-full 
                                @if($pendampingan->pengaduan->status === 'selesai') bg-green-100 text-green-800
                                @elseif($pendampingan->pengaduan->status === 'ditolak') bg-red-100 text-red-800
                                @else bg-yellow-100 text-yellow-800
                                @endif">
                                {{ ucfirst($pendampingan->pengaduan->status) }}
                            </span>
                        </div>
                        <div class="col-span-2">
                            <p class="text-sm text-gray-600">Deskripsi Pengaduan</p>
                            <p class="font-medium">{{ $pendampingan->pengaduan->deskripsi }}</p>
                        </div>
                    </div>
                </div>
            </div>

            @if(auth()->user()->role === 'staff' && $pendampingan->isButuhKonfirmasiStaff())
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg mb-6">
                <div class="p-6 text-gray-900">
                    <h3 class="text-lg font-semibold mb-4">Aksi Staff</h3>
                    <form action="{{ route('staff.pendampingan.update-konfirmasi', $pendampingan->id) }}" method="POST" class="space-y-4">
                        @csrf
                        @method('PUT')

                        <!-- Nama Pendamping -->
                        <div>
                            <x-input-label for="nama_pendamping" :value="__('Nama Pendamping')" />
                            <select id="nama_pendamping" name="nama_pendamping" class="mt-1 block w-full border-gray-300 focus:border-indigo-500 focus:ring-indigo-500 rounded-md shadow-sm" disabled>
                                <option value="">Pilih Jenis Layanan terlebih dahulu</option>
                            </select>
                            <x-input-error :messages="$errors->get('nama_pendamping')" class="mt-2" />
                        </div>

                        <!-- Tanggal dan Waktu Pendampingan -->
                        <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                            <div>
                                <x-input-label for="tanggal_pendampingan_staff" :value="__('Tanggal Pendampingan')" />
                                <x-text-input id="tanggal_pendampingan_staff" class="block mt-1 w-full" type="date" name="tanggal_pendampingan" :value="old('tanggal_pendampingan', $pendampingan->tanggal_pendampingan ? \Carbon\Carbon::parse($pendampingan->tanggal_pendampingan)->format('Y-m-d') : '')" />
                                <p class="mt-1 text-sm text-gray-500">Pilih tanggal (format: DD/MM/YYYY)</p>
                                <x-input-error :messages="$errors->get('tanggal_pendampingan')" class="mt-2" />
                            </div>
                            <div>
                                <x-input-label for="waktu_pendampingan_staff" :value="__('Waktu Pendampingan')" />
                                <x-text-input id="waktu_pendampingan_staff" class="block mt-1 w-full" type="time" name="waktu_pendampingan" :value="old('waktu_pendampingan', $pendampingan->tanggal_pendampingan ? \Carbon\Carbon::parse($pendampingan->tanggal_pendampingan)->format('H:i') : '')" />
                                <p class="mt-1 text-sm text-gray-500">Pilih waktu (format: HH:MM dalam 24 jam)</p>
                                <x-input-error :messages="$errors->get('waktu_pendampingan')" class="mt-2" />
                            </div>
                        </div>

                        <!-- Tempat Pendampingan -->
                        <div>
                            <x-input-label for="tempat_pendampingan_staff" :value="__('Tempat Pendampingan')" />
                            <x-text-input id="tempat_pendampingan_staff" class="block mt-1 w-full" type="text" name="tempat_pendampingan" :value="old('tempat_pendampingan', $pendampingan->tempat_pendampingan !== 'Belum ditentukan' ? $pendampingan->tempat_pendampingan : '')" placeholder="Masukkan tempat pendampingan" />
                            <x-input-error :messages="$errors->get('tempat_pendampingan')" class="mt-2" />
                        </div>

                        <div class="flex space-x-2">
                            <button type="submit" name="konfirmasi" value="{{ \App\Models\Pendampingan::STATUS_TERKONFIRMASI }}" class="bg-green-500 hover:bg-green-700 text-white font-bold py-2 px-4 rounded">
                                Setujui & Konfirmasi
                            </button>
                            <button type="submit" name="konfirmasi" value="{{ \App\Models\Pendampingan::STATUS_MENUNGGU_KONFIRMASI_USER }}" class="bg-indigo-500 hover:bg-indigo-700 text-white font-bold py-2 px-4 rounded">
                                Jadwal Ulang & Minta Konfirmasi User
                            </button>
                            <button type="submit" name="konfirmasi" value="{{ \App\Models\Pendampingan::STATUS_DIBATALKAN }}" class="bg-red-500 hover:bg-red-700 text-white font-bold py-2 px-4 rounded" onclick="return confirm('Apakah Anda yakin ingin menolak permintaan ini?');">
                                Tolak Permintaan
                            </button>
                        </div>
                    </form>
                </div>
            </div>

            <!-- Hidden data container for JavaScript -->
            <div id="instruktur-data" 
                 data-instruktur="{{ json_encode($instrukturs) }}"
                 data-current-nama-pendamping="{{ $pendampingan->nama_pendamping }}"
                 style="display: none;">
            </div>

            <script>
                document.addEventListener('DOMContentLoaded', function () {
                    const waktuInput = document.getElementById('waktu_pendampingan_staff');
                    const namaPendampingSelect = document.getElementById('nama_pendamping');
                    const dataContainer = document.getElementById('instruktur-data');

                    // Get data from hidden container
                    const instrukturData = JSON.parse(dataContainer.getAttribute('data-instruktur'));
                    const currentNamaPendamping = dataContainer.getAttribute('data-current-nama-pendamping');

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
                        let displayElement = document.getElementById('waktu-display-staff');
                        if (!displayElement) {
                            displayElement = document.createElement('div');
                            displayElement.id = 'waktu-display-staff';
                            displayElement.className = 'mt-1 text-sm text-blue-600 font-medium';
                            this.parentNode.appendChild(displayElement);
                        }
                        
                        if (waktuFormatted) {
                            displayElement.textContent = `Waktu yang dipilih: ${waktuFormatted}`;
                        } else {
                            displayElement.textContent = '';
                        }
                    });

                    // Trigger waktu format on page load
                    setTimeout(function() {
                        waktuInput.dispatchEvent(new Event('change'));
                    }, 100);
                });
            </script>
            @endif

            <div class="flex items-center justify-end mt-4">
                <x-secondary-button onclick="window.history.back()" class="mr-3">
                    {{ __('Kembali') }}
                </x-secondary-button>
                @if(auth()->user()->role === 'staff')
                    <a href="{{ route('staff.pendampingan.edit', $pendampingan->id) }}" class="inline-flex items-center px-4 py-2 bg-indigo-600 border border-transparent rounded-md font-semibold text-xs text-white uppercase tracking-widest hover:bg-indigo-700 focus:bg-indigo-700 active:bg-indigo-900 focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:ring-offset-2 transition ease-in-out duration-150 mr-3">
                        {{ __('Edit') }}
                    </a>
                    <form action="{{ route('staff.pendampingan.destroy', $pendampingan->id) }}" method="POST" class="inline" onsubmit="return confirm('Apakah Anda yakin ingin menghapus jadwal pendampingan ini?');">
                        @csrf
                        @method('DELETE')
                        <x-danger-button>
                            {{ __('Hapus') }}
                        </x-danger-button>
                    </form>
                @elseif($pendampingan->isMenungguKonfirmasiUser())
                    <form action="{{ route('pendampingan.update-konfirmasi', $pendampingan->id) }}" method="POST" class="inline ml-3">
                        @csrf
                        @method('PUT')
                        <input type="hidden" name="konfirmasi" value="{{ \App\Models\Pendampingan::STATUS_TERKONFIRMASI }}">
                        <x-primary-button class="bg-green-600 hover:bg-green-700">
                            {{ __('Setuju') }}
                        </x-primary-button>
                    </form>
                    <form action="{{ route('pendampingan.update-konfirmasi', $pendampingan->id) }}" method="POST" class="inline ml-3">
                        @csrf
                        @method('PUT')
                        <input type="hidden" name="konfirmasi" value="{{ \App\Models\Pendampingan::STATUS_DIBATALKAN }}">
                        <x-danger-button>
                            {{ __('Tolak') }}
                        </x-danger-button>
                    </form>
                @endif
            </div>
        </div>
    </div>

    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/flatpickr/dist/flatpickr.min.css">
    <script src="https://cdn.jsdelivr.net/npm/flatpickr"></script>
</x-app-layout> 