@extends('template.main')
@section('content_template')

<section class="bg-gray-50 py-8 px-4 sm:px-6 lg:px-8">
    <!-- Breadcrumb -->
    <nav class="text-sm text-gray-600 font-semibold mb-6" aria-label="Breadcrumb">
        <ol class="flex items-center space-x-2">
            <li><a href="{{ url('/') }}" class="text-blue-600 hover:underline">Homepage</a></li>
            <li class="text-gray-600">/</li>
            <li><a href="{{ route('konseling.index') }}" class="text-blue-600 hover:underline">Konseling</a></li>
            <li class="text-gray-600">/</li>
            <li class="text-gray-500">Konfirmasi Jadwal</li>
        </ol>
    </nav>

    <div class="max-w-4xl mx-auto">
        <div class="bg-white shadow-md rounded-lg border-2 border-blue-400 overflow-hidden">
            <div class="px-6 py-4 bg-gray-50 border-b">
                <h2 class="text-xl font-bold text-gray-800">Layanan Konseling Korban</h2>
            </div>
            <div class="px-6 py-5">
                <div class="grid grid-cols-1 md:grid-cols-2 gap-x-8 gap-y-6 text-base">
                    <!-- Kolom Kiri -->
                    <div class="space-y-5">
                        <div>
                            <p class="text-sm text-gray-500 font-semibold">Jenis Konseling</p>
                            <p class="text-gray-900 font-semibold">{{ $konseling->jenis_layanan }}</p>
                        </div>
                        <div>
                            <p class="text-sm text-gray-500 font-semibold">Tanggal Konseling</p>
                            <p class="text-gray-900 font-semibold">{{ \Carbon\Carbon::parse($konseling->jadwal_konseling)->isoFormat('dddd, D MMMM Y') }}</p>
                        </div>
                        <div>
                            <p class="text-sm text-gray-500 font-semibold">Nama Konselor</p>
                            <p class="text-gray-900 font-semibold">{{ $konseling->nama_konselor }}</p>
                        </div>
                    </div>
                    <!-- Kolom Kanan -->
                    <div class="space-y-5">
                        <div>
                            <p class="text-sm text-gray-500 font-semibold">Waktu Konseling</p>
                            <p class="text-gray-900 font-semibold">{{ \Carbon\Carbon::parse($konseling->jadwal_konseling)->format('H:i') }} WIB</p>
                        </div>
                        <div>
                            <p class="text-sm text-gray-500 font-semibold">Tempat</p>
                            <p class="text-gray-900 font-semibold">{{ $konseling->tempat_konseling }}</p>
                        </div>
                    </div>
                </div>
            </div>
            <div class="bg-gray-50 px-6 py-4">
                <form method="POST" action="{{ route('konseling.konfirmasi.update', $konseling->id) }}" class="flex items-center justify-center gap-4">
                    @csrf
                    @method('PUT')
                    <button type="submit" name="konfirmasi" value="setuju" class="w-full sm:w-auto bg-green-500 hover:bg-green-600 text-white font-bold py-3 px-8 rounded-lg transition duration-300">
                        Setuju
                    </button>
                    <button type="submit" name="konfirmasi" value="tolak" class="w-full sm:w-auto bg-red-500 hover:bg-red-600 text-white font-bold py-3 px-8 rounded-lg transition duration-300">
                        Tolak
                    </button>
                </form>
            </div>
        </div>
    </div>
</section>

@endsection
