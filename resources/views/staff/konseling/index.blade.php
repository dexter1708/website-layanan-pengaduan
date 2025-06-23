@extends('template.main')
@section('content_template')

<!-- DataTables CSS & JS -->
<link rel="stylesheet" href="https://cdn.datatables.net/1.13.4/css/jquery.dataTables.min.css">
<script src="https://code.jquery.com/jquery-3.7.1.min.js"></script>
<script src="https://cdn.datatables.net/1.13.4/js/jquery.dataTables.min.js"></script>

<!-- Custom Style -->
<style>
    #tableKonseling tbody tr:nth-child(even) { background-color: #f0f8ff; }
    #tableKonseling tbody tr:nth-child(odd) { background-color: #ffffff; }
    .dataTables_wrapper .dataTables_paginate { margin-top: 1.5rem; display: flex; justify-content: center; }
    .dataTables_wrapper .dataTables_paginate .paginate_button { padding: 6px 12px; margin: 0 2px; border-radius: 4px; background-color: transparent; border: none; color: #2563eb !important; }
    .dataTables_wrapper .dataTables_paginate .paginate_button:hover { background-color: #f0f8ff !important; color: #2563eb !important; }
    .dataTables_wrapper .dataTables_paginate .paginate_button.current { background-color: #bfdbfe !important; color: #1e3a8a !important; font-weight: bold; }
    div.dataTables_filter { margin-bottom: 1.25rem; display: flex; justify-content: end; }
    div.dataTables_filter label { display: flex; align-items: center; gap: 0.5rem; font-weight: 500; }
    div.dataTables_filter input { border-radius: 9999px; border: 1px solid #d1d5db; padding: 0.5rem 1rem; }
</style>

<script>
    $(document).ready(function () {
        $('#tableKonseling').DataTable({
            responsive: true,
            order: [],
            columnDefs: [ { orderable: false, targets: [6] } ], // Kolom Aksi tidak bisa diurutkan
            language: {
                search: "Cari:",
                lengthMenu: "Tampilkan _MENU_ entri",
                info: "Menampilkan _START_ sampai _END_ dari _TOTAL_ entri",
                paginate: { first: "Pertama", last: "Terakhir", next: "Next", previous: "Previous" },
                zeroRecords: "Tidak ditemukan data yang cocok",
                infoEmpty: "Menampilkan 0 sampai 0 dari 0 entri",
                infoFiltered: "(disaring dari total _MAX_ entri)"
            }
        });
    });
</script>

<!-- Section -->
<section class="bg-white py-6 px-4 sm:px-6 lg:px-8">
    <div class="flex flex-col sm:flex-row sm:items-center sm:justify-between mb-6 space-y-3 sm:space-y-0">
        <nav class="text-sm text-gray-600 font-semibold" aria-label="Breadcrumb">
            <ol class="flex items-center space-x-2">
                <li><a href="{{ url('/staff/dashboard') }}" class="text-blue-600 hover:underline">Dashboard</a></li>
                <li class="text-gray-600">/</li>
                <li class="text-gray-500">Manajemen Konseling</li>
            </ol>
        </nav>
        <a href="{{ route('staff.konseling.create') }}" class="bg-blue-500 text-white text-sm font-medium py-2 px-4 rounded hover:bg-blue-600 transition">
            + Tambah Jadwal Konseling
        </a>
    </div>

    <div class="overflow-x-auto bg-white rounded-lg shadow px-4">
        <table id="tableKonseling" class="table-auto w-full text-sm divide-y divide-gray-200">
            <thead class="bg-blue-600 text-white text-center">
                <tr>
                    <th class="p-3">ID</th>
                    <th class="p-3">Nama Korban</th>
                    <th class="p-3">Nama Konselor</th>
                    <th class="p-3">Jadwal</th>
                    <th class="p-3">Jenis Layanan</th>
                    <th class="p-3">Status</th>
                    <th class="p-3">Aksi</th>
                </tr>
            </thead>
            <tbody class="text-center text-gray-800">
                @foreach ($konselings as $k)
                    <tr>
                        <td class="p-3">{{ $k->id }}</td>
                        <td class="p-3">{{ $k->korban->nama ?? 'N/A' }}</td>
                        <td class="p-3">{{ $k->nama_konselor }}</td>
                        <td class="p-3">{{ \Carbon\Carbon::parse($k->jadwal_konseling)->format('d-m-Y, H:i') }}</td>
                        <td class="px-4 py-2 text-sm text-gray-700 text-center">
                            {{ $k->jenis_layanan }}
                        </td>
                        <td class="px-4 py-2 text-sm text-gray-700 text-center">
                            <span class="px-3 py-1 inline-flex text-xs leading-5 font-semibold rounded-full {{ $k->status_badge_class }} text-white">
                                {{ $k->status_label }}
                            </span>
                        </td>
                        <td class="p-3">
                            <div class="flex items-center justify-center gap-2">
                                <a href="{{ route('konseling.show', $k->id) }}" class="bg-blue-500 p-2 rounded hover:bg-blue-600" title="Lihat Detail">
                                    <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4 text-white" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z" /><path stroke-linecap="round" stroke-linejoin="round" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z" /></svg>
                                </a>
                                <a href="{{ route('staff.konseling.edit', $k->id) }}" class="bg-yellow-500 p-2 rounded hover:bg-yellow-600" title="Edit">
                                    <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4 text-white" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z" /></svg>
                                </a>
                                <form action="{{ route('staff.konseling.destroy', $k->id) }}" method="POST" onsubmit="return confirm('Yakin hapus jadwal ini?');">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="bg-red-500 p-2 rounded hover:bg-red-600" title="Hapus">
                                        <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4 text-white" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16" /></svg>
                                    </button>
                                </form>
                            </div>
                        </td>
                    </tr>
                @endforeach
            </tbody>
        </table>
    </div>
</section>
@endsection 