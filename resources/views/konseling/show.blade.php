<x-app-layout>
    <x-slot name="header">
        <div class="flex justify-between items-center">
            <h2 class="font-semibold text-xl text-gray-800 leading-tight">
                {{ __('Detail Konseling') }}
            </h2>
            @if(auth()->user()->role !== 'staff' && $konseling->konfirmasi === 'menunggu')
            <div class="flex space-x-2">
                <form action="{{ route('konseling.update-konfirmasi', $konseling->id) }}" method="POST" class="inline">
                    @csrf
                    @method('PUT')
                    <input type="hidden" name="konfirmasi" value="setuju">
                    <x-primary-button>
                        {{ __('Setuju') }}
                    </x-primary-button>
                </form>
                <form action="{{ route('konseling.update-konfirmasi', $konseling->id) }}" method="POST" class="inline">
                    @csrf
                    @method('PUT')
                    <input type="hidden" name="konfirmasi" value="tolak">
                    <x-danger-button>
                        {{ __('Tolak') }}
                    </x-danger-button>
                </form>
            </div>
            @endif
        </div>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            @if(session('success'))
                <div class="bg-green-100 border border-green-400 text-green-700 px-4 py-3 rounded relative mb-4" role="alert">
                    <span class="block sm:inline">{{ session('success') }}</span>
                </div>
            @endif

            <!-- Informasi Konseling -->
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg mb-6">
                <div class="p-6 text-gray-900">
                    <h3 class="text-lg font-semibold mb-4">Informasi Konseling</h3>
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                        <div>
                            <p class="text-sm text-gray-600">Nomor Pengaduan</p>
                            <p class="font-medium">{{ $konseling->pengaduan->nomor_pengaduan }}</p>
                        </div>
                        <div>
                            <p class="text-sm text-gray-600">Status</p>
                            <span class="px-2 inline-flex text-xs leading-5 font-semibold rounded-full 
                                @if($konseling->konfirmasi === 'setuju') bg-green-100 text-green-800
                                @elseif($konseling->konfirmasi === 'tolak') bg-red-100 text-red-800
                                @else bg-yellow-100 text-yellow-800
                                @endif">
                                {{ ucfirst($konseling->konfirmasi) }}
                            </span>
                        </div>
                        <div>
                            <p class="text-sm text-gray-600">Nama Korban</p>
                            <p class="font-medium">{{ $konseling->nama_korban }}</p>
                        </div>
                        <div>
                            <p class="text-sm text-gray-600">Nama Konselor</p>
                            <p class="font-medium">{{ $konseling->nama_konselor }}</p>
                        </div>
                        <div>
                            <p class="text-sm text-gray-600">Jadwal Konseling</p>
                            <p class="font-medium">{{ $konseling->jadwal_konseling->format('d/m/Y H:i') }}</p>
                        </div>
                        <div>
                            <p class="text-sm text-gray-600">Tempat Konseling</p>
                            <p class="font-medium">{{ $konseling->tempat_konseling }}</p>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Informasi Pengaduan -->
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 text-gray-900">
                    <h3 class="text-lg font-semibold mb-4">Informasi Pengaduan</h3>
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                        <div>
                            <p class="text-sm text-gray-600">Tanggal Pengaduan</p>
                            <p class="font-medium">{{ $konseling->pengaduan->created_at->format('d/m/Y') }}</p>
                        </div>
                        <div>
                            <p class="text-sm text-gray-600">Status Pengaduan</p>
                            <span class="px-2 inline-flex text-xs leading-5 font-semibold rounded-full 
                                @if($konseling->pengaduan->status === 'selesai') bg-green-100 text-green-800
                                @elseif($konseling->pengaduan->status === 'ditolak') bg-red-100 text-red-800
                                @else bg-yellow-100 text-yellow-800
                                @endif">
                                {{ ucfirst($konseling->pengaduan->status) }}
                            </span>
                        </div>
                        <div class="col-span-2">
                            <p class="text-sm text-gray-600">Deskripsi Pengaduan</p>
                            <p class="font-medium">{{ $konseling->pengaduan->deskripsi }}</p>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</x-app-layout> 