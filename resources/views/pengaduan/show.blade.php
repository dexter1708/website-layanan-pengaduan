@extends('template.main')
@section('content_template')

<section class="bg-gray-100 py-8 px-4 sm:px-6 lg:px-8">
    <div class="max-w-4xl mx-auto">
        <!-- Breadcrumb -->
        <nav class="text-sm text-gray-600 font-semibold mb-6" aria-label="Breadcrumb">
            <ol class="flex items-center space-x-2">
                <li><a href="{{ url('/') }}" class="text-blue-600 hover:underline">Homepage</a></li>
                <li class="text-gray-600">/</li>
                <li><a href="{{ route('pengaduan.index') }}" class="text-blue-600 hover:underline">Layanan Pengaduan</a></li>
                <li class="text-gray-600">/</li>
                <li class="text-gray-500">Detail Pengaduan</li>
            </ol>
        </nav>

        <div class="bg-white rounded-lg shadow-md">
            <!-- Header -->
            <div class="p-6 border-b border-gray-200 flex justify-between items-center">
                <span class="bg-blue-100 text-blue-800 text-sm font-semibold px-4 py-2 rounded-lg">
                    Laporan Pengaduan #{{ $pengaduan->id }}
            </div>

            <!-- Detail Content -->
            <div class="p-8">
                <h2 class="text-2xl font-bold text-gray-800 mb-6">Identitas Korban & Detail Kasus</h2>
                
                <div class="grid grid-cols-1 md:grid-cols-2 gap-x-8 gap-y-6">
                    <!-- Kolom Kiri -->
                    <div>
                        <div class="mb-4">
                            <label class="block text-sm font-semibold text-gray-600 mb-1">Nama Lengkap</label>
                            <p class="text-gray-800">{{ $pengaduan->korban->nama ?? '-' }}</p>
                        </div>
                        <div class="mb-4">
                            <label class="block text-sm font-semibold text-gray-600 mb-1">Disabilitas</label>
                            <p class="text-gray-800">{{ $pengaduan->korban->disabilitas ?? '-' }}</p>
                        </div>
                        <div class="mb-4">
                            <label class="block text-sm font-semibold text-gray-600 mb-1">Pendidikan</label>
                            <p class="text-gray-800">{{ $pengaduan->korban->pendidikan ?? '-' }}</p>
                        </div>
                        <div class="mb-4">
                            <label class="block text-sm font-semibold text-gray-600 mb-1">Status Perkawinan</label>
                            <p class="text-gray-800">{{ $pengaduan->korban->status_perkawinan ?? '-' }}</p>
                        </div>
                        <div class="mb-4">
                            <label class="block text-sm font-semibold text-gray-600 mb-1">Tempat Kejadian</label>
                            <p class="text-gray-800">{{ $pengaduan->tempat_kejadian ?? '-' }}</p>
                        </div>
                        <div class="mb-4">
                            <label class="block text-sm font-semibold text-gray-600 mb-1">Tanggal Kejadian</label>
                            <p class="text-gray-800">{{ $pengaduan->tanggal_kejadian ? \Carbon\Carbon::parse($pengaduan->tanggal_kejadian)->format('d-m-Y') : '-' }}</p>
                        </div>
                    </div>

                    <!-- Kolom Kanan -->
                    <div>
                        <div class="mb-4">
                            <label class="block text-sm font-semibold text-gray-600 mb-1">Jenis Kelamin</label>
                            <p class="text-gray-800">{{ $pengaduan->korban->jenis_kelamin ?? '-' }}</p>
                        </div>
                        <div class="mb-4">
                            <label class="block text-sm font-semibold text-gray-600 mb-1">Usia saat Kejadian</label>
                            <p class="text-gray-800">{{ $pengaduan->korban->usia ?? '-' }}</p>
                        </div>
                        <div class="mb-4">
                            <label class="block text-sm font-semibold text-gray-600 mb-1">Pekerjaan</label>
                            <p class="text-gray-800">{{ $pengaduan->korban->pekerjaan ?? '-' }}</p>
                        </div>
                        <div class="mb-4">
                            <label class="block text-sm font-semibold text-gray-600 mb-1">No Handphone</label>
                            <p class="text-gray-800">{{ $pengaduan->korban->no_telepon ?? '-' }}</p>
                        </div>
                        <div class="mb-4">
                            <label class="block text-sm font-semibold text-gray-600 mb-1">Kecamatan</label>
                            <p class="text-gray-800">{{ $pengaduan->kecamatan ?? '-' }}</p>
                        </div>
                    </div>
                </div>

                <!-- Kronologi -->
                <div class="mt-6">
                    <label class="block text-sm font-semibold text-gray-600 mb-1">Kronologi Kejadian</label>
                    <p class="text-gray-800 bg-gray-50 p-4 rounded-md whitespace-pre-line">{{ $pengaduan->kronologi ?? 'Tidak ada kronologi.' }}</p>
                </div>

            </div>
        </div>

    </div>
</section>

@endsection 