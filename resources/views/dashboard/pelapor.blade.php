@extends('template.main')
@section('content_template')

<section class="bg-white py-6 px-4 sm:px-6 lg:px-8">
    <!-- Breadcrumb -->
    <nav class="text-sm text-gray-600 font-semibold mb-6" aria-label="Breadcrumb">
        <ol class="flex items-center space-x-2">
            <li><a href="{{ url('/') }}" class="text-blue-600 hover:underline">Homepage</a></li>
            <li class="text-gray-600">/</li>
            <li class="text-gray-500">Dashboard Pelapor</li>
        </ol>
    </nav>

    <!-- Welcome Message -->
    <div class="mb-6">
        <h1 class="text-2xl font-bold text-gray-800">Selamat Datang, {{ Auth::user()->name }}!</h1>
        <p class="text-gray-600">Dashboard untuk mengelola pengaduan dan layanan Anda</p>
    </div>

    <!-- Statistik Pengaduan -->
    <div class="grid grid-cols-1 md:grid-cols-4 gap-6 mb-8">
        <div class="bg-gradient-to-r from-blue-500 to-blue-600 rounded-lg p-6 text-white">
            <div class="flex items-center">
                <div class="flex-1">
                    <h3 class="text-lg font-semibold">Total Pengaduan</h3>
                    <p class="text-3xl font-bold">{{ $pengaduanSaya->count() }}</p>
                </div>
                <div class="text-4xl opacity-50">
                    📋
                </div>
            </div>
        </div>

        <div class="bg-gradient-to-r from-yellow-500 to-yellow-600 rounded-lg p-6 text-white">
            <div class="flex items-center">
                <div class="flex-1">
                    <h3 class="text-lg font-semibold">Menunggu</h3>
                    <p class="text-3xl font-bold">{{ $pengaduanSaya->where('status', 'menunggu')->count() }}</p>
                </div>
                <div class="text-4xl opacity-50">
                    ⏳
                </div>
            </div>
        </div>

        <div class="bg-gradient-to-r from-orange-500 to-orange-600 rounded-lg p-6 text-white">
            <div class="flex items-center">
                <div class="flex-1">
                    <h3 class="text-lg font-semibold">Diproses</h3>
                    <p class="text-3xl font-bold">{{ $pengaduanSaya->where('status', 'diproses')->count() }}</p>
                </div>
                <div class="text-4xl opacity-50">
                    🔄
                </div>
            </div>
        </div>

        <div class="bg-gradient-to-r from-green-500 to-green-600 rounded-lg p-6 text-white">
            <div class="flex items-center">
                <div class="flex-1">
                    <h3 class="text-lg font-semibold">Selesai</h3>
                    <p class="text-3xl font-bold">{{ $pengaduanSaya->where('status', 'selesai')->count() }}</p>
                </div>
                <div class="text-4xl opacity-50">
                    ✅
                </div>
            </div>
        </div>
    </div>

    <!-- Pengaduan Terbaru -->
    <div class="bg-white rounded-lg shadow-md mb-8">
        <div class="p-6 border-b border-gray-200">
            <div class="flex justify-between items-center">
                <h2 class="text-xl font-semibold text-gray-800">Pengaduan Terbaru</h2>
                <a href="{{ route('pengaduan.create') }}" class="bg-blue-500 hover:bg-blue-600 text-white px-4 py-2 rounded-lg transition">
                    + Buat Pengaduan Baru
                </a>
            </div>
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
                        <tr class="hover:bg-gray-50">
                            <td class="px-6 py-4 whitespace-nowrap text-sm font-medium text-gray-900">
                                #{{ $pengaduan->id }}
                            </td>
                            <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">
                                {{ $pengaduan->created_at->format('d/m/Y H:i') }}
                            </td>
                            <td class="px-6 py-4 text-sm text-gray-900">
                                {{ Str::limit($pengaduan->judul ?? 'Pengaduan #' . $pengaduan->id, 50) }}
                            </td>
                            <td class="px-6 py-4 whitespace-nowrap">
                                @php
                                    $statusColors = [
                                        'menunggu' => 'bg-yellow-100 text-yellow-800',
                                        'diproses' => 'bg-blue-100 text-blue-800',
                                        'selesai' => 'bg-green-100 text-green-800',
                                        'ditolak' => 'bg-red-100 text-red-800'
                                    ];
                                    $color = $statusColors[$pengaduan->status] ?? 'bg-gray-100 text-gray-800';
                                @endphp
                                <span class="px-2 py-1 inline-flex text-xs leading-5 font-semibold rounded-full {{ $color }}">
                                    {{ ucfirst($pengaduan->status) }}
                                </span>
                            </td>
                            <td class="px-6 py-4 whitespace-nowrap text-sm font-medium">
                                <a href="{{ route('pengaduan.show', $pengaduan->id) }}" 
                                   class="text-blue-600 hover:text-blue-900 font-medium">
                                    Detail
                                </a>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="5" class="px-6 py-8 text-center text-gray-500">
                                <div class="flex flex-col items-center">
                                    <div class="text-4xl mb-2">📝</div>
                                    <p class="text-lg font-medium">Belum ada pengaduan</p>
                                    <p class="text-sm">Mulai dengan membuat pengaduan baru</p>
                                </div>
                            </td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>

    <!-- Layanan Tersedia -->
    <div class="bg-white rounded-lg shadow-md">
        <div class="p-6 border-b border-gray-200">
            <h2 class="text-xl font-semibold text-gray-800">Layanan Tersedia</h2>
        </div>
        <div class="p-6">
            <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                <a href="{{ route('pendampingan.index') }}" 
                   class="block p-6 bg-gradient-to-r from-blue-50 to-blue-100 rounded-lg hover:from-blue-100 hover:to-blue-200 transition-all duration-300 border border-blue-200">
                    <div class="flex items-center mb-4">
                        <div class="text-3xl mr-4">🤝</div>
                        <div>
                            <h3 class="text-lg font-semibold text-blue-800">Pendampingan</h3>
                            <p class="text-sm text-blue-600">Layanan pendampingan untuk korban kekerasan</p>
                        </div>
                    </div>
                    <div class="text-blue-600 text-sm font-medium">
                        Ajukan Pendampingan →
                    </div>
                </a>

                <a href="{{ route('konseling.index') }}" 
                   class="block p-6 bg-gradient-to-r from-purple-50 to-purple-100 rounded-lg hover:from-purple-100 hover:to-purple-200 transition-all duration-300 border border-purple-200">
                    <div class="flex items-center mb-4">
                        <div class="text-3xl mr-4">💬</div>
                        <div>
                            <h3 class="text-lg font-semibold text-purple-800">Konseling</h3>
                            <p class="text-sm text-purple-600">Layanan konseling untuk dukungan psikologis</p>
                        </div>
                    </div>
                    <div class="text-purple-600 text-sm font-medium">
                        Ajukan Konseling →
                    </div>
                </a>
            </div>
        </div>
    </div>
</section>

@endsection 