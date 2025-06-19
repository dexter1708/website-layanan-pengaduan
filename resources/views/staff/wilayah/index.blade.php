<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Manajemen Wilayah') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 text-gray-900">
                    <!-- Informasi Hierarki -->
                    <div class="mb-6 p-4 bg-blue-50 border border-blue-200 rounded-lg">
                        <h3 class="text-lg font-semibold text-blue-800 mb-2">Informasi Hierarki Wilayah:</h3>
                        <ul class="text-blue-700 space-y-1">
                            <li>• <strong>Kota:</strong> Menampilkan semua kota yang ada</li>
                            <li>• <strong>Kecamatan:</strong> Menampilkan semua kecamatan yang ada</li>
                            <li>• <strong>Desa:</strong> Menampilkan semua desa yang ada</li>
                        </ul>
                        <p class="text-blue-600 text-sm mt-2">
                            <strong>Fitur Tambah:</strong> Anda dapat menambahkan Kota baru (otomatis buat Kecamatan & Desa), 
                            Kecamatan baru (otomatis buat Desa), atau Desa baru ke Kecamatan yang sudah ada.
                        </p>
                    </div>

                    @if (session('success'))
                        <div class="bg-green-100 border border-green-400 text-green-700 px-4 py-3 rounded relative mb-4" role="alert">
                            <span class="block sm:inline">{{ session('success') }}</span>
                        </div>
                    @endif

                    @if (session('error'))
                        <div class="bg-red-100 border border-red-400 text-red-700 px-4 py-3 rounded relative mb-4" role="alert">
                            <span class="block sm:inline">{{ session('error') }}</span>
                        </div>
                    @endif

                    <div class="mb-4">
                        <a href="{{ route('staff.wilayah.create') }}" class="bg-blue-500 hover:bg-blue-700 text-white font-bold py-2 px-4 rounded">
                            Tambah Wilayah
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
                        <div class="overflow-x-auto">
                            <table class="min-w-full bg-white">
                                <thead>
                                    <tr>
                                        <th class="px-6 py-3 border-b-2 border-gray-200 bg-gray-50 text-left text-xs font-semibold text-gray-600 uppercase tracking-wider">Nama Kota</th>
                                        <th class="px-6 py-3 border-b-2 border-gray-200 bg-gray-50 text-left text-xs font-semibold text-gray-600 uppercase tracking-wider">Aksi</th>
                                    </tr>
                                </thead>
                                <tbody class="bg-white">
                                    @foreach($kotas as $item)
                                        <tr>
                                            <td class="px-6 py-4 whitespace-nowrap border-b border-gray-200">{{ $item->kota_nama }}</td>
                                            <td class="px-6 py-4 whitespace-nowrap border-b border-gray-200">
                                                <a href="{{ route('staff.wilayah.edit', ['type' => 'kota', 'id' => $item->kota_id]) }}" class="text-indigo-600 hover:text-indigo-900 mr-3">Edit</a>
                                                <form action="{{ route('staff.wilayah.destroy', ['type' => 'kota', 'id' => $item->kota_id]) }}" method="POST" class="inline">
                                                    @csrf
                                                    @method('DELETE')
                                                    <button type="submit" class="text-red-600 hover:text-red-900" onclick="return confirm('Apakah Anda yakin ingin menghapus kota ini?')">Hapus</button>
                                                </form>
                                            </td>
                                        </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        </div>
                    </div>

                    <!-- Kecamatan Table -->
                    <div id="kecamatan-tab" class="tab-content hidden">
                        <div class="overflow-x-auto">
                            <table class="min-w-full bg-white">
                                <thead>
                                    <tr>
                                        <th class="px-6 py-3 border-b-2 border-gray-200 bg-gray-50 text-left text-xs font-semibold text-gray-600 uppercase tracking-wider">Kota</th>
                                        <th class="px-6 py-3 border-b-2 border-gray-200 bg-gray-50 text-left text-xs font-semibold text-gray-600 uppercase tracking-wider">Nama Kecamatan</th>
                                        <th class="px-6 py-3 border-b-2 border-gray-200 bg-gray-50 text-left text-xs font-semibold text-gray-600 uppercase tracking-wider">Aksi</th>
                                    </tr>
                                </thead>
                                <tbody class="bg-white">
                                    @foreach($kecamatans as $item)
                                        <tr>
                                            <td class="px-6 py-4 whitespace-nowrap border-b border-gray-200">{{ $item->kota_nama }}</td>
                                            <td class="px-6 py-4 whitespace-nowrap border-b border-gray-200">{{ $item->kecamatan_nama }}</td>
                                            <td class="px-6 py-4 whitespace-nowrap border-b border-gray-200">
                                                <a href="{{ route('staff.wilayah.edit', ['type' => 'kecamatan', 'id' => $item->kecamatan_id]) }}" class="text-indigo-600 hover:text-indigo-900 mr-3">Edit</a>
                                                <form action="{{ route('staff.wilayah.destroy', ['type' => 'kecamatan', 'id' => $item->kecamatan_id]) }}" method="POST" class="inline">
                                                    @csrf
                                                    @method('DELETE')
                                                    <button type="submit" class="text-red-600 hover:text-red-900" onclick="return confirm('Apakah Anda yakin ingin menghapus kecamatan ini?')">Hapus</button>
                                                </form>
                                            </td>
                                        </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        </div>
                    </div>

                    <!-- Desa Table -->
                    <div id="desa-tab" class="tab-content hidden">
                        <div class="overflow-x-auto">
                            <table class="min-w-full bg-white">
                                <thead>
                                    <tr>
                                        <th class="px-6 py-3 border-b-2 border-gray-200 bg-gray-50 text-left text-xs font-semibold text-gray-600 uppercase tracking-wider">Kota</th>
                                        <th class="px-6 py-3 border-b-2 border-gray-200 bg-gray-50 text-left text-xs font-semibold text-gray-600 uppercase tracking-wider">Kecamatan</th>
                                        <th class="px-6 py-3 border-b-2 border-gray-200 bg-gray-50 text-left text-xs font-semibold text-gray-600 uppercase tracking-wider">Nama Desa</th>
                                        <th class="px-6 py-3 border-b-2 border-gray-200 bg-gray-50 text-left text-xs font-semibold text-gray-600 uppercase tracking-wider">Aksi</th>
                                    </tr>
                                </thead>
                                <tbody class="bg-white">
                                    @foreach($desas as $item)
                                        <tr>
                                            <td class="px-6 py-4 whitespace-nowrap border-b border-gray-200">{{ $item->kota_nama }}</td>
                                            <td class="px-6 py-4 whitespace-nowrap border-b border-gray-200">{{ $item->kecamatan_nama }}</td>
                                            <td class="px-6 py-4 whitespace-nowrap border-b border-gray-200">{{ $item->desa_nama }}</td>
                                            <td class="px-6 py-4 whitespace-nowrap border-b border-gray-200">
                                                <a href="{{ route('staff.wilayah.edit', ['type' => 'desa', 'id' => $item->desa_id]) }}" class="text-indigo-600 hover:text-indigo-900 mr-3">Edit</a>
                                                <form action="{{ route('staff.wilayah.destroy', ['type' => 'desa', 'id' => $item->desa_id]) }}" method="POST" class="inline">
                                                    @csrf
                                                    @method('DELETE')
                                                    <button type="submit" class="text-red-600 hover:text-red-900" onclick="return confirm('Apakah Anda yakin ingin menghapus desa ini?')">Hapus</button>
                                                </form>
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
    </div>

    @push('scripts')
    <script>
        function showTab(tabName) {
            // Hide all tab contents
            document.querySelectorAll('.tab-content').forEach(tab => {
                tab.classList.add('hidden');
            });

            // Remove active state from all tab buttons
            document.querySelectorAll('.tab-button').forEach(button => {
                button.classList.remove('border-indigo-500', 'text-indigo-600');
                button.classList.add('border-transparent', 'text-gray-500');
            });

            // Show selected tab content
            document.getElementById(tabName + '-tab').classList.remove('hidden');

            // Set active state for selected tab button
            event.target.classList.remove('border-transparent', 'text-gray-500');
            event.target.classList.add('border-indigo-500', 'text-indigo-600');
        }

        // Show kota tab by default
        document.addEventListener('DOMContentLoaded', function() {
            showTab('kota');
        });
    </script>
    @endpush
</x-app-layout> 