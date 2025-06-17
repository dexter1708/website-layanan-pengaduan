<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Data Dashboard') }}
        </h2>
    </x-slot>

    @push('styles')
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
    @endpush

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <!-- Filter Section -->
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg mb-6">
                <div class="p-6">
                    <form method="GET" action="{{ route('data-dashboard.index') }}" class="space-y-4">
                        <div class="grid grid-cols-1 md:grid-cols-3 gap-4">
                            <div>
                                <label class="block text-sm font-medium text-gray-700">Jumlah Korban</label>
                                <select name="jumlah_korban" class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500">
                                    <option value="">Semua</option>
                                    @foreach($jumlahKorbanOptions as $jumlah)
                                        <option value="{{ $jumlah }}" {{ request('jumlah_korban') == $jumlah ? 'selected' : '' }}>
                                            {{ $jumlah }} Korban
                                        </option>
                                    @endforeach
                                </select>
                            </div>

                            <div>
                                <label class="block text-sm font-medium text-gray-700">Bentuk Kekerasan</label>
                                <select name="bentuk_kekerasan" class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500">
                                    <option value="">Semua</option>
                                    @foreach($bentukKekerasanOptions as $bentuk)
                                        <option value="{{ $bentuk }}" {{ request('bentuk_kekerasan') == $bentuk ? 'selected' : '' }}>
                                            {{ $bentuk }}
                                        </option>
                                    @endforeach
                                </select>
                            </div>

                            <div>
                                <label class="block text-sm font-medium text-gray-700">Status</label>
                                <select name="status" class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500">
                                    <option value="">Semua</option>
                                    @foreach($statusOptions as $status)
                                        <option value="{{ $status }}" {{ request('status') == $status ? 'selected' : '' }}>
                                            {{ ucfirst($status) }}
                                        </option>
                                    @endforeach
                                </select>
                            </div>
                        </div>

                        <div class="flex justify-end space-x-2">
                            <a href="{{ route('data-dashboard.index') }}" class="inline-flex items-center px-4 py-2 bg-gray-300 border border-transparent rounded-md font-semibold text-xs text-gray-700 uppercase tracking-widest hover:bg-gray-400 focus:bg-gray-400 active:bg-gray-500 focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:ring-offset-2 transition ease-in-out duration-150">
                                Reset
                            </a>
                            <button type="submit" class="inline-flex items-center px-4 py-2 bg-indigo-600 border border-transparent rounded-md font-semibold text-xs text-white uppercase tracking-widest hover:bg-indigo-700 focus:bg-indigo-700 active:bg-indigo-900 focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:ring-offset-2 transition ease-in-out duration-150">
                                Terapkan Filter
                            </button>
                        </div>
                    </form>
                </div>
            </div>

            <!-- Statistik Dasar -->
            <div class="grid grid-cols-1 md:grid-cols-4 gap-6 mb-6">
                <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                    <div class="p-6">
                        <div class="text-sm font-medium text-gray-500">Total Pengaduan</div>
                        <div class="mt-2 text-3xl font-semibold text-gray-900">{{ $totalPengaduan }}</div>
                    </div>
                </div>
                <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                    <div class="p-6">
                        <div class="text-sm font-medium text-gray-500">Menunggu</div>
                        <div class="mt-2 text-3xl font-semibold text-yellow-600">{{ $pengaduanMenunggu }}</div>
                    </div>
                </div>
                <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                    <div class="p-6">
                        <div class="text-sm font-medium text-gray-500">Diproses</div>
                        <div class="mt-2 text-3xl font-semibold text-orange-600">{{ $pengaduanDiproses }}</div>
                    </div>
                </div>
                <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                    <div class="p-6">
                        <div class="text-sm font-medium text-gray-500">Selesai</div>
                        <div class="mt-2 text-3xl font-semibold text-green-600">{{ $pengaduanSelesai }}</div>
                    </div>
                </div>
            </div>

            <!-- Grafik dan Statistik -->
            <div class="grid grid-cols-1 md:grid-cols-2 gap-6 mb-6">
                <!-- Grafik Status Pengaduan -->
                <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                    <div class="p-6">
                        <h3 class="text-lg font-semibold mb-4">Status Pengaduan</h3>
                        <canvas id="statusChart" height="300"></canvas>
                    </div>
                </div>

                <!-- Grafik Bentuk Kekerasan -->
                <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                    <div class="p-6">
                        <h3 class="text-lg font-semibold mb-4">Bentuk Kekerasan</h3>
                        <canvas id="bentukKekerasanChart" height="300"></canvas>
                    </div>
                </div>

                <!-- Statistik Korban -->
                <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                    <div class="p-6">
                        <h3 class="text-lg font-semibold mb-4">Statistik Korban</h3>
                        <div class="space-y-6">
                            @foreach($statistikKorban as $jenisKelamin => $data)
                            <div class="bg-gray-50 p-4 rounded-lg">
                                <h4 class="font-medium text-gray-700 mb-3">{{ $jenisKelamin }}</h4>
                                
                                <!-- Total -->
                                <div class="mb-4">
                                    <div class="text-sm text-gray-600">Total</div>
                                    <div class="text-xl font-semibold">{{ $data['total'] }}</div>
                                </div>

                                <!-- Usia -->
                                <div class="mb-4">
                                    <div class="text-sm text-gray-600 mb-2">Kategori Usia</div>
                                    <div class="grid grid-cols-2 gap-4">
                                        <div>
                                            <div class="text-xs text-gray-500">Anak (&lt; 18)</div>
                                            <div class="font-medium">{{ $data['usia']['anak'] }}</div>
                                        </div>
                                        <div>
                                            <div class="text-xs text-gray-500">Dewasa (&ge; 18)</div>
                                            <div class="font-medium">{{ $data['usia']['dewasa'] }}</div>
                                        </div>
                                    </div>
                                </div>

                                <!-- Disabilitas -->
                                <div class="mb-4">
                                    <div class="text-sm text-gray-600">Disabilitas</div>
                                    <div class="font-medium">{{ $data['disabilitas'] }}</div>
                                </div>

                                <!-- Pendidikan -->
                                <div class="mb-4">
                                    <div class="text-sm text-gray-600 mb-2">Pendidikan</div>
                                    <div class="space-y-1">
                                        @foreach($data['pendidikan'] as $pendidikan => $total)
                                        <div class="flex justify-between text-sm">
                                            <span class="text-gray-600">{{ $pendidikan ?: 'Tidak Diketahui' }}</span>
                                            <span class="font-medium">{{ $total }}</span>
                                        </div>
                                        @endforeach
                                    </div>
                                </div>

                                <!-- Status Perkawinan -->
                                <div class="mb-4">
                                    <div class="text-sm text-gray-600 mb-2">Status Perkawinan</div>
                                    <div class="space-y-1">
                                        @foreach($data['status_perkawinan'] as $status => $total)
                                        <div class="flex justify-between text-sm">
                                            <span class="text-gray-600">{{ $status ?: 'Tidak Diketahui' }}</span>
                                            <span class="font-medium">{{ $total }}</span>
                                        </div>
                                        @endforeach
                                    </div>
                                </div>

                                <!-- Pekerjaan -->
                                <div>
                                    <div class="text-sm text-gray-600 mb-2">Pekerjaan</div>
                                    <div class="space-y-1">
                                        @foreach($data['pekerjaan'] as $pekerjaan => $total)
                                        <div class="flex justify-between text-sm">
                                            <span class="text-gray-600">{{ $pekerjaan ?: 'Tidak Diketahui' }}</span>
                                            <span class="font-medium">{{ $total }}</span>
                                        </div>
                                        @endforeach
                                    </div>
                                </div>
                            </div>
                            @endforeach
                        </div>
                    </div>
                </div>

                <!-- Statistik Pelaku -->
                <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                    <div class="p-6">
                        <h3 class="text-lg font-semibold mb-4">Statistik Pelaku</h3>
                        <div class="space-y-6">
                            @foreach($statistikPelaku as $jenisKelamin => $data)
                            <div class="bg-gray-50 p-4 rounded-lg">
                                <h4 class="font-medium text-gray-700 mb-3">{{ $jenisKelamin }}</h4>
                                
                                <!-- Total -->
                                <div class="mb-4">
                                    <div class="text-sm text-gray-600">Total</div>
                                    <div class="text-xl font-semibold">{{ $data['total'] }}</div>
                                </div>

                                <!-- Usia -->
                                <div class="mb-4">
                                    <div class="text-sm text-gray-600 mb-2">Kategori Usia</div>
                                    <div class="grid grid-cols-2 gap-4">
                                        <div>
                                            <div class="text-xs text-gray-500">Anak (&lt; 18)</div>
                                            <div class="font-medium">{{ $data['usia']['anak'] }}</div>
                                        </div>
                                        <div>
                                            <div class="text-xs text-gray-500">Dewasa (&ge; 18)</div>
                                            <div class="font-medium">{{ $data['usia']['dewasa'] }}</div>
                                        </div>
                                    </div>
                                </div>

                                <!-- Hubungan -->
                                <div class="mb-4">
                                    <div class="text-sm text-gray-600 mb-2">Hubungan dengan Korban</div>
                                    <div class="space-y-1">
                                        @foreach($data['hubungan'] as $hubungan => $total)
                                        <div class="flex justify-between text-sm">
                                            <span class="text-gray-600">{{ $hubungan ?: 'Tidak Diketahui' }}</span>
                                            <span class="font-medium">{{ $total }}</span>
                                        </div>
                                        @endforeach
                                    </div>
                                </div>

                                <!-- Kewarganegaraan -->
                                <div class="mb-4">
                                    <div class="text-sm text-gray-600 mb-2">Kewarganegaraan</div>
                                    <div class="space-y-1">
                                        @foreach($data['kewarganegaraan'] as $kewarganegaraan => $total)
                                        <div class="flex justify-between text-sm">
                                            <span class="text-gray-600">{{ $kewarganegaraan ?: 'Tidak Diketahui' }}</span>
                                            <span class="font-medium">{{ $total }}</span>
                                        </div>
                                        @endforeach
                                    </div>
                                </div>

                                <!-- Pendidikan -->
                                <div class="mb-4">
                                    <div class="text-sm text-gray-600 mb-2">Pendidikan</div>
                                    <div class="space-y-1">
                                        @foreach($data['pendidikan'] as $pendidikan => $total)
                                        <div class="flex justify-between text-sm">
                                            <span class="text-gray-600">{{ $pendidikan ?: 'Tidak Diketahui' }}</span>
                                            <span class="font-medium">{{ $total }}</span>
                                        </div>
                                        @endforeach
                                    </div>
                                </div>

                                <!-- Pekerjaan -->
                                <div>
                                    <div class="text-sm text-gray-600 mb-2">Pekerjaan</div>
                                    <div class="space-y-1">
                                        @foreach($data['pekerjaan'] as $pekerjaan => $total)
                                        <div class="flex justify-between text-sm">
                                            <span class="text-gray-600">{{ $pekerjaan ?: 'Tidak Diketahui' }}</span>
                                            <span class="font-medium">{{ $total }}</span>
                                        </div>
                                        @endforeach
                                    </div>
                                </div>
                            </div>
                            @endforeach
                        </div>
                    </div>
                </div>
            </div>

            <!-- Pengaduan Terbaru -->
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6">
                    <h3 class="text-lg font-semibold mb-4">Pengaduan Terbaru</h3>
                    <div class="overflow-x-auto">
                        <table class="min-w-full divide-y divide-gray-200">
                            <thead class="bg-gray-50">
                                <tr>
                                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">No. Pengaduan</th>
                                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Tanggal</th>
                                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Pelapor</th>
                                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Jumlah Korban</th>
                                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Bentuk Kekerasan</th>
                                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Status</th>
                                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Aksi</th>
                                </tr>
                            </thead>
                            <tbody class="bg-white divide-y divide-gray-200">
                                @forelse($pengaduanTerbaru as $pengaduan)
                                <tr>
                                    <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900">{{ $pengaduan->id }}</td>
                                    <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900">{{ $pengaduan->created_at->format('d/m/Y') }}</td>
                                    <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900">
                                        {{ $pengaduan->pelapor->nama_pelapor ?? '-' }}
                                    </td>
                                    <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900">
                                        {{ $pengaduan->korban->count() }}
                                    </td>
                                    <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900">
                                        {{ $pengaduan->bentuk_kekerasan ?: 'Tidak Diketahui' }}
                                    </td>
                                    <td class="px-6 py-4 whitespace-nowrap">
                                        <span class="px-2 inline-flex text-xs leading-5 font-semibold rounded-full 
                                            @if($pengaduan->status == 'menunggu') bg-yellow-100 text-yellow-800
                                            @elseif($pengaduan->status == 'diproses') bg-orange-100 text-orange-800
                                            @elseif($pengaduan->status == 'selesai') bg-green-100 text-green-800
                                            @else bg-gray-100 text-gray-800
                                            @endif">
                                            {{ ucfirst($pengaduan->status) }}
                                        </span>
                                    </td>
                                    <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">
                                        <a href="{{ route('pengaduan.show', $pengaduan->id) }}" class="text-indigo-600 hover:text-indigo-900">Detail</a>
                                    </td>
                                </tr>
                                @empty
                                <tr>
                                    <td colspan="7" class="px-6 py-4 whitespace-nowrap text-sm text-gray-500 text-center">
                                        Tidak ada pengaduan terbaru
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

    @push('scripts')
    <script src="{{ asset('js/dashboard-charts.js') }}"></script>
    <script>
        // Inisialisasi chart dengan data dari controller
        document.addEventListener('DOMContentLoaded', function() {
            DashboardCharts.initialize(
                {
                    labels: {!! json_encode($pengaduanByStatus->keys()->map(function($status) { return ucfirst($status); })) !!},
                    values: {!! json_encode($pengaduanByStatus->values()) !!}
                },
                {
                    labels: {!! json_encode($pengaduanByBentukKekerasan->keys()) !!},
                    values: {!! json_encode($pengaduanByBentukKekerasan->values()) !!}
                }
            );
        });
    </script>
    @endpush
</x-app-layout> 