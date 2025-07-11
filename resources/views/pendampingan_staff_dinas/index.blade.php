@extends('template.main')
@section('content_template')

<!-- DataTables CSS & JS -->
<link rel="stylesheet" href="https://cdn.datatables.net/1.13.4/css/jquery.dataTables.min.css">
<script src="https://code.jquery.com/jquery-3.7.1.min.js"></script>
<script src="https://cdn.datatables.net/1.13.4/js/jquery.dataTables.min.js"></script>

<style>
    #tablePendampingan tbody tr:nth-child(even) { background-color: #f0f8ff; }
    #tablePendampingan tbody tr:nth-child(odd) { background-color: #ffffff; }

    .dataTables_wrapper .dataTables_paginate {
        margin-top: 1.5rem;
        display: flex;
        justify-content: center;
        align-items: center;
        font-size: 0.875rem;
    }

    .dataTables_wrapper .dataTables_paginate .paginate_button {
        padding: 6px 12px;
        margin: 0 2px;
        border-radius: 4px;
        background-color: transparent;
        border: none;
        color: #2563eb !important;
        font-weight: 500;
    }

    .dataTables_wrapper .dataTables_paginate .paginate_button.current {
        background-color: #bfdbfe !important;
        color: #1e3a8a !important;
        font-weight: bold;
    }

    div.dataTables_filter {
        margin-bottom: 1.25rem;
        display: flex;
        justify-content: end;
    }

    div.dataTables_filter input {
        border-radius: 9999px;
        border: 1px solid #d1d5db;
        padding: 0.5rem 1rem;
    }

    .table-responsive {
        width: 100%;
        overflow-x: auto;
    }
</style>

<script>
    $(document).ready(function () {
        $('#tablePendampingan').DataTable({
            responsive: true,
            order: [],
            columnDefs: [{ orderable: false, targets: [8] }],
            language: {
                search: "Cari:",
                lengthMenu: "Tampilkan _MENU_ entri",
                info: "Menampilkan _START_ sampai _END_ dari _TOTAL_ entri",
                paginate: {
                    first: "Pertama", last: "Terakhir", next: "Next", previous: "Previous"
                },
                zeroRecords: "Tidak ditemukan data",
                infoEmpty: "Menampilkan 0 sampai 0 dari 0 entri",
                infoFiltered: "(disaring dari _MAX_ total entri)"
            }
        });
    });
</script>

<!-- Konten -->
<section class="bg-white py-6 px-4 sm:px-6 lg:px-8">
    <div class="flex flex-col sm:flex-row sm:items-center sm:justify-between mb-6">
        <nav class="text-sm text-gray-600 font-semibold" aria-label="Breadcrumb">
            <ol class="flex items-center space-x-2">
                <li><a href="{{ url('/') }}" class="text-blue-600 hover:underline">Homepage</a></li>
                <li class="text-gray-600">/</li>
                <li><a href="#" class="text-blue-600 hover:underline">Layanan</a></li>
                <li class="text-gray-600">/</li>
                <li class="text-gray-500">Pendampingan</li>
            </ol>
        </nav>
        @if(Auth::user()->role === 'staff')
        <a href="{{ route('staff.pendampingan.create') }}" class="bg-blue-500 text-white text-sm font-medium py-2 px-4 rounded hover:bg-blue-600 transition">
            + Buat Jadwal
        </a>
        @else
        <a href="{{ route('user.pendampingan.request') }}" class="bg-green-500 text-white text-sm font-medium py-2 px-4 rounded hover:bg-green-600 transition">
            Ajukan Pendampingan
        </a>
        @endif
    </div>

    @if(session('success'))
        <div class="bg-green-100 border border-green-400 text-green-700 px-4 py-3 rounded relative mb-4" role="alert">
            <span class="block sm:inline">{{ session('success') }}</span>
        </div>
    @endif

    <div class="table-responsive bg-white rounded-lg px-2 sm:px-4">
        <table id="tablePendampingan" class="min-w-full text-xs sm:text-sm divide-y divide-gray-200">
            <thead class="bg-blue-600 text-white text-center text-xs sm:text-sm">
                <tr>
                    <th class="p-3 whitespace-nowrap">ID Pengaduan</th>
                    <th class="p-3 whitespace-nowrap">Nama Korban</th>
                    <th class="p-3 whitespace-nowrap">Nama Pendamping</th>
                    <th class="p-3 whitespace-nowrap">Tanggal</th>
                    <th class="p-3 whitespace-nowrap">Waktu</th>
                    <th class="p-3 whitespace-nowrap">Tempat Pendampingan</th>
                    <th class="p-3 whitespace-nowrap">Jenis Pelayanan</th>
                    <th class="p-3 whitespace-nowrap">Status</th>
                    <th class="p-3 whitespace-nowrap">Aksi</th>
                </tr>
            </thead>
            <tbody class="text-center text-gray-800">
                @forelse($pendampingans as $pendampingan)
                    @php
                        $badge = match($pendampingan->konfirmasi) {
                            'menunggu_konfirmasi_user' => 'bg-gray-600 text-white',
                            'setuju' => 'bg-green-600 text-white',
                            'tolak' => 'bg-red-600 text-white',
                            'butuh_konfirmasi_staff' => 'bg-yellow-400 text-black',
                            default => 'bg-gray-400 text-white',
                        };

                        $statusLabel = match($pendampingan->konfirmasi) {
                            'menunggu_konfirmasi_user' => 'Menunggu Konfirmasi',
                            'setuju' => 'Terkonfirmasi',
                            'tolak' => 'Ditolak',
                            'butuh_konfirmasi_staff' => 'Butuh Konfirmasi',
                            default => 'Tidak Diketahui',
                        };

                        $userRole = Auth::user()->role;
                        $link = route('pendampingan.show', $pendampingan->id); // Default link

                        if ($userRole === 'pelapor' && $pendampingan->konfirmasi === 'menunggu_konfirmasi_user') {
                            $link = route('pendampingan.konfirmasi', $pendampingan->id);
                        } elseif ($userRole === 'staff' && $pendampingan->konfirmasi === 'butuh_konfirmasi_staff') {
                            $link = route('staff.pendampingan.edit', $pendampingan->id);
                        }
                    @endphp
                    <tr>
                        <td class="p-3 whitespace-nowrap">{{ $pendampingan->pengaduan_id }}</td>
                        <td class="p-3 whitespace-nowrap">{{ $pendampingan->korban->nama ?? 'Tidak Diketahui' }}</td>
                        <td class="p-3 whitespace-nowrap">{{ $pendampingan->nama_pendamping }}</td>
                        <td class="p-3 whitespace-nowrap">{{ \Carbon\Carbon::parse($pendampingan->tanggal_pendampingan)->format('d-m-Y') }}</td>
                        <td class="p-3 whitespace-nowrap">{{ \Carbon\Carbon::parse($pendampingan->tanggal_pendampingan)->format('H:i') }}</td>
                        <td class="p-3 whitespace-nowrap">{{ $pendampingan->tempat_pendampingan }}</td>
                        <td class="p-3 whitespace-nowrap">{{ $pendampingan->jenis_layanan }}</td>
                        <td class="p-3 whitespace-nowrap">
                            <span class="w-36 text-center px-3 py-1 rounded text-xs font-semibold {{ $badge }}">
                                {{ $statusLabel }}
                            </span>
                        </td>
                        <td class="p-3 whitespace-nowrap">
                            <a href="{{ $link }}" class="bg-blue-500 p-2 rounded hover:bg-blue-600" title="Lihat Detail">
                                <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4 text-white" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                                    <circle cx="11" cy="11" r="8"/>
                                    <line x1="21" y1="21" x2="16.65" y2="16.65"/>
                                </svg>
                            </a>
                        </td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="9" class="p-3 whitespace-nowrap text-center text-gray-500">
                            Tidak ada data pendampingan
                        </td>
                    </tr>
                @endforelse
            </tbody>
        </table>
    </div>
</section>

@endsection

