@extends('template.main')
@section('content_template')

<section class="bg-white py-6 px-4 sm:px-6 lg:px-8">
    <!-- Breadcrumb -->
    <nav class="text-sm text-gray-600 font-semibold mb-6" aria-label="Breadcrumb">
        <ol class="flex items-center space-x-2">
            <li><a href="{{ url('/') }}" class="text-blue-600 hover:underline">Homepage</a></li>
            <li class="text-gray-600">/</li>
            <li class="text-gray-500">Dashboard Super Admin</li>
        </ol>
    </nav>

    <!-- Welcome Section -->
    <div class="mb-8">
        <h1 class="text-3xl font-bold text-gray-900 mb-2">
            Selamat datang, {{ Auth::user()->name }}!
        </h1>
        <p class="text-gray-600">
            Anda login sebagai Super Admin. Kelola sistem dan akses fitur administrasi tingkat tinggi.
        </p>
    </div>

    <!-- Card Statistik -->
    <div class="grid grid-cols-1 md:grid-cols-4 gap-6 mb-8">
        <!-- Total Pengaduan -->
        <div class="bg-white p-6 rounded-lg shadow text-center">
            <p class="text-gray-600 text-sm">Total Pengaduan</p>
            <h2 class="text-3xl font-bold text-blue-600 mt-2">{{ $totalPengaduan }}</h2>
        </div>

        <!-- Pengaduan Menunggu -->
        <div class="bg-white p-6 rounded-lg shadow text-center">
            <p class="text-gray-600 text-sm">Menunggu</p>
            <h2 class="text-3xl font-bold text-yellow-600 mt-2">{{ $pengaduanMenunggu }}</h2>
        </div>

        <!-- Pengaduan Diproses -->
        <div class="bg-white p-6 rounded-lg shadow text-center">
            <p class="text-gray-600 text-sm">Diproses</p>
            <h2 class="text-3xl font-bold text-blue-600 mt-2">{{ $pengaduanDiproses }}</h2>
        </div>

        <!-- Pengaduan Selesai -->
        <div class="bg-white p-6 rounded-lg shadow text-center">
            <p class="text-gray-600 text-sm">Selesai</p>
            <h2 class="text-3xl font-bold text-green-600 mt-2">{{ $pengaduanSelesai }}</h2>
        </div>
    </div>

    <!-- Statistik Konseling & Pendampingan -->
    <div class="grid grid-cols-1 md:grid-cols-2 gap-6 mb-8">
        <div class="bg-white p-6 rounded-lg shadow text-center">
            <p class="text-gray-600 text-sm">Total Konseling</p>
            <h2 class="text-3xl font-bold text-purple-600 mt-2">{{ $totalKonseling }}</h2>
        </div>
        <div class="bg-white p-6 rounded-lg shadow text-center">
            <p class="text-gray-600 text-sm">Total Pendampingan</p>
            <h2 class="text-3xl font-bold text-pink-600 mt-2">{{ $totalPendampingan }}</h2>
        </div>
    </div>

    <!-- Quick Actions -->
    <div class="bg-gradient-to-r from-red-500 to-pink-600 rounded-lg shadow-lg p-6 mb-8">
        <div class="flex items-center justify-between">
            <div class="text-white">
                <h3 class="text-xl font-bold mb-2">Quick Actions</h3>
                <p class="text-red-100">Kelola staff dan akses fitur administrasi</p>
            </div>
            <div class="hidden md:block">
                <svg class="w-16 h-16 text-red-200" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m5.618-4.016A11.955 11.955 0 0112 2.944a11.955 11.955 0 01-8.618 3.04A12.02 12.02 0 003 9c0 5.591 3.824 10.29 9 11.622 5.176-1.332 9-6.03 9-11.622 0-1.042-.133-2.052-.382-3.016z"></path>
                </svg>
            </div>
        </div>
        <div class="mt-4 flex flex-wrap gap-3">
            <a href="{{ route('admin.staff.index') }}" 
               class="bg-white text-red-600 px-4 py-2 rounded-lg font-semibold hover:bg-red-50 transition duration-200">
                Kelola Staff
            </a>
            <a href="{{ route('data-dashboard.index') }}" 
               class="bg-white text-red-600 px-4 py-2 rounded-lg font-semibold hover:bg-red-50 transition duration-200">
                Data Dashboard
            </a>
            <a href="{{ route('analytics.index') }}" 
               class="bg-white text-red-600 px-4 py-2 rounded-lg font-semibold hover:bg-red-50 transition duration-200">
                Analytics
            </a>
        </div>
    </div>

    <!-- Riwayat Pengaduan Terbaru -->
    <div class="bg-white rounded-lg shadow p-6">
        <h4 class="text-lg font-semibold text-gray-800 mb-4">Riwayat Pengaduan Terbaru</h4>
        <div class="overflow-x-auto">
            <table class="min-w-full divide-y divide-gray-200">
                <thead>
                    <tr>
                        <th class="px-4 py-2 text-left text-xs font-medium text-gray-500 uppercase">ID</th>
                        <th class="px-4 py-2 text-left text-xs font-medium text-gray-500 uppercase">Nama Korban</th>
                        <th class="px-4 py-2 text-left text-xs font-medium text-gray-500 uppercase">Status</th>
                        <th class="px-4 py-2 text-left text-xs font-medium text-gray-500 uppercase">Tanggal</th>
                    </tr>
                </thead>
                <tbody class="bg-white divide-y divide-gray-200">
                    @forelse($recentPengaduan as $pengaduan)
                        <tr>
                            <td class="px-4 py-2">{{ $pengaduan->id }}</td>
                            <td class="px-4 py-2">
                                @if($pengaduan->korban)
                                    {{ $pengaduan->korban->nama }}
                                @else
                                    -
                                @endif
                            </td>
                            <td class="px-4 py-2">
                                <span class="px-2 py-1 rounded text-xs font-semibold
                                    @if($pengaduan->status === 'menunggu') bg-yellow-500 text-white
                                    @elseif($pengaduan->status === 'diproses') bg-blue-500 text-white
                                    @elseif($pengaduan->status === 'selesai') bg-green-600 text-white
                                    @else bg-gray-400 text-white @endif">
                                    {{ ucfirst($pengaduan->status) }}
                                </span>
                            </td>
                            <td class="px-4 py-2">{{ $pengaduan->created_at->format('d-m-Y') }}</td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="4" class="px-4 py-2 text-center text-gray-500">Belum ada pengaduan.</td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>
</section>

@endsection 