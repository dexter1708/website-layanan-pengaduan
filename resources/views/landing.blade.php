@extends('template.main')
@section('content_template')

    <!-- Hero Section -->
    <div class="container-fluid">
        <section class="bg-gradient-to-br from-blue-100 via-blue-200 to-indigo-200 py-20">
            <div class="container mx-auto px-6 flex flex-col-reverse md:flex-row items-center justify-center gap-12">
                <!-- Text Section -->
                <div class="md:w-1/2 text-center md:text-left">
                    <h1 class="text-5xl font-bold text-gray-800 leading-tight mb-4">SAPA</h1>
                    <h2 class="text-2xl font-semibold text-gray-700 mb-6">Sahabat Perempuan dan Anak</h2>
                    <p class="text-gray-600 text-base mb-8 leading-relaxed">
                        SAPA hadir sebagai layanan responsif untuk mendampingi perempuan dan anak dalam situasi darurat
                        maupun kebutuhan pendampingan khusus. 
                    </p>
                </div>

                <!-- Image Section -->
                <div class="md:w-1/2 flex justify-center">
                    <img src="{{ asset('assets/image.png') }}" alt="image" class="w-80 h-80 object-contain">
                </div>
            </div>
        </section>
    </div>


    <!-- Services Section -->
    <section class="py-20 bg-white">
        <div class="container mx-auto px-6">
            <h2 class="text-4xl font-bold text-center text-gray-800 mb-4">Layanan</h2>
            <p class="text-center text-gray-600 text-lg mb-12">Pilihan Layanan dari SAPA untuk Pelapor</p>

            <div class="grid grid-cols-1 md:grid-cols-4 gap-8 max-w-6xl mx-auto">
                <!-- Layanan Pengaduan Card -->
                <div class="bg-gray-50 p-8 rounded-lg shadow-md hover:shadow-lg transition-shadow duration-300 flex flex-col justify-between h-full">
                    <div>
                        <h3 class="text-2xl font-semibold text-gray-800 mb-4">Layanan Pengaduan</h3>
                        <p class="text-gray-600 mb-6">Membantu pelapor untuk mengajukan pengaduan kekerasan terhadap perempuan.</p>
                    </div>
                    <a href="{{ route('pengaduan.index') }}"
                        class="block bg-blue-500 text-white w-32 mx-auto px-6 py-3 rounded-lg text-lg hover:bg-blue-600 transition hover:underline mt-auto text-center">More
                    </a>
                </div>

                <!-- Track Pengaduan Card -->
                <div class="bg-gray-50 p-8 rounded-lg shadow-md hover:shadow-lg transition-shadow duration-300 flex flex-col justify-between h-full">
                    <div>
                        <h3 class="text-2xl font-semibold text-gray-800 mb-4">Track Pengaduan</h3>
                        <br>
                        <p class="text-gray-600 mb-6">Membantu pelapor untuk melacak status pengaduan yang telah diajukan.</p>
                    </div>
                    <a href="{{ route('tracking.index') }}"
                        class="block bg-blue-500 text-white w-32 mx-auto px-6 py-3 rounded-lg text-lg hover:bg-blue-600 transition hover:underline mt-auto text-center">More</a>
                </div>

                <!-- Layanan Pendampingan Card -->
                <div class="bg-gray-50 p-8 rounded-lg shadow-md hover:shadow-lg transition-shadow duration-300 flex flex-col justify-between h-full">
                    <div>
                        <h3 class="text-2xl font-semibold text-gray-800 mb-4">Layanan Pendampingan</h3>
                        <p class="text-gray-600 mb-6">Membantu pelapor untuk mendapatkan pendampingan setelah pengaduan.</p>
                    </div>
                    <a href="{{ route('pendampingan.index') }}"
                        class="block bg-blue-500 text-white w-32 mx-auto px-6 py-3 rounded-lg text-lg hover:bg-blue-600 transition hover:underline mt-auto text-center">More</a>
                </div>

                <!-- Layanan Konseling Card -->
                <div class="bg-gray-50 p-8 rounded-lg shadow-md hover:shadow-lg transition-shadow duration-300 flex flex-col justify-between h-full">
                    <div>
                        <h3 class="text-2xl font-semibold text-gray-800 mb-4">Layanan Konseling</h3>
                        <p class="text-gray-600 mb-6">Membantu pelapor untuk mendapatkan konseling khusus setelah pengaduan.</p>
                    </div>
                    <a href="{{ route('konseling.index') }}"
                        class="block bg-blue-500 text-white w-32 mx-auto px-6 py-3 rounded-lg text-lg hover:bg-blue-600 transition hover:underline mt-auto text-center">More</a>
                </div>
            </div>
        </div>
    </section>
 @include('template.footer2')

@endsection


