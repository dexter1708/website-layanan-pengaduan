<x-app-layout>
    <x-slot name="header">
        <div class="flex justify-between items-center">
            <h2 class="font-semibold text-xl text-gray-800 leading-tight">
                {{ __('Detail Pendampingan') }}
            </h2>
            @if(auth()->user()->role !== 'staff' && $pendampingan->konfirmasi === 'menunggu')
            <div class="flex space-x-2">
                <form action="{{ route('pendampingan.update-konfirmasi', $pendampingan->id) }}" method="POST" class="inline">
                    @csrf
                    @method('PUT')
                    <input type="hidden" name="konfirmasi" value="setuju">
                    <x-primary-button>
                        {{ __('Setuju') }}
                    </x-primary-button>
                </form>
                <form action="{{ route('pendampingan.update-konfirmasi', $pendampingan->id) }}" method="POST" class="inline">
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

            <!-- Informasi Pendampingan -->
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg mb-6">
                <div class="p-6 text-gray-900">
                    <h3 class="text-lg font-semibold mb-4">Informasi Pendampingan</h3>
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                        <div>
                            <p class="text-sm text-gray-600">ID Pengaduan</p>
                            <p class="font-medium">{{ $pendampingan->pengaduan->id }}</p>
                        </div>
                        <div>
                            <p class="text-sm text-gray-600">Status</p>
                            <span class="px-2 inline-flex text-xs leading-5 font-semibold rounded-full 
                                @if($pendampingan->konfirmasi === 'setuju') bg-green-100 text-green-800
                                @elseif($pendampingan->konfirmasi === 'tolak') bg-red-100 text-red-800
                                @else bg-yellow-100 text-yellow-800
                                @endif">
                                {{ ucfirst($pendampingan->konfirmasi) }}
                            </span>
                        </div>
                        <div>
                            <p class="text-sm text-gray-600">Nama Korban</p>
                            <p class="font-medium">{{ $pendampingan->nama_korban }}</p>
                        </div>
                        <div>
                            <p class="text-sm text-gray-600">Nama Pendamping</p>
                            <p class="font-medium">{{ $pendampingan->nama_pendamping }}</p>
                        </div>
                        <div>
                            <p class="text-sm text-gray-600">Jadwal Pendampingan</p>
                            <p class="font-medium">{{ $pendampingan->tanggal_pendampingan->format('d/m/Y H:i') }}</p>
                        </div>
                        <div>
                            <p class="text-sm text-gray-600">Tempat Pendampingan</p>
                            <p class="font-medium">{{ $pendampingan->tempat_pendampingan }}</p>
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
                            <p class="font-medium">{{ $pendampingan->pengaduan->created_at->format('d/m/Y') }}</p>
                        </div>
                        <div>
                            <p class="text-sm text-gray-600">Status Pengaduan</p>
                            <span class="px-2 inline-flex text-xs leading-5 font-semibold rounded-full 
                                @if($pendampingan->pengaduan->status === 'selesai') bg-green-100 text-green-800
                                @elseif($pendampingan->pengaduan->status === 'ditolak') bg-red-100 text-red-800
                                @else bg-yellow-100 text-yellow-800
                                @endif">
                                {{ ucfirst($pendampingan->pengaduan->status) }}
                            </span>
                        </div>
                        <div class="col-span-2">
                            <p class="text-sm text-gray-600">Deskripsi Pengaduan</p>
                            <p class="font-medium">{{ $pendampingan->pengaduan->deskripsi }}</p>
                        </div>
                    </div>
                </div>
            </div>

            <div class="flex items-center justify-end mt-4">
                <x-secondary-button onclick="window.history.back()" class="mr-3">
                    {{ __('Kembali') }}
                </x-secondary-button>
                @if(auth()->user()->role === 'staff')
                    <a href="{{ route('staff.pendampingan.edit', $pendampingan->id) }}" class="inline-flex items-center px-4 py-2 bg-indigo-600 border border-transparent rounded-md font-semibold text-xs text-white uppercase tracking-widest hover:bg-indigo-700 focus:bg-indigo-700 active:bg-indigo-900 focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:ring-offset-2 transition ease-in-out duration-150 mr-3">
                        {{ __('Edit') }}
                    </a>
                    <form action="{{ route('staff.pendampingan.destroy', $pendampingan->id) }}" method="POST" class="inline" onsubmit="return confirm('Apakah Anda yakin ingin menghapus jadwal pendampingan ini?');">
                        @csrf
                        @method('DELETE')
                        <x-danger-button>
                            {{ __('Hapus') }}
                        </x-danger-button>
                    </form>
                @elseif($pendampingan->konfirmasi === 'menunggu')
                    <form action="{{ route('pendampingan.update-konfirmasi', $pendampingan->id) }}" method="POST" class="inline ml-3">
                        @csrf
                        @method('PUT')
                        <input type="hidden" name="konfirmasi" value="setuju">
                        <x-primary-button class="bg-green-600 hover:bg-green-700">
                            {{ __('Setuju') }}
                        </x-primary-button>
                    </form>
                    <form action="{{ route('pendampingan.update-konfirmasi', $pendampingan->id) }}" method="POST" class="inline ml-3">
                        @csrf
                        @method('PUT')
                        <input type="hidden" name="konfirmasi" value="tolak">
                        <x-danger-button>
                            {{ __('Tolak') }}
                        </x-danger-button>
                    </form>
                @endif
            </div>
        </div>
    </div>
</x-app-layout> 