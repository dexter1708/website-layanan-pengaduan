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
        <li><a href="{{ url('/pendampingan') }}" class="text-blue-600 hover:underline">Pendampingan</a></li>
        <li class="text-gray-600">/</li>
        <li class="text-gray-500">Buat Jadwal</li>
    </ol>
</nav>


    <!-- Form -->
    <form method="POST" action="#" class="bg-white shadow-md rounded-lg p-6">
        @csrf
        <h2 class="text-lg font-semibold text-gray-800 mb-6">Layanan Pendampingan Korban</h2>

        <div class="grid grid-cols-1 sm:grid-cols-2 gap-6">
            <!-- ID Pengaduan -->
            <div>
                <label class="block font-semibold text-gray-800 mb-1">ID Pengaduan</label>
                <input type="text" name="id_pengaduan" placeholder="ID Pengaduan"
                    class="w-full bg-blue-50 text-gray-800 px-4 py-2 border-b border-gray-300 focus:outline-none" />
            </div>

            <!-- Nama Korban -->
            <div>
                <label class="block font-semibold text-gray-800 mb-1">Nama Korban</label>
                <input type="text" name="nama_korban" placeholder="Nama Korban"
                    class="w-full bg-blue-50 text-gray-800 px-4 py-2 border-b border-gray-300 focus:outline-none" />
            </div>

            <!-- Tanggal Pendampingan -->
            <div>
                <label class="block font-semibold text-gray-800 mb-1">Tanggal Pendampingan *</label>
                <input type="date" name="tanggal_pendampingan"
                    class="w-full bg-blue-50 text-gray-800 px-4 py-2 border-b border-gray-300 focus:outline-none" />
            </div>

            <!-- Waktu Pendampingan -->
            <div>
                <label class="block font-semibold text-gray-800 mb-1">Waktu Pendampingan *</label>
                <select name="waktu_pendampingan"
                    class="w-full bg-blue-50 text-gray-800 px-4 py-2 border-b border-gray-300 focus:outline-none">
                    <option value="" selected disabled>-- Pilih Waktu --</option>
                    <option value="08:00">08:00</option>
                    <option value="10:00">10:00</option>
                    <option value="13:00">13:00</option>
                    <option value="15:00">15:00</option>
                </select>
            </div>

            <!-- Jenis Pelayanan -->
            <div class="sm:col-span-2">
                <label class="block font-semibold text-gray-800 mb-1">Jenis Pelayanan</label>
                <select name="jenis_pelayanan"
                    class="w-full bg-blue-50 text-gray-800 px-4 py-2 border-b border-gray-300 focus:outline-none">
                    <option value="" selected disabled>Jenis Pelayanan</option>
                    <option value="Layanan Hukum">Layanan Hukum</option>
                    <option value="Layanan Kesehatan">Layanan Kesehatan</option>
                    <option value="Layanan Rehabilitasi Sosial">Layanan Rehabilitasi Sosial</option>
                    <option value="Layanan Reintegrasi Sosial">Layanan Reintegrasi Sosial</option>
                </select>
            </div>
        </div>

        <!-- Tombol -->
        <div class="flex justify-center mt-6 gap-4">
            <a href="{{ url('/pendampingan') }}" type="button"
                class="bg-blue-400 text-white px-6 py-2 rounded hover:bg-blue-500 transition">
                Batal
            </a>
            <button type="submit" class="bg-blue-500 text-white px-6 py-2 rounded hover:bg-blue-600">
                Simpan
            </button>
        </div>
    </form>
</section>

@endsection
