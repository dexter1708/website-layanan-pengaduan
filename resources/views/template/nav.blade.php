<header class="bg-white shadow-sm border-b">
    <nav class="container mx-auto px-6 py-4 flex items-center justify-between flex-wrap">
        <!-- Logo -->
        <div class="flex items-center space-x-2">
            <img src="{{ asset('assets/Group48.png') }}" alt="Logo" class="h-10">
        </div>

        <!-- Toggle Mobile Menu -->
        <div class="block md:hidden">
            <button id="nav-toggle" class="text-gray-600 focus:outline-none focus:text-blue-600" aria-label="Toggle Menu">
                <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"
                    xmlns="http://www.w3.org/2000/svg">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 12h16M4 18h16" />
                </svg>
            </button>
        </div>

        <!-- Navigation Menu Wrapper -->
        <div id="nav-menu" class="w-full md:flex items-center justify-between hidden mt-4 md:mt-0 md:w-auto flex-grow">
            <!-- Menu Tengah -->
            <div
                class="flex flex-col md:flex-row items-center space-y-2 md:space-y-0 md:space-x-6 mx-auto text-gray-600">

                <a href="{{ url('/') }}" class="hover:text-blue-600">Homepage</a>
                <a href="{{ route('dashboard') }}" class="hover:text-blue-600">Dashboard</a>

                @if(Auth::check() && Auth::user()->role === 'staff')
                <div class="relative" id="dropdown-wrapper">
                        <button id="dropdown-toggle"
                            class="flex items-center hover:text-blue-600 focus:outline-none focus:text-blue-600"
                            aria-haspopup="true" aria-expanded="false">
                            Layanan
                            <svg class="ml-1 w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"
                                xmlns="http://www.w3.org/2000/svg">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7" />
                            </svg>
                        </button>
                        <div id="dropdown-menu"
                            class="absolute left-0 mt-2 w-48 hidden bg-white shadow-lg rounded-md z-50">
                            <a href="{{ route('pengaduan.index') }}"
                                class="block px-4 py-2 text-gray-800 hover:bg-gray-100">Layanan Pengaduan</a>
                            <a href="{{ route('tracking.index') }}"
                                class="block px-4 py-2 text-gray-800 hover:bg-gray-100">Track Pengaduan</a>
                            <a href="{{ route('pendampingan.index') }}"
                                class="block px-4 py-2 text-gray-800 hover:bg-gray-100">Layanan Pendampingan</a>
                            <a href="{{ route('konseling.index') }}"
                                class="block px-4 py-2 text-gray-800 hover:bg-gray-100">Layanan Konseling</a>
                        </div>
                    </div>
                    <!-- Dropdown Kelola Data -->
                    <div class="relative" id="kelola-data-dropdown">
                        <button id="kelola-data-toggle"
                            class="flex items-center hover:text-blue-600 focus:outline-none focus:text-blue-600"
                            aria-haspopup="true" aria-expanded="false">
                            Kelola Data
                            <svg class="ml-1 w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"
                                xmlns="http://www.w3.org/2000/svg">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7" />
                            </svg>
                        </button>
                        <div id="kelola-data-menu" class="absolute left-0 mt-2 w-48 hidden bg-white shadow-lg rounded-md z-50">
                            <a href="{{ route('staff.wilayah.index') }}" class="block px-4 py-2 text-gray-800 hover:bg-gray-100">Wilayah</a>
                            <a href="{{ route('staff.pekerjaan.index') }}" class="block px-4 py-2 text-gray-800 hover:bg-gray-100">Pekerjaan</a>
                            <a href="{{ route('staff.instruktur.index') }}" class="block px-4 py-2 text-gray-800 hover:bg-gray-100">Instruktur</a>
                            <a href="{{ route('staff.layanan.index') }}" class="block px-4 py-2 text-gray-800 hover:bg-gray-100">Layanan</a>
                        </div>
                    </div>
                @endif

                @if(Auth::check() && Auth::user()->role === 'super_admin')
                    <a href="{{ route('admin.staff.index') }}" class="hover:text-blue-600">Manajemen Staff</a>
                @endif

                <!-- Dropdown -->
                @if (!in_array(Auth::user()?->role, ['staff', 'super_admin']))
                    <div class="relative" id="dropdown-wrapper">
                        <button id="dropdown-toggle"
                            class="flex items-center hover:text-blue-600 focus:outline-none focus:text-blue-600"
                            aria-haspopup="true" aria-expanded="false">
                            Layanan
                            <svg class="ml-1 w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"
                                xmlns="http://www.w3.org/2000/svg">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7" />
                            </svg>
                        </button>
                        <div id="dropdown-menu"
                            class="absolute left-0 mt-2 w-48 hidden bg-white shadow-lg rounded-md z-50">
                            <a href="{{ route('pengaduan.index') }}"
                                class="block px-4 py-2 text-gray-800 hover:bg-gray-100">Layanan Pengaduan</a>
                            <a href="{{ route('tracking.index') }}"
                                class="block px-4 py-2 text-gray-800 hover:bg-gray-100">Track Pengaduan</a>
                            <a href="{{ route('pendampingan.index') }}"
                                class="block px-4 py-2 text-gray-800 hover:bg-gray-100">Layanan Pendampingan</a>
                            <a href="{{ route('konseling.index') }}"
                                class="block px-4 py-2 text-gray-800 hover:bg-gray-100">Layanan Konseling</a>
                        </div>
                    </div>
                @endif

                @guest
                    <a href="#" class="hover:text-blue-600">Edukasi</a>
                    <a href="#" class="hover:text-blue-600">About</a>
                @endguest
            </div>
            
            <div
                class="flex flex-col md:flex-row space-y-2 md:space-y-0 md:space-x-4 mt-4 md:mt-0 text-center md:text-left">

                @guest
                    <a href="{{ route('login') }}"
                        class="bg-blue-500 text-white px-4 py-2 rounded hover:bg-blue-600">Login</a>
                    <a href="{{ route('register') }}"
                        class="bg-gray-600 text-white px-6 py-2 rounded hover:bg-gray-700 transition">Register</a>
                @endguest

                @auth
                    <!-- Tombol di Navbar -->
                    <button onclick="openLogoutModal()"
                        class="bg-blue-500 text-white px-4 py-2 rounded hover:bg-blue-600">Logout</button>
                    <!-- Modal Logout -->
                    @include('components.logout-modal')

                    <!-- Profile Link -->
                    <a href="{{ route('profile.show') }}"
                        class="bg-blue-400 text-white px-6 py-2 rounded hover:bg-blue-500 transition">
                        {{ Auth::user()->name }}
                    </a>

                @endauth

            </div>

        </div>

    </nav>

    <script>
        // Toggle mobile menu
        const navToggle = document.getElementById('nav-toggle');
        const navMenu = document.getElementById('nav-menu');
        navToggle.addEventListener('click', () => {
            navMenu.classList.toggle('hidden');
        });

        // Dropdown Layanan toggle
        const layananToggle = document.getElementById('dropdown-toggle');
        const layananMenu = document.getElementById('dropdown-menu');
        if (layananToggle && layananMenu) {
            layananToggle.addEventListener('click', (e) => {
                e.stopPropagation();
                layananMenu.classList.toggle('hidden');
                layananToggle.setAttribute('aria-expanded', !layananMenu.classList.contains('hidden'));
            });
        }

        // Dropdown Kelola Data toggle
        const kelolaDataToggle = document.getElementById('kelola-data-toggle');
        const kelolaDataMenu = document.getElementById('kelola-data-menu');
        if (kelolaDataToggle && kelolaDataMenu) {
            kelolaDataToggle.addEventListener('click', (e) => {
                e.stopPropagation();
                kelolaDataMenu.classList.toggle('hidden');
                kelolaDataToggle.setAttribute('aria-expanded', !kelolaDataMenu.classList.contains('hidden'));
            });
        }

        // Hide dropdowns when click outside
        document.addEventListener('click', (e) => {
            // Layanan
            if (layananMenu && !layananMenu.classList.contains('hidden')) {
                const layananWrapper = document.getElementById('dropdown-wrapper');
                if (!layananWrapper.contains(e.target)) {
                    layananMenu.classList.add('hidden');
                    layananToggle.setAttribute('aria-expanded', 'false');
                }
            }
            // Kelola Data
            if (kelolaDataMenu && !kelolaDataMenu.classList.contains('hidden')) {
                const kelolaDataWrapper = document.getElementById('kelola-data-dropdown');
                if (!kelolaDataWrapper.contains(e.target)) {
                    kelolaDataMenu.classList.add('hidden');
                    kelolaDataToggle.setAttribute('aria-expanded', 'false');
                }
            }
        });

        function openLogoutModal() {
            document.getElementById('logoutModal').classList.remove('hidden');
            document.getElementById('logoutModal').classList.add('flex');
        }

        function closeLogoutModal() {
            document.getElementById('logoutModal').classList.remove('flex');
            document.getElementById('logoutModal').classList.add('hidden');
        }
    </script>
</header>
