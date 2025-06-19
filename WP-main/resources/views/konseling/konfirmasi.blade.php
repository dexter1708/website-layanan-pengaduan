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
            <li class="text-gray-500">Konfirmasi</li>
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
                <p>Menunggu Jadwal</p>
            </div>
        </div>

        <div class="mt-6 text-end flex gap-2 justify-end">
            <form method="POST" action="#">
                @csrf
                <button type="submit"
                        class="bg-red-600 text-white text-sm font-medium py-2 px-4 rounded hover:bg-red-700 transition">
                    Jadwal Ditolak
                </button>
            </form>

            <form method="POST" action="#">
                @csrf
                <button type="submit"
                        class="bg-green-600 text-white text-sm font-medium py-2 px-4 rounded hover:bg-green-700 transition">
                    Konfirmasi Jadwal
                </button>
            </form>
        </div>
    </div>
</section>

@endsection
