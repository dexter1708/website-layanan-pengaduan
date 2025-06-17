<x-app-layout>
    <x-slot name="header">
        <div class="flex justify-between items-center">
            <h2 class="font-semibold text-xl text-gray-800 leading-tight">
                {{ __('Jadwal Pendampingan') }}
            </h2>
            <div class="flex space-x-2">
                @if(auth()->user()->role === 'staff')
                    <a href="{{ route('staff.pendampingan.create') }}" class="bg-blue-500 hover:bg-blue-700 text-white font-bold py-2 px-4 rounded">
                        {{ __('Buat Jadwal Pendampingan') }}
                    </a>
                @else
                    <a href="{{ route('user.pendampingan.request') }}" class="bg-green-500 hover:bg-green-700 text-white font-bold py-2 px-4 rounded">
                        {{ __('Ajukan Pendampingan') }}
                    </a>
                @endif
            </div>
        </div>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
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
                                    <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                        ID Pengaduan
                                    </th>
                                    <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                        Nama Korban
                                    </th>
                                    <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                        Nama Pendamping
                                    </th>
                                    <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                        Tanggal Pendampingan
                                    </th>
                                    <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                        Waktu Pendampingan
                                    </th>
                                    <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                        Tempat Pendampingan
                                    </th>
                                    <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                        Jenis Layanan
                                    </th>
                                    <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                        Status
                                    </th>
                                    <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                        Aksi
                                    </th>
                                </tr>
                            </thead>
                            <tbody class="bg-white divide-y divide-gray-200">
                                @forelse($pendampingans as $pendampingan)
                                    <tr>
                                        <td class="px-6 py-4 whitespace-nowrap">{{ $pendampingan->pengaduan->id ?? 'N/A' }}</td>
                                        <td class="px-6 py-4 whitespace-nowrap">{{ $pendampingan->korban->nama ?? 'N/A' }}</td>
                                        <td class="px-6 py-4 whitespace-nowrap">
                                            @if($pendampingan->nama_pendamping === 'Belum ditentukan')
                                                <span class="text-gray-500 italic">Belum ditentukan</span>
                                            @else
                                                {{ $pendampingan->nama_pendamping }}
                                            @endif
                                        </td>
                                        <td class="px-6 py-4 whitespace-nowrap">
                                            <div>
                                                <div class="font-medium">{{ $pendampingan->getTanggalPendampinganFormatted() }}</div>
                                            </div>
                                        </td>
                                        <td class="px-6 py-4 whitespace-nowrap">
                                            <div>
                                                <div class="font-medium">{{ $pendampingan->getWaktuPendampinganFormatted() }}</div>
                                            </div>
                                        </td>
                                        <td class="px-6 py-4 whitespace-nowrap">
                                            @if($pendampingan->tempat_pendampingan === 'Belum ditentukan')
                                                <span class="text-gray-500 italic">Belum ditentukan</span>
                                            @else
                                                {{ $pendampingan->tempat_pendampingan }}
                                            @endif
                                        </td>
                                        <td class="px-6 py-4 whitespace-nowrap">{{ $pendampingan->getJenisLayananLabel() }}</td>
                                        <td class="px-6 py-4 whitespace-nowrap">
                                            <span class="px-2 inline-flex text-xs leading-5 font-semibold rounded-full
                                                @if($pendampingan->isButuhKonfirmasiStaff()) bg-yellow-100 text-yellow-800
                                                @elseif($pendampingan->isMenungguKonfirmasiUser()) bg-blue-100 text-blue-800
                                                @elseif($pendampingan->isTerkonfirmasi()) bg-green-100 text-green-800
                                                @else bg-red-100 text-red-800 @endif">
                                                {{ $pendampingan->getStatusLabel() }}
                                            </span>
                                        </td>
                                        <td class="px-6 py-4 whitespace-nowrap text-right text-sm font-medium">
                                            <a href="{{ route('pendampingan.show', $pendampingan->id) }}" class="text-indigo-600 hover:text-indigo-900 mr-3">Lihat</a>
                                            @if(auth()->user()->role === 'staff')
                                                <a href="{{ route('staff.pendampingan.edit', $pendampingan->id) }}" class="text-blue-600 hover:text-blue-900 mr-3">Edit</a>
                                                <form action="{{ route('staff.pendampingan.destroy', $pendampingan->id) }}" method="POST" class="inline" onsubmit="return confirm('Apakah Anda yakin ingin menghapus jadwal pendampingan ini?');">
                                                    @csrf
                                                    @method('DELETE')
                                                    <button type="submit" class="text-red-600 hover:text-red-900">Hapus</button>
                                                </form>
                                            @endif
                                        </td>
                                    </tr>
                                @empty
                                    <tr>
                                        <td colspan="9" class="px-6 py-4 whitespace-nowrap text-center text-gray-500">
                                            Tidak ada jadwal pendampingan
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