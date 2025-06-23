@extends('template.main')
@section('content_template')
    <!-- Services Section -->
    <section class="py-20 bg-white">
        <div class="container mx-auto px-6">
            <!-- Welcome Section -->
            <div class="mb-8">
                <h1 class="text-3xl font-bold text-gray-900 mb-2">
                    Selamat datang, {{ Auth::user()->name }}!
                </h1>
                <p class="text-gray-600">
                    @if(Auth::user()->role === 'staff')
                        Anda login sebagai Staff. Kelola pengaduan, konseling, dan pendampingan dengan baik.
                    @else
                        Anda login sebagai Pelapor. Pantau status pengaduan dan layanan yang Anda ajukan.
                    @endif
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

            @if(Auth::user()->role === 'staff')
            <!-- Statistik Menunggu Konfirmasi Khusus Staff -->
            <div class="grid grid-cols-1 md:grid-cols-2 gap-6 mb-8">
                <div class="bg-blue-100 p-6 rounded-lg shadow text-center border border-blue-300">
                    <p class="text-blue-800 text-sm">Konseling Butuh Konfirmasi</p>
                    <h2 class="text-3xl font-bold text-blue-700 mt-2">{{ $konselingMenunggu ?? 0 }}</h2>
                </div>
                <div class="bg-pink-100 p-6 rounded-lg shadow text-center border border-pink-300">
                    <p class="text-pink-800 text-sm">Pendampingan Butuh Konfirmasi</p>
                    <h2 class="text-3xl font-bold text-pink-700 mt-2">{{ $pendampinganMenunggu ?? 0 }}</h2>
                </div>
            </div>
            @endif

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
        </div>
    </section>
@endsection 