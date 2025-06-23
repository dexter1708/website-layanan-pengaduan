@extends('template.main')
@section('content_template')

<style>
    .status-badge {
        padding: 0.25rem 0.75rem;
        border-radius: 9999px;
        font-size: 0.75rem;
        font-weight: 600;
        text-transform: uppercase;
    }
    .status-menunggu { background-color: #fef3c7; color: #92400e; }
    .status-proses, .status-diproses { background-color: #dbeafe; color: #1e40af; }
    .status-selesai { background-color: #d1fae5; color: #065f46; }
    .status-ditolak { background-color: #fee2e2; color: #991b1b; }
    .status-di_reskrim { background-color: #e5e7eb; color: #374151; }
    .status-di_kejaksaan { background-color: #e0e7ff; color: #3730a3; }
</style>

<section class="bg-white py-6 px-4 sm:px-6 lg:px-8">
    <!-- Breadcrumb -->
    <nav class="text-sm text-gray-600 font-semibold mb-6" aria-label="Breadcrumb">
        <ol class="flex items-center space-x-2">
            <li><a href="{{ url('/') }}" class="text-blue-600 hover:underline">Homepage</a></li>
            <li class="text-gray-600">/</li>
            <li class="text-gray-500">Track Pengaduan</li>
        </ol>
    </nav>

    <!-- Header -->
    <div class="bg-white rounded-lg shadow-md mb-6">
        <div class="p-6 border-b border-gray-200">
            <div>
                <h2 class="text-2xl font-bold text-gray-800">Track Pengaduan Anda</h2>
                <p class="text-sm text-gray-600 mt-1">Pantau status terkini dari semua pengaduan yang telah Anda buat.</p>
            </div>
        </div>
    </div>

    <!-- Tabel Pengaduan -->
    <div class="bg-white rounded-lg shadow-md">
        <div class="p-6 border-b border-gray-200">
            <h3 class="text-lg font-semibold text-gray-800">Daftar Pengaduan</h3>
        </div>
        
        @if($pengaduans->count() > 0)
        <div class="overflow-x-auto">
            <table class="w-full">
                <thead class="bg-gray-50">
                    <tr>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">No</th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Tanggal</th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Nama Korban</th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Status</th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Aksi</th>
                    </tr>
                </thead>
                <tbody class="bg-white divide-y divide-gray-200">
                    @foreach($pengaduans as $pengaduan)
                    <tr class="hover:bg-gray-50">
                        <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900 font-medium">{{ $pengaduan->id }}</td>
                        <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900">
                            {{ \Carbon\Carbon::parse($pengaduan->created_at)->format('d/m/Y') }}
                        </td>
                        <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900">
                            {{ $pengaduan->korban->nama ?? 'N/A' }}
                        </td>
                        <td class="px-6 py-4 whitespace-nowrap">
                            @php
                                $statusClass = 'status-' . str_replace(' ', '-', strtolower($pengaduan->status));
                            @endphp
                            <span class="status-badge {{ $statusClass }}">
                                {{ ucfirst(str_replace('_', ' ', $pengaduan->status)) }}
                            </span>
                        </td>
                        <td class="px-6 py-4 whitespace-nowrap text-sm font-medium">
                            <a href="{{ route('pengaduan.show', $pengaduan->id) }}" 
                               class="text-indigo-600 hover:text-indigo-900 font-semibold mr-4">
                                Lihat Detail
                            </a>
                            <a href="{{ route('tracking.show', $pengaduan->id) }}" 
                               class="text-blue-600 hover:text-blue-900 font-semibold">
                                Riwayat
                            </a>
                             @if(Auth::user()->role === 'staff')
                                <a href="{{ route('staff.tracking.edit', $pengaduan->id) }}" 
                                   class="text-green-600 hover:text-green-900 font-semibold ml-4">
                                    Update Status
                                </a>
                            @endif
                        </td>
                    </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
        @else
        <div class="p-6 text-center">
            <svg class="mx-auto h-12 w-12 text-gray-400" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z" />
            </svg>
            <h3 class="mt-2 text-sm font-medium text-gray-900">Belum ada pengaduan untuk dilacak</h3>
            <p class="mt-1 text-sm text-gray-500">Anda belum membuat pengaduan apapun. Silakan buat pengaduan terlebih dahulu.</p>
            <div class="mt-6">
                <a href="{{ route('pengaduan.create') }}" 
                   class="inline-flex items-center px-6 py-3 border border-transparent shadow-sm text-base font-medium rounded-md text-white bg-blue-600 hover:bg-blue-700">
                    ➕ Buat Pengaduan
                </a>
            </div>
        </div>
        @endif
    </div>
</section>

@endsection 