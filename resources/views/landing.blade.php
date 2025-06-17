<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>SAPA - Sahabat Perempuan dan Anak</title>
    <script src="https://cdn.tailwindcss.com"></script>
</head>
<body>
    <!-- Header/Navbar -->
    <header class="bg-white shadow-sm border-b">
        <nav class="container mx-auto px-6 py-3 flex justify-between items-center">
            <div class="flex items-center">
                <div class="w-8 h-8 bg-blue-500 rounded-full flex items-center justify-center mr-2">
                    <span class="text-white font-bold text-sm">S</span>
                </div>
                <span class="text-xl font-bold text-gray-800">SAPA</span>
            </div>
            <div class="flex items-center space-x-6">
                <a href="{{ url('/') }}" class="text-gray-600 hover:text-blue-600">Homepage</a>
                <a href="{{ route('dashboard') }}" class="text-gray-600 hover:text-blue-600">Dashboard</a>
                <div class="relative group">
                    <a href="#" class="text-gray-600 hover:text-blue-600 flex items-center">
                        Layanan
                        <svg class="ml-1 w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7"></path></svg>
                    </a>
                    <div class="absolute hidden group-hover:block bg-white shadow-lg py-2 rounded-md">
                        <a href="{{ route('pengaduan.create') }}" class="block px-4 py-2 text-gray-800 hover:bg-gray-100">Layanan Pengaduan</a>
                        <a href="{{ route('tracking.index') }}" class="block px-4 py-2 text-gray-800 hover:bg-gray-100">Track Pengaduan</a>
                        <a href="{{ route('pendampingan.index') }}" class="block px-4 py-2 text-gray-800 hover:bg-gray-100">Layanan Pendampingan</a>
                        <a href="{{ route('konseling.index') }}" class="block px-4 py-2 text-gray-800 hover:bg-gray-100">Layanan Konseling</a>
                    </div>
                </div>
                <a href="#" class="text-gray-600 hover:text-blue-600">Edukasi</a>
                <a href="#" class="text-gray-600 hover:text-blue-600">About</a>
            </div>
            <div class="flex space-x-4">
                <a href="{{ route('login') }}" class="bg-blue-500 text-white px-4 py-2 rounded hover:bg-blue-600">Login</a>
                <a href="{{ route('register') }}" class="border border-blue-500 text-blue-500 px-4 py-2 rounded hover:bg-blue-50">Register</a>
            </div>
        </nav>
    </header>

    <!-- Hero Section -->
    <section class="bg-gradient-to-br from-blue-50 to-indigo-100 py-16">
        <div class="container mx-auto px-6 flex flex-col md:flex-row items-center justify-between">
            <div class="md:w-1/2 text-center md:text-left mb-10 md:mb-0">
                <h1 class="text-5xl font-bold text-gray-800 leading-tight mb-2">SAPA</h1>
                <h2 class="text-2xl font-semibold text-gray-700 mb-6">Sahabat Perempuan dan Anak</h2>
                <p class="text-gray-600 text-base mb-8 leading-relaxed">Dignissim a, velit odio sed convallis facilisi vulputate. Consectetur ultricies metus porttitor id urna, sapien mauris sed. Quis placerat ac urna, massa lectus. Consequat eu eu quam id sit consequat condimentum.</p>
                <a href="{{ route('pengaduan.create') }}" class="bg-blue-500 text-white px-6 py-3 rounded-lg text-lg hover:bg-blue-600">Learn More</a>
            </div>
            <div class="md:w-1/2 flex justify-center">
                <div class="w-64 h-64 bg-blue-500 rounded-full flex items-center justify-center shadow-lg">
                    <div class="w-48 h-48 bg-blue-400 rounded-full flex items-center justify-center">
                        <div class="text-white text-center">
                            <div class="flex justify-center mb-2">
                                <div class="w-12 h-12 bg-white rounded-full flex items-center justify-center mr-2">
                                    <div class="w-8 h-8 bg-blue-400 rounded-full"></div>
                                </div>
                                <div class="w-10 h-10 bg-pink-400 rounded-full"></div>
                            </div>
                            <div class="w-20 h-6 bg-orange-300 rounded-full mx-auto"></div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <!-- Services Section -->
    <section class="py-20 bg-white">
        <div class="container mx-auto px-6">
            <h2 class="text-4xl font-bold text-center text-gray-800 mb-4">Layanan</h2>
            <p class="text-center text-gray-600 text-lg mb-12">Pilihan Layanan dari SAPA untuk Pelapor</p>

            <div class="grid grid-cols-1 md:grid-cols-3 gap-8 mb-8">
                <!-- Layanan Pengaduan Card -->
                <div class="bg-gray-50 p-8 rounded-lg shadow-md hover:shadow-lg transition-shadow duration-300">
                    <h3 class="text-2xl font-semibold text-gray-800 mb-4">Layanan Pengaduan</h3>
                    <p class="text-gray-600 mb-6">Menerapkan metode pembelajaran adaptif yang dapat membantu Code Friends untuk memaksimalkan pemahaman terhadap penerapan dari bahasa pemrograman.</p>
                    <a href="{{ route('pengaduan.create') }}" class="text-blue-500 hover:underline">More Detail</a>
                </div>

                <!-- Track Pengaduan Card -->
                <div class="bg-gray-50 p-8 rounded-lg shadow-md hover:shadow-lg transition-shadow duration-300">
                    <h3 class="text-2xl font-semibold text-gray-800 mb-4">Track Pengaduan</h3>
                    <p class="text-gray-600 mb-6">Menerapkan metode pembelajaran adaptif yang dapat membantu Code Friends untuk memaksimalkan pemahaman terhadap penerapan dari bahasa pemrograman.</p>
                    <a href="{{ route('tracking.index') }}" class="text-blue-500 hover:underline">More</a>
                </div>

                <!-- Layanan Pendampingan Card -->
                <div class="bg-gray-50 p-8 rounded-lg shadow-md hover:shadow-lg transition-shadow duration-300">
                    <h3 class="text-2xl font-semibold text-gray-800 mb-4">Layanan Pendampingan</h3>
                    <p class="text-gray-600 mb-6">Menerapkan metode pembelajaran adaptif yang dapat membantu Code Friends untuk memaksimalkan pemahaman terhadap penerapan dari bahasa pemrograman.</p>
                    <a href="{{ route('pendampingan.index') }}" class="text-blue-500 hover:underline">More</a>
                </div>
            </div>

            <div class="grid grid-cols-1 md:grid-cols-2 gap-8 max-w-4xl mx-auto">
                <!-- Layanan Konseling Card -->
                <div class="bg-gray-50 p-8 rounded-lg shadow-md hover:shadow-lg transition-shadow duration-300">
                    <h3 class="text-2xl font-semibold text-gray-800 mb-4">Layanan Konseling</h3>
                    <p class="text-gray-600 mb-6">Menerapkan metode pembelajaran adaptif yang dapat membantu Code Friends untuk memaksimalkan pemahaman terhadap penerapan dari bahasa pemrograman.</p>
                    <a href="{{ route('konseling.index') }}" class="text-blue-500 hover:underline">More</a>
                </div>

                <!-- Edukasi Card -->
                <div class="bg-gray-50 p-8 rounded-lg shadow-md hover:shadow-lg transition-shadow duration-300">
                    <h3 class="text-2xl font-semibold text-gray-800 mb-4">Edukasi</h3>
                    <p class="text-gray-600 mb-6">Menerapkan metode pembelajaran adaptif yang dapat membantu Code Friends untuk memaksimalkan pemahaman terhadap penerapan dari bahasa pemrograman.</p>
                    <a href="#" class="text-blue-500 hover:underline">More</a>
                </div>
            </div>
        </div>
    </section>

    <!-- Supported By Section -->
    <section class="py-16 bg-gray-50">
        <div class="container mx-auto px-6 text-center">
            <h2 class="text-3xl font-bold text-gray-800 mb-4">Didukung Oleh</h2>
            <p class="text-gray-600 text-lg mb-12">Lembaga yang bekerjasama dengan SAPA</p>
            
            <div class="flex items-center justify-center">
                <button class="p-2 rounded-full bg-white shadow-md mr-6 hover:bg-gray-50">
                    <svg class="w-6 h-6 text-gray-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 19l-7-7 7-7"></path>
                    </svg>
                </button>
                
                <div class="flex items-center justify-center space-x-12">
                    <!-- Logo Bandung -->
                    <div class="w-16 h-16 bg-green-500 rounded-lg flex items-center justify-center">
                        <span class="text-white font-bold text-xs">BANDUNG</span>
                    </div>
                    
                    <!-- Logo DP3A -->
                    <div class="w-16 h-16 bg-gradient-to-r from-pink-400 to-purple-500 rounded-lg flex items-center justify-center">
                        <span class="text-white font-bold text-xs">DP3A</span>
                    </div>
                    
                    <!-- Logo UPTD -->
                    <div class="w-16 h-16 bg-blue-500 rounded-lg flex items-center justify-center">
                        <span class="text-white font-bold text-xs">UPTD</span>
                    </div>
                    
                    <!-- Logo Rumah -->
                    <div class="w-16 h-16 bg-orange-500 rounded-lg flex items-center justify-center">
                        <div class="text-white">
                            <div class="w-8 h-4 bg-orange-600 mx-auto mb-1"></div>
                            <div class="w-6 h-3 bg-orange-600 mx-auto"></div>
                        </div>
                    </div>
                </div>
                
                <button class="p-2 rounded-full bg-white shadow-md ml-6 hover:bg-gray-50">
                    <svg class="w-6 h-6 text-gray-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"></path>
                    </svg>
                </button>
            </div>
        </div>
    </section>

    <!-- Footer -->
    <footer class="bg-gray-800 text-white py-12">
        <div class="container mx-auto px-6">
            <div class="grid grid-cols-1 md:grid-cols-3 gap-8 mb-8">
                <div class="flex items-center">
                    <div class="w-8 h-8 bg-blue-500 rounded-full flex items-center justify-center mr-2">
                        <span class="text-white font-bold text-sm">S</span>
                    </div>
                    <span class="text-xl font-bold">SAPA</span>
                </div>
                
                <div>
                    <h4 class="text-lg font-semibold mb-4">Quick Links</h4>
                    <ul>
                        <li><a href="{{ url('/') }}" class="hover:underline">Homepage</a></li>
                        <li><a href="{{ route('dashboard') }}" class="hover:underline">Dashboard</a></li>
                        <li><a href="{{ route('pengaduan.create') }}" class="hover:underline">Layanan Pengaduan</a></li>
                        <li><a href="{{ route('tracking.index') }}" class="hover:underline">Track Pengaduan</a></li>
                        <li><a href="{{ route('pendampingan.index') }}" class="hover:underline">Layanan Pendampingan</a></li>
                        <li><a href="{{ route('konseling.index') }}" class="hover:underline">Layanan Konseling</a></li>
                        <li><a href="#" class="hover:underline">Edukasi</a></li>
                        <li><a href="{{ route('profile.edit') }}" class="hover:underline">Profile</a></li>
                    </ul>
                </div>
                
                <div>
                    <h4 class="text-lg font-semibold mb-4">Follow Us</h4>
                    <div class="flex space-x-4">
                        <a href="#" class="text-gray-400 hover:text-white"><i class="fab fa-youtube"></i></a>
                        <a href="#" class="text-gray-400 hover:text-white"><i class="fab fa-facebook-f"></i></a>
                        <a href="#" class="text-gray-400 hover:text-white"><i class="fab fa-twitter"></i></a>
                        <a href="#" class="text-gray-400 hover:text-white"><i class="fab fa-instagram"></i></a>
                        <a href="#" class="text-gray-400 hover:text-white"><i class="fab fa-linkedin-in"></i></a>
                    </div>
                </div>
            </div>
            
            <div class="text-center text-gray-400 text-sm border-t border-gray-700 pt-6">
                <p>SAPA 2023. All rights reserved.</p>
            </div>
        </div>
    </footer>
</body>
</html>