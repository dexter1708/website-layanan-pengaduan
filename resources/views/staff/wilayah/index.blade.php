@extends('template.main')
@section('content_template')

<!-- DataTables CSS & JS -->
<link rel="stylesheet" href="https://cdn.datatables.net/1.13.4/css/jquery.dataTables.min.css">
<script src="https://code.jquery.com/jquery-3.7.1.min.js"></script>
<script src="https://cdn.datatables.net/1.13.4/js/jquery.dataTables.min.js"></script>

<style>
    /* Custom styles for DataTables */
    .dataTables_wrapper .dataTables_paginate .paginate_button {
        padding: 0.3rem 0.7rem; margin: 0 0.1rem; border-radius: 0.25rem;
    }
    .dataTables_wrapper .dataTables_paginate .paginate_button.current {
        background-color: #3b82f6; color: white !important;
    }
    .dataTables_wrapper .dataTables_paginate .paginate_button:hover {
        background-color: #e5e7eb;
    }
    div.dataTables_wrapper div.dataTables_length,
    div.dataTables_wrapper div.dataTables_filter {
        margin-bottom: 1rem;
    }
</style>

<div class="py-12 px-4 sm:px-6 lg:px-8">
    <div class="max-w-7xl mx-auto">
        <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
            <div class="p-6 text-gray-900">
                <!-- Header -->
                <div class="mb-6">
                    <h1 class="text-2xl font-bold text-gray-800 mb-2">
                        Manajemen Wilayah
                    </h1>
                    <p class="text-gray-600">
                        Kelola data wilayah (Kota, Kecamatan, Desa) untuk sistem pengaduan.
                    </p>
                </div>

                @if (session('success'))
                    <div class="bg-green-100 border-l-4 border-green-500 text-green-700 p-4 mb-4" role="alert">
                        <p>{{ session('success') }}</p>
                    </div>
                @endif

                @if (session('error'))
                    <div class="bg-red-100 border-l-4 border-red-500 text-red-700 p-4 mb-4" role="alert">
                        <p>{{ session('error') }}</p>
                    </div>
                @endif

                <div class="mb-4">
                    <a href="{{ route('staff.wilayah.create') }}" class="inline-block bg-blue-600 hover:bg-blue-700 text-white font-bold py-2 px-4 rounded-lg">
                        <i class="fas fa-plus mr-2"></i>Tambah Wilayah
                    </a>
                </div>

                <div class="mb-4">
                    <div class="border-b border-gray-200">
                        <nav class="-mb-px flex space-x-8" aria-label="Tabs">
                            <button onclick="showTab('kota')" class="tab-button border-indigo-500 text-indigo-600 whitespace-nowrap py-4 px-1 border-b-2 font-medium text-sm">
                                Kota
                            </button>
                            <button onclick="showTab('kecamatan')" class="tab-button border-transparent text-gray-500 hover:text-gray-700 hover:border-gray-300 whitespace-nowrap py-4 px-1 border-b-2 font-medium text-sm">
                                Kecamatan
                            </button>
                            <button onclick="showTab('desa')" class="tab-button border-transparent text-gray-500 hover:text-gray-700 hover:border-gray-300 whitespace-nowrap py-4 px-1 border-b-2 font-medium text-sm">
                                Desa
                            </button>
                        </nav>
                    </div>
                </div>

                <!-- Kota Table -->
                <div id="kota-tab" class="tab-content">
                    <table id="kotaTable" class="min-w-full bg-white">
                        <thead class="bg-gray-50">
                            <tr>
                                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Nama Kota</th>
                                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Aksi</th>
                            </tr>
                        </thead>
                        <tbody class="bg-white divide-y divide-gray-200">
                        @foreach($kotas ?? [] as $item)
                            <tr>
                                <td class="px-6 py-4 whitespace-nowrap">{{ $item->kota_nama }}</td>
                                <td class="px-6 py-4 whitespace-nowrap text-sm font-medium">
                                    <div class="flex space-x-2">
                                        <a href="{{ route('staff.wilayah.edit', ['type' => 'kota', 'id' => $item->kota_id]) }}" class="text-yellow-600 hover:text-yellow-900">Edit</a>
                                        <form action="{{ route('staff.wilayah.destroy', ['type' => 'kota', 'id' => $item->kota_id]) }}" method="POST" onsubmit="return confirm('Yakin ingin menghapus kota ini? Ini akan menghapus semua kecamatan dan desa di dalamnya.');">
                                            @csrf
                                            @method('DELETE')
                                            <button type="submit" class="text-red-600 hover:text-red-900">Hapus</button>
                                        </form>
                                    </div>
                                </td>
                            </tr>
                        @endforeach
                        </tbody>
                    </table>
                </div>

                <!-- Kecamatan Table -->
                <div id="kecamatan-tab" class="tab-content hidden">
                    <table id="kecamatanTable" class="min-w-full bg-white">
                        <thead class="bg-gray-50">
                            <tr>
                                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Kota</th>
                                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Nama Kecamatan</th>
                                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Aksi</th>
                            </tr>
                        </thead>
                        <tbody class="bg-white divide-y divide-gray-200">
                        @foreach($kecamatans ?? [] as $item)
                            <tr>
                                <td class="px-6 py-4 whitespace-nowrap">{{ $item->kota_nama }}</td>
                                <td class="px-6 py-4 whitespace-nowrap">{{ $item->kecamatan_nama }}</td>
                                <td class="px-6 py-4 whitespace-nowrap text-sm font-medium">
                                    <div class="flex space-x-2">
                                        <a href="{{ route('staff.wilayah.edit', ['type' => 'kecamatan', 'id' => $item->kecamatan_id]) }}" class="text-yellow-600 hover:text-yellow-900">Edit</a>
                                        <form action="{{ route('staff.wilayah.destroy', ['type' => 'kecamatan', 'id' => $item->kecamatan_id]) }}" method="POST" onsubmit="return confirm('Yakin ingin menghapus kecamatan ini? Ini akan menghapus semua desa di dalamnya.');">
                                            @csrf
                                            @method('DELETE')
                                            <button type="submit" class="text-red-600 hover:text-red-900">Hapus</button>
                                        </form>
                                    </div>
                                </td>
                            </tr>
                        @endforeach
                        </tbody>
                    </table>
                </div>

                <!-- Desa Table -->
                <div id="desa-tab" class="tab-content hidden">
                    <table id="desaTable" class="min-w-full bg-white">
                        <thead class="bg-gray-50">
                            <tr>
                                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Kota</th>
                                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Kecamatan</th>
                                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Nama Desa</th>
                                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Aksi</th>
                            </tr>
                        </thead>
                        <tbody class="bg-white divide-y divide-gray-200">
                        @foreach($desas ?? [] as $item)
                            <tr>
                                <td class="px-6 py-4 whitespace-nowrap">{{ $item->kota_nama }}</td>
                                <td class="px-6 py-4 whitespace-nowrap">{{ $item->kecamatan_nama }}</td>
                                <td class="px-6 py-4 whitespace-nowrap">{{ $item->desa_nama }}</td>
                                <td class="px-6 py-4 whitespace-nowrap text-sm font-medium">
                                    <div class="flex space-x-2">
                                        <a href="{{ route('staff.wilayah.edit', ['type' => 'desa', 'id' => $item->desa_id]) }}" class="text-yellow-600 hover:text-yellow-900">Edit</a>
                                        <form action="{{ route('staff.wilayah.destroy', ['type' => 'desa', 'id' => $item->id]) }}" method="POST" onsubmit="return confirm('Yakin ingin menghapus desa ini?');">
                                            @csrf
                                            @method('DELETE')
                                            <button type="submit" class="text-red-600 hover:text-red-900">Hapus</button>
                                        </form>
                                    </div>
                                </td>
                            </tr>
                        @endforeach
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
</div>

<script>
    $(document).ready(function() {
        $('#kotaTable').DataTable({ "language": { "url": "//cdn.datatables.net/plug-ins/1.13.4/i18n/id.json" } });
        $('#kecamatanTable').DataTable({ "language": { "url": "//cdn.datatables.net/plug-ins/1.13.4/i18n/id.json" } });
        $('#desaTable').DataTable({ "language": { "url": "//cdn.datatables.net/plug-ins/1.13.4/i18n/id.json" } });
    });

    function showTab(tabName) {
        document.querySelectorAll('.tab-content').forEach(tab => {
            tab.classList.add('hidden');
        });

        document.querySelectorAll('.tab-button').forEach(button => {
            button.classList.remove('border-indigo-500', 'text-indigo-600');
            button.classList.add('border-transparent', 'text-gray-500', 'hover:text-gray-700', 'hover:border-gray-300');
        });

        document.getElementById(tabName + '-tab').classList.remove('hidden');

        const activeButton = document.querySelector(`button[onclick="showTab('${tabName}')"]`);
        activeButton.classList.add('border-indigo-500', 'text-indigo-600');
        activeButton.classList.remove('border-transparent', 'text-gray-500');
    }
</script>

@endsection 