   <!-- Footer -->
    <footer class="bg-[#011430] text-white py-10">
        <div class="container mx-auto px-6">
            <!-- Top Section -->
            <div class="flex flex-col md:flex-row justify-between items-start md:items-center mb-8">
                <!-- Logo -->
                <div class="flex items-center mb-6 md:mb-0">
                    <img src="{{ asset('assets/Group48.png') }}" alt="SAPA" class="h-10 mr-3">
                </div>

                <!-- Links Grid -->
                <div class="grid grid-cols-2 md:grid-cols-3 gap-6 text-sm text-white">
                    <div class="space-y-1">
                        <a href="{{ url('/') }}" class="hover:underline block">Homepage</a>
                        <a href="{{ route('dashboard') }}" class="hover:underline block">Dashboard</a>
                    </div>
                    <div class="space-y-1">
                        <a href="{{ route('pengaduan.create') }}" class="hover:underline block">Layanan Pengaduan</a>
                        <a href="{{ route('tracking.index') }}" class="hover:underline block">Track Pengaduan</a>
                        <a href="{{ route('pendampingan.index') }}" class="hover:underline block">Layanan
                            Pendampingan</a>
                        <a href="{{ route('konseling.index') }}" class="hover:underline block">Layanan Konseling</a>
                    </div>
                    <div class="space-y-1">
                        <a href="#" class="hover:underline block">Edukasi</a>
                        <a href="#" class="hover:underline block">About</a>
                        <a href="{{ route('profile.edit') }}" class="hover:underline block">Profile</a>
                    </div>
                </div>
            </div>

            <!-- Divider -->
            <hr class="border-gray-600 mb-6">

            <!-- Bottom Section -->
            <div class="flex flex-col md:flex-row justify-between items-center text-sm text-gray-400">
                <p>SAPA 2025. All rights reserved.</p>
                <div class="flex space-x-4 mt-4 md:mt-0">
                    <a href="#" class="hover:text-white"><i class="fab fa-youtube"></i></a>
                    <a href="#" class="hover:text-white"><i class="fab fa-facebook-f"></i></a>
                    <a href="#" class="hover:text-white"><i class="fab fa-twitter"></i></a>
                    <a href="#" class="hover:text-white"><i class="fab fa-instagram"></i></a>
                    <a href="#" class="hover:text-white"><i class="fab fa-linkedin-in"></i></a>
                </div>
            </div>
        </div>
    </footer>
