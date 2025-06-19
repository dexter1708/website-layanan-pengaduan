{{-- <x-app-layout>
    <x-slot name="header">
        <div class="flex justify-between items-center">
            <h2 class="font-semibold text-xl text-gray-800 leading-tight">
                {{ __('Jadwal Konseling') }}
            </h2>
            @auth
                <!-- Debug info -->
               <!-- <div class="text-sm text-gray-600">
                    Role: {{ auth()->user()->role }}
                </div> -->
                @if (auth()->user()->role === 'staff')
                <a href="{{ route('staff.konseling.create') }}" class="bg-blue-500 hover:bg-blue-700 text-white font-bold py-2 px-4 rounded">
                    Buat Jadwal Konseling
                </a>
                @else
                <a href="{{ route('user.konseling.request') }}" class="bg-green-500 hover:bg-green-700 text-white font-bold py-2 px-4 rounded">
                    {{ __('Ajukan Konseling') }}
                </a>
                @endif
            @endauth
        </div>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            @if (!Auth::check())
                <div class="bg-yellow-100 border border-yellow-400 text-yellow-700 px-4 py-3 rounded relative mb-4" role="alert">
                    <span class="block sm:inline">Silakan <a href="{{ route('login') }}" class="font-bold underline">login</a> untuk melihat jadwal konseling Anda.</span>
                </div>
            @endif

            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 text-gray-900">
                    @if (session('success'))
                        <div class="bg-green-100 border border-green-400 text-green-700 px-4 py-3 rounded relative mb-4" role="alert">
                            <span class="block sm:inline">{{ session('success') }}</span>
                        </div>
                    @endif

                    <div class="overflow-x-auto">
                        <table class="min-w-full divide-y divide-gray-200">
                            <thead class="bg-gray-50">
                                <tr>
                                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">ID Pengaduan</th>
                                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Nama Korban</th>
                                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Jenis Layanan</th>
                                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Konselor</th>
                                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Jadwal</th>
                                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Tempat</th>
                                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Status</th>
                                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Aksi</th>
                                </tr>
                            </thead>
                            <tbody class="bg-white divide-y divide-gray-200">
                                @forelse($konselings as $konseling)
                                    <tr>
                                        <td class="px-6 py-4 whitespace-nowrap">{{ $konseling->pengaduan_id }}</td>
                                        <td class="px-6 py-4 whitespace-nowrap">{{ $konseling->nama_korban }}</td>
                                        <td class="px-6 py-4 whitespace-nowrap">{{ $konseling->jenis_layanan ?? 'Belum ditentukan' }}</td>
                                        <td class="px-6 py-4 whitespace-nowrap">{{ $konseling->nama_konselor }}</td>
                                        <td class="px-6 py-4 whitespace-nowrap">{{ $konseling->getJadwalKonselingShort() }}</td>
                                        <td class="px-6 py-4 whitespace-nowrap">{{ $konseling->tempat_konseling }}</td>
                                        <td class="px-6 py-4 whitespace-nowrap">
                                            <span class="px-2 inline-flex text-xs leading-5 font-semibold rounded-full
                                                @if ($konseling->konfirmasi === 'setuju') bg-green-100 text-green-800
                                                @elseif($konseling->konfirmasi === 'tolak') bg-red-100 text-red-800
                                                @else bg-yellow-100 text-yellow-800
                                                @endif">
                                                {{ $konseling->getStatusLabel() }}
                                            </span>
                                        </td>
                                        <td class="px-6 py-4 whitespace-nowrap text-sm font-medium">
                                            <div class="flex space-x-2">
                                                <a href="{{ route('konseling.show', $konseling->id) }}" class="text-blue-600 hover:text-blue-900">Detail</a>

                                                @if (auth()->user()->role === 'staff')
                                                    <a href="{{ route('staff.konseling.edit', $konseling->id) }}" class="text-yellow-600 hover:text-yellow-900">Edit</a>
                                                    <form action="{{ route('staff.konseling.destroy', $konseling->id) }}" method="POST" class="inline" onsubmit="return confirm('Apakah Anda yakin ingin menghapus jadwal konseling ini?');">
                                                        @csrf
                                                        @method('DELETE')
                                                        <button type="submit" class="text-red-600 hover:text-red-900">Hapus</button>
                                                    </form>
                                                @else
                                                    @if ($konseling->konfirmasi === 'menunggu' || $konseling->konfirmasi === 'menunggu_konfirmasi_user')
                                                        <form action="{{ route('konseling.update-konfirmasi', $konseling->id) }}" method="POST" class="inline">
                                                            @csrf
                                                            @method('PUT')
                                                            <input type="hidden" name="konfirmasi" value="setuju">
                                                            <button type="submit" class="text-green-600 hover:text-green-900">Setuju</button>
                                                        </form>
                                                        <form action="{{ route('konseling.update-konfirmasi', $konseling->id) }}" method="POST" class="inline">
                                                            @csrf
                                                            @method('PUT')
                                                            <input type="hidden" name="konfirmasi" value="tolak">
                                                            <button type="submit" class="text-red-600 hover:text-red-900">Tolak</button>
                                                        </form>
                                                    @endif
                                                @endif
                                            </div>
                                        </td>
                                    </tr>
                                @empty
                                    <tr>
                                        <td colspan="8" class="px-6 py-4 whitespace-nowrap text-center text-gray-500">
                                            Tidak ada jadwal konseling
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
</x-app-layout>  --}}


@extends('template.main')
@section('content_template')

<!-- DataTables CSS & JS -->
<link rel="stylesheet" href="https://cdn.datatables.net/1.13.4/css/jquery.dataTables.min.css">
<script src="https://code.jquery.com/jquery-3.7.1.min.js"></script>
<script src="https://cdn.datatables.net/1.13.4/js/jquery.dataTables.min.js"></script>

<style>
    #tableKonseling tbody tr:nth-child(even) { background-color: #f0f8ff; }
    #tableKonseling tbody tr:nth-child(odd) { background-color: #ffffff; }

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
        outline: none;
    }
</style>

<script>
    $(document).ready(function () {
        $('#tableKonseling').DataTable({
            responsive: true,
            order: [],
            columnDefs: [{ orderable: false, targets: [0, 6] }],
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

<!-- Konten -->
<section class="bg-white py-6 px-4 sm:px-6 lg:px-8">
    <div class="flex flex-col sm:flex-row sm:items-center sm:justify-between mb-6 space-y-3 sm:space-y-0">
        <nav class="text-sm text-gray-600 font-semibold" aria-label="Breadcrumb">
            <ol class="flex items-center space-x-2">
                <li><a href="{{ url('/') }}" class="text-blue-600 hover:underline">Homepage</a></li>
                <li class="text-gray-600">/</li>
                <li><a href="#" class="text-blue-600 hover:underline">Layanan</a></li>
                <li class="text-gray-600">/</li>
                <li class="text-gray-500">Konseling</li>
            </ol>
        </nav>
        <a href="{{ route('konseling.create') }}" class="bg-blue-500 text-white text-sm font-medium py-2 px-4 rounded hover:bg-blue-600 transition">
            + Buat Jadwal
        </a>
    </div>

    <div class="overflow-x-auto bg-white rounded-lg shadow px-2 sm:px-4">
        <table id="tableKonseling" class="table-auto w-full text-xs sm:text-sm divide-y divide-gray-200">
            <thead class="bg-blue-600 text-white text-center">
                <tr>
                    <th class="p-3 whitespace-nowrap"><input type="checkbox"></th>
                    <th class="p-3 whitespace-nowrap">ID Pengaduan</th>
                    <th class="p-3 whitespace-nowrap">Nama Korban</th>
                    <th class="p-3 whitespace-nowrap">Tanggal</th>
                    <th class="p-3 whitespace-nowrap">Waktu</th>
                    <th class="p-3 whitespace-nowrap">Jenis Pelayanan</th>
                    <th class="p-3 whitespace-nowrap">Status</th>
                </tr>
            </thead>
            <tbody class="text-center text-gray-800">
                @php
                    $rows = [
                        ['id' => '10082874', 'nama' => 'Aisyah Nanda', 'tanggal' => '12-02-2025', 'waktu' => '10:00', 'jenis' => 'Kekerasan terhadap perempuan', 'status' => 'Menunggu Konfirmasi'],
                        ['id' => '10082875', 'nama' => 'Nadia Rahma', 'tanggal' => '12-02-2025', 'waktu' => '10:00', 'jenis' => 'Kekerasan anak', 'status' => 'Terkonfirmasi'],
                        ['id' => '10082876', 'nama' => 'Putri Amelia', 'tanggal' => '12-02-2025', 'waktu' => '10:00', 'jenis' => 'KDRT', 'status' => 'Ditolak'],
                    ];
                @endphp

                @foreach ($rows as $r)
                    @php
                        $badge = match ($r['status']) {
                            'Menunggu Konfirmasi' => 'bg-gray-600 text-white',
                            'Terkonfirmasi' => 'bg-green-600 text-white',
                            'Ditolak' => 'bg-red-600 text-white',
                            default => 'bg-gray-400 text-white',
                        };

                        $link = $r['status'] === 'Menunggu Konfirmasi'
                            ? url('konseling/konfirmasi/' . $r['id'])
                            : url('konseling/' . $r['id']);
                    @endphp
                    <tr>
                        <td class="p-3 whitespace-nowrap"><input type="checkbox"></td>
                        <td class="p-3 whitespace-nowrap">{{ $r['id'] }}</td>
                        <td class="p-3 whitespace-nowrap">{{ $r['nama'] }}</td>
                        <td class="p-3 whitespace-nowrap">{{ $r['tanggal'] }}</td>
                        <td class="p-3 whitespace-nowrap">{{ $r['waktu'] }}</td>
                        <td class="p-3 whitespace-nowrap">{{ $r['jenis'] }}</td>
                        <td class="p-3 whitespace-nowrap">
                            <div class="flex items-center justify-center gap-2">
                                <span class="w-36 text-center px-3 py-1 rounded text-xs font-semibold {{ $badge }}">
                                    {{ $r['status'] }}
                                </span>
                                <a href="{{ $link }}" class="bg-blue-500 p-2 rounded hover:bg-blue-600" title="Lihat Detail">
                                    <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4 text-white" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                                        <circle cx="11" cy="11" r="8"/>
                                        <line x1="21" y1="21" x2="16.65" y2="16.65"/>
                                    </svg>
                                </a>
                            </div>
                        </td>
                    </tr>
                @endforeach
            </tbody>
        </table>
    </div>
</section>

@endsection
