@extends('template.main')
@section('content_template')

<!-- DataTables CSS & JS -->
<link rel="stylesheet" href="https://cdn.datatables.net/1.13.4/css/jquery.dataTables.min.css">
<script src="https://code.jquery.com/jquery-3.7.1.min.js"></script>
<script src="https://cdn.datatables.net/1.13.4/js/jquery.dataTables.min.js"></script>

<!-- Custom Style -->
<style>
    #tablePengaduan tbody tr:nth-child(even) {
        background-color: #f0f8ff;
    }

    #tablePengaduan tbody tr:nth-child(odd) {
        background-color: #ffffff;
    }

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
        transition: background-color 0.3s ease, color 0.3s ease;
    }

    .dataTables_wrapper .dataTables_paginate .paginate_button:hover {
        background-color: #f0f8ff !important;
        color: #2563eb !important;
        border: none !important;
    }

    .dataTables_wrapper .dataTables_paginate .paginate_button.current {
        background-color: #bfdbfe !important;
        color: #1e3a8a !important;
        font-weight: bold;
        border: none !important;
    }

    .dataTables_wrapper .dataTables_paginate .paginate_button.current:hover {
        background-color: #f0f8ff !important;
        color: #2563eb !important;
    }

    div.dataTables_filter {
        margin-bottom: 1.25rem;
        display: flex;
        justify-content: end;
    }

    div.dataTables_filter label {
        display: flex;
        align-items: center;
        gap: 0.5rem;
        font-weight: 500;
        color: #374151;
    }

    div.dataTables_filter input {
        border-radius: 9999px;
        border: 1px solid #d1d5db;
        padding: 0.5rem 1rem;
        box-shadow: 0 1px 2px rgba(0,0,0,0.05);
        outline: none;
    }
</style>

<script>
    $(document).ready(function () {
        $('#tablePengaduan').DataTable({
            responsive: true,
            order: [],
            columnDefs: [
                { orderable: false, targets: [0, 5] }
            ],
            language: {
                search: "Cari:",
                lengthMenu: "Tampilkan _MENU_ entri",
                info: "Menampilkan _START_ sampai _END_ dari _TOTAL_ entri",
                paginate: {
                    first: "Pertama",
                    last: "Terakhir",
                    next: "Next",
                    previous: "Previous"
                },
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
                <li><a href="{{ url('/') }}" class="text-blue-600 hover:underline">Homepage</a></li>
                <li class="text-gray-600">/</li>
                <li><a href="#" class="text-blue-600 hover:underline">Layanan</a></li>
                <li class="text-gray-600">/</li>
                <li class="text-gray-500">Pengaduan Kasus</li>
            </ol>
        </nav>
        {{-- <button class="bg-blue-500 text-white text-sm font-medium py-2 px-4 rounded hover:bg-blue-600 transition">
            + Buat Pengaduan
        </button> --}}
    </div>

    <div class="overflow-x-auto bg-white rounded-lg shadow px-2 sm:px-4">
        <table id="tablePengaduan" class="table-auto w-full text-xs sm:text-sm divide-y divide-gray-200">
            <thead class="bg-blue-600 text-white text-center">
                <tr>
                    <th class="p-3 whitespace-nowrap"><input type="checkbox"></th>
                    <th class="p-3 whitespace-nowrap">ID Pengaduan</th>
                    <th class="p-3 whitespace-nowrap">Nama Korban</th>
                    <th class="p-3 whitespace-nowrap">Kecamatan</th>
                    <th class="p-3 whitespace-nowrap">Tanggal</th>
                    <th class="p-3 whitespace-nowrap">Aksi</th>
                </tr>
            </thead>
            <tbody class="text-center text-gray-800">
                @foreach ($pengaduans as $pengaduan)
                    @php
                        $badge = match($pengaduan->status) {
                            'Diproses' => 'bg-yellow-500 text-white',
                            'Ditolak' => 'bg-red-600 text-white',
                            'Selesai' => 'bg-green-600 text-white',
                            default => 'bg-gray-400 text-white',
                        };
                    @endphp
                    <tr>
                        <td class="p-3 whitespace-nowrap"><input type="checkbox"></td>
                        <td class="p-3 whitespace-nowrap">{{ $pengaduan->id }}</td>
                        <td class="p-3 whitespace-nowrap">
                            @if($pengaduan->korban)
                                {{ $pengaduan->korban->nama }}
                            @else
                                -
                            @endif
                        </td>
                        <td class="p-3 whitespace-nowrap">{{ $pengaduan->kecamatan }}</td>
                        <td class="p-3 whitespace-nowrap">{{ $pengaduan->tanggal_kejadian }}</td>
                        <td class="p-3 whitespace-nowrap">
                            <div class="flex items-center justify-center gap-2">
                                <a href="{{ route('staff.pengaduan.show', $pengaduan->id) }}" class="bg-blue-500 p-2 rounded hover:bg-blue-600" title="Lihat Detail">
                                    <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4 text-white" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                                        <path stroke-linecap="round" stroke-linejoin="round" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z" />
                                        <path stroke-linecap="round" stroke-linejoin="round" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z" />
                                    </svg>
                                </a>
                                <button type="button" 
                                        class="bg-red-500 p-2 rounded hover:bg-red-600" 
                                        title="Hapus"
                                        onclick="showDeleteModal('delete-form-{{ $pengaduan->id }}', 'delete-modal-{{ $pengaduan->id }}')">
                                    <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4 text-white" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                                        <path stroke-linecap="round" stroke-linejoin="round" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16" />
                                    </svg>
                                </button>
                                
                                <!-- Hidden form for deletion -->
                                <form id="delete-form-{{ $pengaduan->id }}" action="{{ route('staff.pengaduan.destroy', $pengaduan->id) }}" method="POST" class="hidden">
                                    @csrf
                                    @method('DELETE')
                                </form>
                                
                                <!-- Delete confirmation modal -->
                                <x-delete-confirmation-modal 
                                    id="delete-modal-{{ $pengaduan->id }}"
                                    title="Konfirmasi Hapus Pengaduan"
                                    message="Apakah Anda yakin ingin menghapus data ini?"
                                />
                            </div>
                        </td>
                    </tr>
                @endforeach
            </tbody>
        </table>
    </div>
</section>
@endsection
