{{-- <x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Dashboard') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 text-gray-900">
                    {{ __("You're logged in!") }}
                </div>
            </div>
        </div>
    </div>
</x-app-layout> --}}

@extends('template.main')
@section('content_template')
    <!-- Services Section -->
    <section class="py-20 bg-white">
        <div class="container mx-auto px-6">
            <!-- Card Statistik -->
            <div class="grid grid-cols-1 md:grid-cols-3 gap-6 mb-8">
                <!-- Laporan Masuk -->
                <div class="bg-white p-6 rounded-lg shadow text-center">
                    <p class="text-gray-600 text-sm">Laporan Masuk</p>
                    <h2 class="text-3xl font-bold text-gray-900 mt-2">28,324</h2>
                </div>

                <!-- Laporan di Proses -->
                <div class="bg-white p-6 rounded-lg shadow text-center">
                    <p class="text-gray-600 text-sm">Laporan di Proses</p>
                    <h2 class="text-3xl font-bold text-gray-900 mt-2">123</h2>
                </div>

                <!-- Laporan di Tutup -->
                <div class="bg-white p-6 rounded-lg shadow text-center">
                    <p class="text-gray-600 text-sm">Laporan di Tutup</p>
                    <h2 class="text-3xl font-bold text-gray-900 mt-2">28,201</h2>
                </div>
            </div>

            <!-- Filter Placeholder -->
            <div class="mb-4 bg-white p-4 rounded-lg shadow flex flex-wrap gap-4 items-center">
                <span class="font-semibold text-gray-700">Filter:</span>
                <label class="flex items-center space-x-2">
                    <input type="checkbox" class="form-checkbox text-blue-500" />
                    <span>Semua</span>
                </label>
                <label class="flex items-center space-x-2">
                    <input type="checkbox" class="form-checkbox text-blue-500" />
                    <span>Status Laporan</span>
                </label>
                <label class="flex items-center space-x-2">
                    <input type="checkbox" class="form-checkbox text-blue-500" />
                    <span>Jenis Kasus</span>
                </label>
            </div>

            <!-- Chart Container -->
            <div class="bg-white rounded-lg shadow p-6">
                <div id="laporanChart" class="w-full h-96"></div>
            </div>
        </div>

        <!-- Highcharts Script -->
        <script>
            Highcharts.chart('laporanChart', {
                chart: {
                    type: 'column'
                },
                title: {
                    text: 'Statistik Laporan Bulanan'
                },
                xAxis: {
                    categories: ['Jan', 'Feb', 'Mar', 'Apr', 'Mei', 'Jun', 'Jul', 'Agu', 'Sep', 'Okt', 'Nov', 'Des'],
                    crosshair: true
                },
                yAxis: {
                    min: 0,
                    title: {
                        text: 'Jumlah Laporan'
                    }
                },
                tooltip: {
                    shared: true,
                    useHTML: true
                },
                plotOptions: {
                    column: {
                        pointPadding: 0.2,
                        borderWidth: 0
                    }
                },
                series: [{
                        name: 'Laporan Masuk',
                        data: [32, 34, 20, 39, 35, 10, 33, 28, 30, 33, 34, 36],
                        color: '#3B82F6'
                    },
                    {
                        name: 'Laporan di Proses',
                        data: [18, 22, 15, 28, 30, 8, 27, 24, 25, 29, 30, 33],
                        color: '#93C5FD'
                    }
                ]
            });
        </script>
    </section>
@endsection
