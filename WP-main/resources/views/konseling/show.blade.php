{{-- <x-app-layout>
    <x-slot name="header">
        <div class="flex justify-between items-center">
            <h2 class="font-semibold text-xl text-gray-800 leading-tight">
                {{ __('Detail Konseling') }}
            </h2>
            @if(auth()->user()->role !== 'staff' && ($konseling->konfirmasi === 'menunggu' || $konseling->konfirmasi === 'menunggu_konfirmasi_user'))
            <div class="flex space-x-2">
                <form action="{{ route('konseling.update-konfirmasi', $konseling->id) }}" method="POST" class="inline">
                    @csrf
                    @method('PUT')
                    <input type="hidden" name="konfirmasi" value="setuju">
                    <x-primary-button>
                        {{ __('Setuju') }}
                    </x-primary-button>
                </form>
                <form action="{{ route('konseling.update-konfirmasi', $konseling->id) }}" method="POST" class="inline">
                    @csrf
                    @method('PUT')
                    <input type="hidden" name="konfirmasi" value="tolak">
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

            <!-- Informasi Konseling -->
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg mb-6">
                <div class="p-6 text-gray-900">
                    <h3 class="text-lg font-semibold mb-4">Informasi Konseling</h3>
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                        <div>
                            <p class="text-sm text-gray-600">ID Pengaduan</p>
                            <p class="font-medium">{{ $konseling->pengaduan->id }}</p>
                        </div>
                        <div>
                            <p class="text-sm text-gray-600">Status</p>
                            <span class="px-2 inline-flex text-xs leading-5 font-semibold rounded-full
                                @if($konseling->konfirmasi === 'setuju') bg-green-100 text-green-800
                                @elseif($konseling->konfirmasi === 'tolak') bg-red-100 text-red-800
                                @else bg-yellow-100 text-yellow-800
                                @endif">
                                {{ $konseling->getStatusLabel() }}
                            </span>
                        </div>
                        <div>
                            <p class="text-sm text-gray-600">Nama Korban</p>
                            <p class="font-medium">{{ $konseling->nama_korban }}</p>
                        </div>
                        <div>
                            <p class="text-sm text-gray-600">Jenis Layanan</p>
                            <p class="font-medium">{{ $konseling->jenis_layanan ?? 'Belum ditentukan' }}</p>
                        </div>
                        <div>
                            <p class="text-sm text-gray-600">Nama Konselor</p>
                            <p class="font-medium">{{ $konseling->nama_konselor !== 'Belum ditentukan' ? $konseling->nama_konselor : 'Belum ditentukan' }}</p>
                        </div>
                        <div>
                            <p class="text-sm text-gray-600">Jadwal Konseling</p>
                            <p class="font-medium">{{ $konseling->getJadwalKonselingFormatted() }}</p>
                        </div>
                        <div>
                            <p class="text-sm text-gray-600">Waktu Konseling</p>
                            <p class="font-medium">{{ $konseling->getWaktuKonselingFormatted() }}</p>
                        </div>
                        <div>
                            <p class="text-sm text-gray-600">Tempat Konseling</p>
                            <p class="font-medium">{{ $konseling->tempat_konseling !== 'Belum ditentukan' ? $konseling->tempat_konseling : 'Belum ditentukan' }}</p>
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
                            <p class="font-medium">{{ $konseling->getTanggalPengaduanFormatted() }}</p>
                        </div>
                        <div>
                            <p class="text-sm text-gray-600">Status Pengaduan</p>
                            <span class="px-2 inline-flex text-xs leading-5 font-semibold rounded-full
                                @if($konseling->pengaduan->status === 'selesai') bg-green-100 text-green-800
                                @elseif($konseling->pengaduan->status === 'ditolak') bg-red-100 text-red-800
                                @else bg-yellow-100 text-yellow-800
                                @endif">
                                {{ ucfirst($konseling->pengaduan->status) }}
                            </span>
                        </div>
                        <div class="col-span-2">
                            <p class="text-sm text-gray-600">Kronologi</p>
                            <p class="font-medium">{{ $konseling->pengaduan->kronologi }}</p>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Hidden data container for JavaScript -->
    <div id="instruktur-data"
         data-instruktur="{{ json_encode($instrukturs) }}"
         data-current-konselor="{{ $konseling->nama_konselor }}"
         style="display: none;">
    </div>

    @push('scripts')
        <script>
            document.addEventListener('DOMContentLoaded', function () {
                const namaKonselorSelect = document.getElementById('nama_konselor');
                const dataContainer = document.getElementById('instruktur-data');

                if (namaKonselorSelect && dataContainer) {
                    // Get data from hidden container
                    const instrukturData = JSON.parse(dataContainer.getAttribute('data-instruktur'));
                    const currentKonselor = dataContainer.getAttribute('data-current-konselor');

                    // Populate nama konselor dropdown
                    if (instrukturData && instrukturData.length > 0) {
                        instrukturData.forEach(function(instruktur) {
                            const option = document.createElement('option');
                            option.value = instruktur.nama;
                            option.textContent = instruktur.nama + ' - ' + instruktur.posisi;
                            // Set selected jika ini adalah konselor yang sedang ditampilkan
                            if (instruktur.nama === currentKonselor) {
                                option.selected = true;
                            }
                            namaKonselorSelect.appendChild(option);
                        });
                    }
                }
            });
        </script>
    @endpush
</x-app-layout>  --}}

@extends('template.main')
@section('content_template')

<section class="bg-white py-6 px-4 sm:px-6 lg:px-8">
    <!-- Breadcrumb -->
    <nav class="text-sm text-gray-600 font-semibold mb-6" aria-label="Breadcrumb">
        <ol class="flex items-center space-x-2">
            <li><a href="{{ url('/') }}" class="text-blue-600 hover:underline">Homepage</a></li>
            <li class="text-gray-600">/</li>
            <li><a href="#" class="text-blue-600 hover:underline">Layanan</a></li>
            <li class="text-gray-600">/</li>
            <li><a href="{{ url('/konseling') }}" class="text-blue-600 hover:underline">Konseling</a></li>
            <li class="text-gray-600">/</li>
            <li class="text-gray-500">Detail</li>
        </ol>
    </nav>

    <!-- Detail Box -->
    <div class="bg-white shadow rounded-lg p-6 mb-6">
        <div class="grid grid-cols-1 sm:grid-cols-2 gap-6 text-sm text-gray-800">
            <div>
                <p class="font-semibold">ID Pengaduan</p>
                <p>10082874</p>
            </div>
            <div>
                <p class="font-semibold">Nama Korban</p>
                <p>Aisyah Nanda</p>
            </div>
            <div>
                <p class="font-semibold">Tanggal</p>
                <p>15-02-2025</p>
            </div>
            <div>
                <p class="font-semibold">Waktu</p>
                <p>10:00</p>
            </div>
            <div>
                <p class="font-semibold">Jenis Pelayanan</p>
                <p>Kekerasan terhadap perempuan</p>
            </div>
            <div>
                <p class="font-semibold">Status</p>
                <p>Ditolak</p>
            </div>
        </div>

        <div class="mt-6 text-end">
            <a href="{{ url('/konseling/create') }}"
               class="bg-blue-500 text-white text-sm font-medium py-2 px-4 rounded hover:bg-blue-600 transition">
                Buat Jadwal Baru
            </a>
        </div>
    </div>
</section>

@endsection
