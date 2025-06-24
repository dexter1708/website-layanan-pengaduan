@extends('template.main')
@section('content_template')

<!-- DataTables CSS & JS -->
<link rel="stylesheet" href="https://cdn.datatables.net/1.13.4/css/jquery.dataTables.min.css">
<script src="https://code.jquery.com/jquery-3.7.1.min.js"></script>
<script src="https://cdn.datatables.net/1.13.4/js/jquery.dataTables.min.js"></script>

    <style>
    /* Custom styles for DataTables to match the Konseling page */
    #tablePendampingan tbody tr:nth-child(even) { background-color: #f0f8ff; }
    #tablePendampingan tbody tr:nth-child(odd) { background-color: #ffffff; }

    .dataTables_wrapper .dataTables_paginate {
        margin-top: 1.5rem;
        display: flex;
        justify-content: flex-end; /* Align pagination to the right */
        font-size: 0.875rem;
    }
    .dataTables_wrapper .dataTables_paginate .paginate_button {
        padding: 6px 12px; margin: 0 2px; border-radius: 4px; background-color: transparent;
        border: 1px solid #d1d5db; color: #374151 !important; font-weight: 500;
        transition: all 0.2s ease;
    }
    .dataTables_wrapper .dataTables_paginate .paginate_button:hover {
        background-color: #e5e7eb !important; border-color: #9ca3af;
    }
    .dataTables_wrapper .dataTables_paginate .paginate_button.current {
        background-color: #2563eb !important; color: white !important; border-color: #2563eb;
    }
    div.dataTables_wrapper div.dataTables_length label,
    div.dataTables_wrapper div.dataTables_filter label {
        display: flex; align-items: center; gap: 0.5rem; font-weight: 500; color: #374151;
    }
    div.dataTables_wrapper div.dataTables_filter input,
    div.dataTables_wrapper div.dataTables_length select {
        border-radius: 6px; border: 1px solid #d1d5db; padding: 0.5rem 0.75rem;
    }
    div.dataTables_wrapper .dataTables_info {
        padding-top: 1.5rem;
        }
    </style>

<script>
    $(document).ready(function () {
        $('#tablePendampingan').DataTable({
            responsive: true,
            order: [[0, 'desc']], // Default sort by ID Pengaduan descending (adjusted index)
            columnDefs: [{ orderable: false, targets: [7] }], // Adjusted index for Aksi column
            language: {
                search: "Cari:",
                lengthMenu: "Tampilkan _MENU_ entri",
                info: "Menampilkan _START_ sampai _END_ dari _TOTAL_ entri",
                paginate: { first: "Pertama", last: "Terakhir", next: "Next", previous: "Previous" },
                zeroRecords: "Tidak ada data yang cocok ditemukan",
                infoEmpty: "Menampilkan 0 entri",
                infoFiltered: "(disaring dari _MAX_ total entri)"
            }
        });
    });
</script>

<!-- Konten -->
    <section class="bg-white py-6 px-4 sm:px-6 lg:px-8">
    <!-- Header -->
    <div class="flex flex-col sm:flex-row sm:items-center sm:justify-between mb-6">
            <nav class="text-sm text-gray-600 font-semibold" aria-label="Breadcrumb">
            <ol class="flex items-center space-x-2">
                <li><a href="{{ url('/') }}" class="text-blue-600 hover:underline">Homepage</a></li>
                <li class="text-gray-600">/</li>
                <li><a href="#" class="text-blue-600 hover:underline">Layanan</a></li>
                <li class="text-gray-600">/</li>
                <li class="text-gray-500">Riwayat Pendampingan</li>
                </ol>
            </nav>
        <a href="{{ route('pendampingan.request') }}" class="mt-3 sm:mt-0 bg-green-500 text-white text-sm font-medium py-2 px-4 rounded hover:bg-green-600 transition">
            Ajukan Pendampingan
        </a>
    </div>

    @if(session('success'))
                        <div class="bg-green-100 border border-green-400 text-green-700 px-4 py-3 rounded relative mb-4" role="alert">
                            <span class="block sm:inline">{{ session('success') }}</span>
                        </div>
                    @endif

    @if(session('error'))
        <div class="bg-red-100 border border-red-400 text-red-700 px-4 py-3 rounded relative mb-4" role="alert">
            <span class="block sm:inline">{{ session('error') }}</span>
        </div>
    @endif

    <!-- Tabel -->
    <div class="table-responsive bg-white rounded-lg p-4 shadow-sm border border-gray-200">
        <table id="tablePendampingan" class="min-w-full text-xs sm:text-sm divide-y divide-gray-200">
            <thead class="bg-blue-600 text-white text-center text-xs sm:text-sm">
                <tr>
                    <th class="p-3">ID Pengaduan</th>
                    <th class="p-3">Nama Korban</th>
                    <th class="p-3">Nama Pendamping</th>
                    <th class="p-3">Tanggal</th>
                    <th class="p-3">Waktu</th>
                    <th class="p-3">Tempat</th>
                    <th class="p-3">Jenis Layanan</th>
                    <th class="p-3">Status</th>
                    <th class="p-3">Aksi</th>
                </tr>
            </thead>
            <tbody class="divide-y divide-gray-200 text-center">
                @forelse($pendampingans as $p)
                    <tr>
                        <td class="p-3">{{ $p->pengaduan_id }}</td>
                        <td class="p-3">{{ $p->korban->nama ?? '-' }}</td>
                        <td class="p-3">{{ $p->nama_pendamping ?? 'Belum Ditentukan' }}</td>
                        <td class="p-3">{{ $p->tanggal_pendampingan ? \Carbon\Carbon::parse($p->tanggal_pendampingan)->format('d-m-Y') : '-' }}</td>
                        <td class="p-3">{{ $p->tanggal_pendampingan ? \Carbon\Carbon::parse($p->tanggal_pendampingan)->format('H:i') : '-' }}</td>
                        <td class="p-3">{{ $p->tempat_pendampingan ?? 'Belum Ditentukan' }}</td>
                        <td class="p-3">{{ $p->jenis_layanan ?? 'N/A' }}</td>
                        <td class="p-3">
                            <span class="px-3 py-1 inline-flex text-xs leading-5 font-semibold rounded-full {{ $p->status_badge_class }} text-white">
                                {{ $p->status_label }}
                            </span>
                        </td>
                        <td class="p-3">
                            <div class="flex items-center justify-center gap-2">
                                <a href="{{ route('pendampingan.show', $p->id) }}" class="text-blue-600 hover:text-blue-900 bg-blue-100 hover:bg-blue-200 p-2 rounded-full inline-flex items-center justify-center" title="Lihat Detail">
                                    <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z" /><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z" /></svg>
                                </a>
                            </div>
                        </td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="9" class="p-4 text-center text-gray-500">
                            Tidak ada jadwal pendampingan yang diajukan.
                        </td>
                    </tr>
                @endforelse
            </tbody>
        </table>
    </div>
</section>
@endsection
