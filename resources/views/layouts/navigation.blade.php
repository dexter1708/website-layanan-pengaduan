<nav x-data="{ open: false }" class="bg-white border-b border-gray-100">
    <!-- Primary Navigation Menu -->
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <div class="flex justify-between h-16">
            <div class="flex">
                <!-- Logo -->
                <div class="shrink-0 flex items-center">
                    <a href="{{ route('dashboard') }}">
                        <x-application-logo class="block h-9 w-auto fill-current text-gray-800" />
                    </a>
                </div>

                <!-- Navigation Links -->
                <div class="hidden space-x-8 sm:-my-px sm:ms-10 sm:flex">
                    <x-nav-link :href="route('dashboard')" :active="request()->routeIs('dashboard')">
                        {{ __('Dashboard') }}
                    </x-nav-link>

                    @if(Auth::user()->role === 'super_admin')
                        <x-nav-link :href="route('admin.staff.index')" :active="request()->routeIs('admin.staff.*')">
                            {{ __('Manajemen Staff') }}
                        </x-nav-link>
                    @endif

                    @if(Auth::user()->role === 'pelapor')
                        <x-nav-link :href="route('pendampingan.index')" :active="request()->routeIs('pendampingan.*')">
                            {{ __('Pendampingan') }}
                        </x-nav-link>

                        <x-nav-link :href="route('konseling.index')" :active="request()->routeIs('konseling.*')">
                            {{ __('Konseling') }}
                        </x-nav-link>
                    @endif

                    @if(Auth::user()->role === 'staff')
                        <x-nav-link :href="route('staff.instruktur.index')" :active="request()->routeIs('staff.instruktur.*')">
                            {{ __('Kelola Instruktur') }}
                        </x-nav-link>
                        <x-nav-link :href="route('staff.layanan.index')" :active="request()->routeIs('staff.layanan.*')">
                            {{ __('Kelola Layanan') }}
                        </x-nav-link>
                    @endif
                </div>
            </div>

            <!-- Settings Button (No Dropdown) -->
            <div class="hidden sm:flex sm:items-center sm:ms-6">
                <a href="{{ route('profile.show') }}" class="inline-flex items-center px-3 py-2 border border-transparent text-sm leading-4 font-medium rounded-md text-gray-500 bg-white hover:text-gray-700 focus:outline-none transition ease-in-out duration-150">
                    {{ Auth::user()->name }}
                </a>
            </div>

            <!-- Hamburger -->
            <div class="-me-2 flex items-center sm:hidden">
                <button @click="open = ! open" class="inline-flex items-center justify-center p-2 rounded-md text-gray-400 hover:text-gray-500 hover:bg-gray-100 focus:outline-none focus:bg-gray-100 focus:text-gray-500 transition duration-150 ease-in-out">
                    <svg class="h-6 w-6" stroke="currentColor" fill="none" viewBox="0 0 24 24">
                        <path :class="{'hidden': open, 'inline-flex': ! open }" class="inline-flex" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 12h16M4 18h16" />
                        <path :class="{'hidden': ! open, 'inline-flex': open }" class="hidden" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12" />
                    </svg>
                </button>
            </div>
        </div>
    </div>

    <!-- Responsive Navigation Menu -->
    <div :class="{'block': open, 'hidden': ! open}" class="hidden sm:hidden">
        <div class="pt-2 pb-3 space-y-1">
            <x-responsive-nav-link :href="route('dashboard')" :active="request()->routeIs('dashboard')">
                {{ __('Dashboard') }}
            </x-responsive-nav-link>

            @if(Auth::user()->role === 'super_admin')
                <x-responsive-nav-link :href="route('admin.staff.index')" :active="request()->routeIs('admin.staff.*')">
                    {{ __('Manajemen Staff') }}
                </x-responsive-nav-link>
            @endif

            @if(Auth::user()->role === 'pelapor')
                <x-responsive-nav-link :href="route('pendampingan.index')" :active="request()->routeIs('pendampingan.*')">
                    {{ __('Pendampingan') }}
                </x-responsive-nav-link>

                <x-responsive-nav-link :href="route('konseling.index')" :active="request()->routeIs('konseling.*')">
                    {{ __('Konseling') }}
                </x-responsive-nav-link>
            @endif

            @if(Auth::user()->role === 'staff')
                <x-responsive-nav-link :href="route('staff.instruktur.index')" :active="request()->routeIs('staff.instruktur.*')">
                    {{ __('Kelola Instruktur') }}
                </x-responsive-nav-link>
                <x-responsive-nav-link :href="route('staff.layanan.index')" :active="request()->routeIs('staff.layanan.*')">
                    {{ __('Kelola Layanan') }}
                </x-responsive-nav-link>
            @endif
        </div>

        <!-- Responsive Settings Options -->
        <div class="pt-4 pb-1 border-t border-gray-200">
            <div class="px-4">
                <div class="font-medium text-base text-gray-800">{{ Auth::user()->name }}</div>
                <div class="font-medium text-sm text-gray-500">{{ Auth::user()->email }}</div>
            </div>

            <div class="mt-3 space-y-1">
                <x-responsive-nav-link :href="route('profile.show')">
                    {{ __('Profile') }}
                </x-responsive-nav-link>

                <!-- Authentication -->
                <form method="POST" action="{{ route('logout') }}">
                    @csrf

                    <x-responsive-nav-link :href="route('logout')"
                            onclick="event.preventDefault();
                                        this.closest('form').submit();">
                        {{ __('Log Out') }}
                    </x-responsive-nav-link>
                </form>
            </div>
        </div>
    </div>
</nav>
