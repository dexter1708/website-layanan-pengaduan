<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Dashboard') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <!-- Statistik Pengaduan -->
            <div class="grid grid-cols-1 md:grid-cols-4 gap-4 mb-6">
                <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                    <div class="p-6">
                        <div class="text-gray-900 text-lg font-semibold mb-2">Total Pengaduan</div>
                        <div class="text-3xl font-bold text-blue-600">{{ $totalPengaduan }}</div>
                    </div>
                </div>
                <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                    <div class="p-6">
                        <div class="text-gray-900 text-lg font-semibold mb-2">Menunggu</div>
                        <div class="text-3xl font-bold text-yellow-600">{{ $pengaduanMenunggu }}</div>
                    </div>
                </div>
                <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                    <div class="p-6">
                        <div class="text-gray-900 text-lg font-semibold mb-2">Diproses</div>
                        <div class="text-3xl font-bold text-orange-600">{{ $pengaduanDiproses }}</div>
                    </div>
                </div>
                <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                    <div class="p-6">
                        <div class="text-gray-900 text-lg font-semibold mb-2">Selesai</div>
                        <div class="text-3xl font-bold text-green-600">{{ $pengaduanSelesai }}</div>
                    </div>
                </div>
            </div>

            <!-- Pengaduan Terbaru -->
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg mb-6">
                <div class="p-6">
                    <h3 class="text-lg font-semibold mb-4">Pengaduan Terbaru</h3>
                    <div class="overflow-x-auto">
                        <table class="min-w-full divide-y divide-gray-200">
                            <thead class="bg-gray-50">
                                <tr>
                                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">No. Pengaduan</th>
                                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Tanggal</th>
                                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Pelapor</th>
                                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Status</th>
                                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Aksi</th>
                                </tr>
                            </thead>
                            <tbody class="bg-white divide-y divide-gray-200">
                                @forelse($pengaduanTerbaru as $pengaduan)
                                    <tr>
                                        <td class="px-6 py-4 whitespace-nowrap">{{ $pengaduan->id }}</td>
                                        <td class="px-6 py-4 whitespace-nowrap">{{ $pengaduan->created_at->format('d/m/Y') }}</td>
                                        <td class="px-6 py-4 whitespace-nowrap">{{ $pengaduan->pelapor ? $pengaduan->pelapor->nama_pelapor : '-' }}</td>
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
                                            <a href="{{ route('tracking.show', $pengaduan->id) }}" class="text-blue-600 hover:text-blue-900">Detail</a>
                                        </td>
                                    </tr>
                                @empty
                                    <tr>
                                        <td colspan="5" class="px-6 py-4 whitespace-nowrap text-center text-gray-500">
                                            Tidak ada pengaduan terbaru
                                        </td>
                                    </tr>
                                @endforelse
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>

            <!-- Pengaduan Berdasarkan Bentuk Kekerasan -->
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6">
                    <h3 class="text-lg font-semibold mb-4">Pengaduan Berdasarkan Bentuk Kekerasan</h3>
                    <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-4">
                        @forelse($pengaduanByBentukKekerasan as $bentuk => $count)
                            <div class="bg-gray-50 p-4 rounded-lg">
                                <div class="text-sm text-gray-600">{{ $bentuk ?: 'Tidak Diketahui' }}</div>
                                <div class="text-2xl font-bold text-gray-900">{{ $count }}</div>
                            </div>
                        @empty
                            <div class="col-span-full text-center text-gray-500">
                                Tidak ada data bentuk kekerasan
                            </div>
                        @endforelse
                    </div>
                </div>
            </div>
        </div>
    </div>
</x-app-layout> 