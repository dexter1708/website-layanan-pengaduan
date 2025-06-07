<x-app-layout>
    <x-slot name="header">
        <div class="flex justify-between items-center">
            <h2 class="font-semibold text-xl text-gray-800 leading-tight">
                {{ __('Detail Pelapor') }}
            </h2>
            <div class="flex space-x-2">
                <a href="{{ route('users.edit', $user->id) }}" class="bg-indigo-500 hover:bg-indigo-700 text-white font-bold py-2 px-4 rounded">
                    Edit
                </a>
            </div>
        </div>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <!-- Informasi Pelapor -->
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg mb-6">
                <div class="p-6 text-gray-900">
                    <h3 class="text-lg font-semibold mb-4">Informasi Pelapor</h3>
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                        <div>
                            <p class="text-sm text-gray-600">Nama</p>
                            <p class="font-medium">{{ $user->name }}</p>
                        </div>
                        <div>
                            <p class="text-sm text-gray-600">Email</p>
                            <p class="font-medium">{{ $user->email }}</p>
                        </div>
                        <div>
                            <p class="text-sm text-gray-600">NIK</p>
                            <p class="font-medium">{{ $user->nik }}</p>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Alamat -->
            @if($user->alamat)
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg mb-6">
                <div class="p-6 text-gray-900">
                    <h3 class="text-lg font-semibold mb-4">Alamat</h3>
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                        <div>
                            <p class="text-sm text-gray-600">Provinsi</p>
                            <p class="font-medium">{{ $user->alamat->provinsi }}</p>
                        </div>
                        <div>
                            <p class="text-sm text-gray-600">Kota/Kabupaten</p>
                            <p class="font-medium">{{ $user->alamat->kota }}</p>
                        </div>
                        <div>
                            <p class="text-sm text-gray-600">Kecamatan</p>
                            <p class="font-medium">{{ $user->alamat->kecamatan }}</p>
                        </div>
                        <div>
                            <p class="text-sm text-gray-600">Desa/Kelurahan</p>
                            <p class="font-medium">{{ $user->alamat->desa }}</p>
                        </div>
                        <div class="col-span-2">
                            <p class="text-sm text-gray-600">Alamat Lengkap</p>
                            <p class="font-medium">{{ $user->alamat->detail_alamat }}</p>
                        </div>
                    </div>
                </div>
            </div>
            @endif

            <!-- Riwayat Pengaduan -->
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 text-gray-900">
                    <h3 class="text-lg font-semibold mb-4">Riwayat Pengaduan</h3>
                    <div class="overflow-x-auto">
                        <table class="min-w-full divide-y divide-gray-200">
                            <thead class="bg-gray-50">
                                <tr>
                                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">No. Pengaduan</th>
                                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Tanggal</th>
                                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Status</th>
                                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Aksi</th>
                                </tr>
                            </thead>
                            <tbody class="bg-white divide-y divide-gray-200">
                                @forelse($user->pengaduans as $pengaduan)
                                    <tr>
                                        <td class="px-6 py-4 whitespace-nowrap">{{ $pengaduan->nomor_pengaduan }}</td>
                                        <td class="px-6 py-4 whitespace-nowrap">{{ $pengaduan->created_at->format('d/m/Y') }}</td>
                                        <td class="px-6 py-4 whitespace-nowrap">
                                            <span class="px-2 inline-flex text-xs leading-5 font-semibold rounded-full 
                                                @if($pengaduan->status === 'selesai') bg-green-100 text-green-800
                                                @elseif($pengaduan->status === 'ditolak') bg-red-100 text-red-800
                                                @else bg-yellow-100 text-yellow-800
                                                @endif">
                                                {{ ucfirst($pengaduan->status) }}
                                            </span>
                                        </td>
                                        <td class="px-6 py-4 whitespace-nowrap text-sm font-medium">
                                            <a href="{{ route('pengaduan.show', $pengaduan->id) }}" class="text-blue-600 hover:text-blue-900">Detail</a>
                                        </td>
                                    </tr>
                                @empty
                                    <tr>
                                        <td colspan="4" class="px-6 py-4 whitespace-nowrap text-center text-gray-500">
                                            Tidak ada riwayat pengaduan
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