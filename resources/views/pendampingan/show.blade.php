@extends('template.main')
@section('content_template')

<section class="bg-gray-100 py-8 px-4 sm:px-6 lg:px-8">
    <div class="max-w-4xl mx-auto">
        <!-- Breadcrumb & Header -->
        <div class="flex flex-col sm:flex-row sm:items-center sm:justify-between mb-6">
            <nav class="text-sm text-gray-600 font-semibold" aria-label="Breadcrumb">
                <ol class="flex items-center space-x-2">
                    <li><a href="{{ route('dashboard') }}" class="text-blue-600 hover:underline">Dashboard</a></li>
                    <li class="text-gray-600">/</li>
                    <li><a href="{{ route('pendampingan.index') }}" class="text-blue-600 hover:underline">Riwayat Pendampingan</a></li>
                    <li class="text-gray-600">/</li>
                    <li class="text-gray-500">Detail Jadwal #{{ $pendampingan->id }}</li>
                </ol>
            </nav>
        </div>

        @if(session('success'))
            <div class="bg-green-100 border border-green-400 text-green-700 px-4 py-3 rounded relative mb-6" role="alert">
                <span class="block sm:inline">{{ session('success') }}</span>
            </div>
        @endif

        <!-- Detail Card -->
        <div class="bg-white rounded-lg shadow-md p-6">
            <div class="flex justify-between items-start mb-4">
                <div>
                    <h2 class="text-2xl font-bold text-gray-800">Detail Jadwal Pendampingan</h2>
                    <p class="text-sm text-gray-500">ID Pengaduan: {{ $pendampingan->pengaduan_id }}</p>
                </div>
                <span class="px-4 py-1.5 inline-flex text-sm leading-5 font-semibold rounded-full {{ $pendampingan->status_badge_class }} text-white">
                    {{ $pendampingan->status_label }}
                </span>
            </div>

            <div class="border-t border-gray-200 pt-4">
                <dl class="grid grid-cols-1 md:grid-cols-2 gap-x-8 gap-y-4">
                    <div class="sm:col-span-1">
                        <dt class="text-sm font-medium text-gray-600">Nama Korban</dt>
                        <dd class="mt-1 text-sm text-gray-900">{{ $pendampingan->korban->nama ?? 'N/A' }}</dd>
                    </div>
                    <div class="sm:col-span-1">
                        <dt class="text-sm font-medium text-gray-600">Nama Pendamping</dt>
                        <dd class="mt-1 text-sm text-gray-900">{{ $pendampingan->nama_pendamping ?? 'Belum Ditentukan' }}</dd>
                    </div>
                    <div class="sm:col-span-1">
                        <dt class="text-sm font-medium text-gray-600">Tanggal</dt>
                        <dd class="mt-1 text-sm text-gray-900">{{ $pendampingan->tanggal_pendampingan ? \Carbon\Carbon::parse($pendampingan->tanggal_pendampingan)->isoFormat('dddd, D MMMM Y') : '-' }}</dd>
                    </div>
                    <div class="sm:col-span-1">
                        <dt class="text-sm font-medium text-gray-600">Waktu</dt>
                        <dd class="mt-1 text-sm text-gray-900">{{ $pendampingan->tanggal_pendampingan ? \Carbon\Carbon::parse($pendampingan->tanggal_pendampingan)->format('H:i') . ' WIB' : '-' }}</dd>
                    </div>
                    <div class="sm:col-span-2">
                        <dt class="text-sm font-medium text-gray-600">Jenis Layanan</dt>
                        <dd class="mt-1 text-sm text-gray-900">{{ $pendampingan->jenis_layanan ?? 'N/A' }}</dd>
                    </div>
                    <div class="sm:col-span-2">
                        <dt class="text-sm font-medium text-gray-600">Tempat</dt>
                        <dd class="mt-1 text-sm text-gray-900">{{ $pendampingan->tempat_pendampingan ?? 'Belum Ditentukan' }}</dd>
                    </div>
                </dl>
            </div>
            
            <div class="border-t border-gray-200 mt-6 pt-6">
                <h3 class="text-lg font-semibold text-gray-800 mb-4">Informasi Pengaduan Terkait</h3>
                <dl class="grid grid-cols-1 md:grid-cols-2 gap-x-8 gap-y-4">
                    <div class="sm:col-span-1">
                        <dt class="text-sm font-medium text-gray-600">Tanggal Pengaduan</dt>
                        <dd class="mt-1 text-sm text-gray-900">{{ $pendampingan->pengaduan->created_at->isoFormat('dddd, D MMMM Y') }}</dd>
                    </div>
                     <div class="sm:col-span-2">
                        <dt class="text-sm font-medium text-gray-600">Kronologi Singkat</dt>
                        <dd class="mt-1 text-sm text-gray-900">{{ $pendampingan->pengaduan->kronologi }}</dd>
                    </div>
                </dl>
            </div>

        </div>
        <div class="mt-6 flex justify-end">
            <a href="{{ url()->previous() }}" class="bg-gray-300 text-gray-800 px-6 py-2 rounded-lg hover:bg-gray-400">Kembali</a>
        </div>
    </div>
</section>

@endsection 