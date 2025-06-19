<x-app-layout>
    <x-slot name="header">
        <div class="flex justify-between items-center">
            <h2 class="font-semibold text-xl text-gray-800 leading-tight">
                {{ __('Jadwal Konseling') }}
            </h2>
            @auth
                <!-- Debug info -->
                {{-- <div class="text-sm text-gray-600">
                    Role: {{ auth()->user()->role }}
                </div> --}}
                @if(auth()->user()->role === 'staff')
                <a href="{{ route('staff.konseling.create') }}" class="bg-blue-500 hover:bg-blue-700 text-white font-bold py-2 px-4 rounded">
                    Buat Jadwal Konseling
                </a>
                @else
                <a href="{{ route('user.konseling.request') }}" class="bg-green-500 hover:bg-green-700 text-white font-bold py-2 px-4 rounded">
                    {{ __('Ajukan Konseling') }}
                </a>
                @endif
            @endauth
        </div>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            @if(!Auth::check())
                <div class="bg-yellow-100 border border-yellow-400 text-yellow-700 px-4 py-3 rounded relative mb-4" role="alert">
                    <span class="block sm:inline">Silakan <a href="{{ route('login') }}" class="font-bold underline">login</a> untuk melihat jadwal konseling Anda.</span>
                </div>
            @endif

            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 text-gray-900">
                    @if(session('success'))
                        <div class="bg-green-100 border border-green-400 text-green-700 px-4 py-3 rounded relative mb-4" role="alert">
                            <span class="block sm:inline">{{ session('success') }}</span>
                        </div>
                    @endif

                    <div class="overflow-x-auto">
                        <table class="min-w-full divide-y divide-gray-200">
                            <thead class="bg-gray-50">
                                <tr>
                                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">ID Pengaduan</th>
                                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Nama Korban</th>
                                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Jenis Layanan</th>
                                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Konselor</th>
                                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Jadwal</th>
                                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Tempat</th>
                                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Status</th>
                                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Aksi</th>
                                </tr>
                            </thead>
                            <tbody class="bg-white divide-y divide-gray-200">
                                @forelse($konselings as $konseling)
                                    <tr>
                                        <td class="px-6 py-4 whitespace-nowrap">{{ $konseling->pengaduan_id }}</td>
                                        <td class="px-6 py-4 whitespace-nowrap">{{ $konseling->nama_korban }}</td>
                                        <td class="px-6 py-4 whitespace-nowrap">{{ $konseling->jenis_layanan ?? 'Belum ditentukan' }}</td>
                                        <td class="px-6 py-4 whitespace-nowrap">{{ $konseling->nama_konselor }}</td>
                                        <td class="px-6 py-4 whitespace-nowrap">{{ $konseling->getJadwalKonselingShort() }}</td>
                                        <td class="px-6 py-4 whitespace-nowrap">{{ $konseling->tempat_konseling }}</td>
                                        <td class="px-6 py-4 whitespace-nowrap">
                                            <span class="px-2 inline-flex text-xs leading-5 font-semibold rounded-full 
                                                @if($konseling->konfirmasi === 'setuju') bg-green-100 text-green-800
                                                @elseif($konseling->konfirmasi === 'tolak') bg-red-100 text-red-800
                                                @else bg-yellow-100 text-yellow-800
                                                @endif">
                                                {{ $konseling->getStatusLabel() }}
                                            </span>
                                        </td>
                                        <td class="px-6 py-4 whitespace-nowrap text-sm font-medium">
                                            <div class="flex space-x-2">
                                                <a href="{{ route('konseling.show', $konseling->id) }}" class="text-blue-600 hover:text-blue-900">Detail</a>

                                                @if(auth()->user()->role === 'staff')
                                                    <a href="{{ route('staff.konseling.edit', $konseling->id) }}" class="text-yellow-600 hover:text-yellow-900">Edit</a>
                                                    <form action="{{ route('staff.konseling.destroy', $konseling->id) }}" method="POST" class="inline" onsubmit="return confirm('Apakah Anda yakin ingin menghapus jadwal konseling ini?');">
                                                        @csrf
                                                        @method('DELETE')
                                                        <button type="submit" class="text-red-600 hover:text-red-900">Hapus</button>
                                                    </form>
                                                @else
                                                    @if($konseling->konfirmasi === 'menunggu' || $konseling->konfirmasi === 'menunggu_konfirmasi_user')
                                                        <form action="{{ route('konseling.update-konfirmasi', $konseling->id) }}" method="POST" class="inline">
                                                            @csrf
                                                            @method('PUT')
                                                            <input type="hidden" name="konfirmasi" value="setuju">
                                                            <button type="submit" class="text-green-600 hover:text-green-900">Setuju</button>
                                                        </form>
                                                        <form action="{{ route('konseling.update-konfirmasi', $konseling->id) }}" method="POST" class="inline">
                                                            @csrf
                                                            @method('PUT')
                                                            <input type="hidden" name="konfirmasi" value="tolak">
                                                            <button type="submit" class="text-red-600 hover:text-red-900">Tolak</button>
                                                        </form>
                                                    @endif
                                                @endif
                                            </div>
                                        </td>
                                    </tr>
                                @empty
                                    <tr>
                                        <td colspan="8" class="px-6 py-4 whitespace-nowrap text-center text-gray-500">
                                            Tidak ada jadwal konseling
                                        </td>
                                    </tr>
                                @endforelse
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>
</x-app-layout> 