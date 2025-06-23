<!-- Modal Background -->
<div id="logoutModal" class="fixed inset-0 z-50 hidden items-center justify-center">
    <div class="bg-white rounded-lg border border-gray-300 w-full max-w-md p-8 relative text-center">
        <!-- Logo -->
        <div class="mb-4">
            <img src="{{ asset('assets/image.png') }}" alt="Logo" class="mx-auto h-16">
        </div>

        <!-- Judul dan Pesan -->
        <h2 class="text-2xl font-bold text-gray-800 mb-2">Logout</h2>
        <p class="text-gray-600 mb-6">Apakah Anda yakin untuk keluar?</p>

        <!-- Tombol -->
        <div class="flex flex-col gap-3">
            <button onclick="closeLogoutModal()" class="w-full bg-blue-400 text-white py-2 rounded hover:bg-blue-500">
                Batalkan
            </button>

            <form id="logout-form" action="{{ route('logout') }}" method="POST" class="w-full">
                @csrf
                <button type="submit" class="w-full bg-blue-600 text-white py-2 rounded hover:bg-blue-700">
                    Logout
                </button>
            </form>
        </div>

        <!-- Link Kembali -->
        <div class="mt-4">
            <a href="{{ url('/') }}" class="text-sm text-blue-600 hover:underline">
                Kembali ke halaman Homepage
            </a>
        </div>
    </div>
</div>
