<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Dashboard') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <!-- Statistik Pengaduan Saya -->
            <div class="grid grid-cols-1 md:grid-cols-4 gap-4 mb-6">
                <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                    <div class="p-6">
                        <div class="text-gray-900 text-lg font-semibold mb-2">Total Pengaduan</div>
                        <div class="text-3xl font-bold text-blue-600">{{ $pengaduanSaya->count() }}</div>
                    </div>
                </div>
                <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                    <div class="p-6">
                        <div class="text-gray-900 text-lg font-semibold mb-2">Menunggu</div>
                        <div class="text-3xl font-bold text-yellow-600">{{ $pengaduanSaya->where('status', 'menunggu')->count() }}</div>
                    </div>
                </div>
                <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                    <div class="p-6">
                        <div class="text-gray-900 text-lg font-semibold mb-2">Diproses</div>
                        <div class="text-3xl font-bold text-orange-600">{{ $pengaduanSaya->where('status', 'diproses')->count() }}</div>
                    </div>
                </div>
                <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                    <div class="p-6">
                        <div class="text-gray-900 text-lg font-semibold mb-2">Selesai</div>
                        <div class="text-3xl font-bold text-green-600">{{ $pengaduanSaya->where('status', 'selesai')->count() }}</div>
                    </div>
                </div>
            </div>

            <!-- Pengaduan Terbaru Saya -->
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg mb-6">
                <div class="p-6">
                    <div class="flex justify-between items-center mb-4">
                        <h3 class="text-lg font-semibold">Pengaduan Terbaru Saya</h3>
                        <a href="{{ route('pengaduan.create') }}" class="bg-blue-500 hover:bg-blue-700 text-white font-bold py-2 px-4 rounded">
                            Buat Pengaduan Baru
                        </a>
                    </div>
                    <div class="overflow-x-auto">
                        <table class="min-w-full divide-y divide-gray-200">
                            <thead class="bg-gray-50">
                                <tr>
                                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">No. Pengaduan</th>
                                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Tanggal</th>
                                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Judul</th>
                                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Status</th>
                                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Aksi</th>
                                </tr>
                            </thead>
                            <tbody class="bg-white divide-y divide-gray-200">
                                @forelse($pengaduanTerbaru as $pengaduan)
                                    <tr>
                                        <td class="px-6 py-4 whitespace-nowrap">{{ $pengaduan->id }}</td>
                                        <td class="px-6 py-4 whitespace-nowrap">{{ $pengaduan->created_at->format('d/m/Y') }}</td>
                                        <td class="px-6 py-4 whitespace-nowrap">{{ Str::limit($pengaduan->judul, 50) }}</td>
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
                                        <td colspan="5" class="px-6 py-4 whitespace-nowrap text-center text-gray-500">
                                            Belum ada pengaduan yang dibuat
                                        </td>
                                    </tr>
                                @endforelse
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>

            <!-- Layanan Tersedia -->
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6">
                    <h3 class="text-lg font-semibold mb-4">Layanan Tersedia</h3>
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                        <a href="{{ route('pendampingan.index') }}" class="block p-6 bg-blue-50 rounded-lg hover:bg-blue-100 transition-colors">
                            <div class="text-blue-800 font-semibold mb-2">Pendampingan</div>
                            <p class="text-sm text-gray-600">Layanan pendampingan untuk korban kekerasan</p>
                        </a>
                        <!-- Assessment feature disabled
                        <a href="{{ route('assessment.index') }}" class="block p-6 bg-green-50 rounded-lg hover:bg-green-100 transition-colors">
                            <div class="text-green-800 font-semibold mb-2">Assessment</div>
                            <p class="text-sm text-gray-600">Layanan assessment untuk evaluasi kasus</p>
                        </a>
                        -->
                        <a href="{{ route('konseling.index') }}" class="block p-6 bg-purple-50 rounded-lg hover:bg-purple-100 transition-colors">
                            <div class="text-purple-800 font-semibold mb-2">Konseling</div>
                            <p class="text-sm text-gray-600">Layanan konseling untuk dukungan psikologis</p>
                        </a>
                    </div>
                </div>
            </div>
        </div>
    </div>
</x-app-layout> 