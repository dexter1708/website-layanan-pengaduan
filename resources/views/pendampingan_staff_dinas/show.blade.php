@extends('template.main')
@section('content_template')

<section class="bg-gray-50 py-8 px-4 sm:px-6 lg:px-8">
    <!-- Breadcrumb -->
    <nav class="text-sm text-gray-600 font-semibold mb-6" aria-label="Breadcrumb">
        <ol class="flex items-center space-x-2">
            <li><a href="{{ url('/') }}" class="text-blue-600 hover:underline">Homepage</a></li>
            <li class="text-gray-600">/</li>
            <li><a href="{{ route('pendampingan.index') }}" class="text-blue-600 hover:underline">Pendampingan</a></li>
            <li class="text-gray-600">/</li>
            <li class="text-gray-500">Detail Jadwal</li>
        </ol>
    </nav>

    <div class="max-w-4xl mx-auto">
        <div class="bg-white shadow-md rounded-lg border-2 border-blue-400 overflow-hidden">
            <div class="px-6 py-4 bg-gray-50 border-b flex justify-between items-center">
                <h2 class="text-xl font-bold text-gray-800">Detail Layanan Pendampingan</h2>
                @php
                    $badge = match($pendampingan->konfirmasi ?? '') {
                        'menunggu_konfirmasi_user' => 'bg-gray-600 text-white',
                        'setuju' => 'bg-green-600 text-white',
                        'tolak' => 'bg-red-600 text-white',
                        'butuh_konfirmasi_staff' => 'bg-yellow-400 text-black',
                        default => 'bg-gray-400 text-white',
                    };
                    $statusLabel = match($pendampingan->konfirmasi ?? '') {
                        'menunggu_konfirmasi_user' => 'Menunggu Konfirmasi User',
                        'setuju' => 'Terkonfirmasi',
                        'tolak' => 'Ditolak',
                        'butuh_konfirmasi_staff' => 'Menunggu Konfirmasi Staff',
                        default => 'Tidak Diketahui',
                    };
                @endphp
                <span class="px-3 py-1 rounded text-sm font-semibold {{ $badge }}">
                    {{ $statusLabel }}
                </span>
            </div>
            <div class="px-6 py-5">
                <div class="grid grid-cols-1 md:grid-cols-2 gap-x-8 gap-y-6 text-base">
                    <!-- Kolom Kiri -->
                    <div class="space-y-5">
                        <div>
                            <p class="text-sm text-gray-500 font-semibold">ID Pengaduan</p>
                            <p class="text-gray-900 font-semibold">{{ $pendampingan->pengaduan_id ?? '10082874' }}</p>
                        </div>
                        <div>
                            <p class="text-sm text-gray-500 font-semibold">Nama Korban</p>
                            <p class="text-gray-900 font-semibold">
                                @if(isset($pendampingan->korban) && $pendampingan->korban)
                                    {{ $pendampingan->korban->nama }}
                                @else
                                    Aisyah Nanda
                                @endif
                            </p>
                        </div>
                        <div>
                            <p class="text-sm text-gray-500 font-semibold">Jenis Layanan</p>
                            <p class="text-gray-900 font-semibold">{{ $pendampingan->jenis_layanan ?? 'Kekerasan terhadap perempuan' }}</p>
                        </div>
                    </div>
                    <!-- Kolom Kanan -->
                    <div class="space-y-5">
                        <div>
                            <p class="text-sm text-gray-500 font-semibold">Nama Pendamping</p>
                            <p class="text-gray-900 font-semibold">
                                @if(isset($pendampingan->nama_pendamping) && $pendampingan->nama_pendamping && $pendampingan->nama_pendamping !== 'Belum ditentukan')
                                    {{ $pendampingan->nama_pendamping }}
                                @else
                                    <span class="text-gray-500 italic">Belum ditentukan</span>
                                @endif
                            </p>
                        </div>
                        <div>
                            <p class="text-sm text-gray-500 font-semibold">Jadwal</p>
                            <p class="text-gray-900 font-semibold">
                                @if(isset($pendampingan->tanggal_pendampingan) && $pendampingan->tanggal_pendampingan)
                                    {{ \Carbon\Carbon::parse($pendampingan->tanggal_pendampingan)->isoFormat('dddd, D MMMM Y') }} - {{ \Carbon\Carbon::parse($pendampingan->tanggal_pendampingan)->format('H:i') }} WIB
                                @else
                                    15-02-2025 - 10:00 WIB
                                @endif
                            </p>
                        </div>
                        <div>
                            <p class="text-sm text-gray-500 font-semibold">Tempat</p>
                            <p class="text-gray-900 font-semibold">
                                @if(isset($pendampingan->tempat_pendampingan) && $pendampingan->tempat_pendampingan && $pendampingan->tempat_pendampingan !== 'Belum ditentukan')
                                    {{ $pendampingan->tempat_pendampingan }}
                                @else
                                    <span class="text-gray-500 italic">Belum ditentukan</span>
                                @endif
                            </p>
                        </div>
                    </div>
                </div>
            </div>
            
            <div class="bg-gray-50 px-6 py-4 text-right">
                <a href="{{ route('pendampingan.index') }}"
                   class="bg-gray-400 text-white text-sm font-medium py-2 px-4 rounded hover:bg-gray-500 transition">
                    Kembali
                </a>
            </div>
        </div>
    </div>
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
            <a href="{{ url('/pendampingan/create') }}"
               class="bg-blue-500 text-white text-sm font-medium py-2 px-4 rounded hover:bg-blue-600 transition">
                Buat Jadwal Baru
            </a>
        </div>
    </div>
</section>

@endsection
