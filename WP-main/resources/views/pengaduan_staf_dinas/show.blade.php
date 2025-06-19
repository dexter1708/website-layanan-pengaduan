@extends('template.main')
@section('content_template')

<section class="bg-white py-6 px-4 sm:px-6 lg:px-8">
    <!-- Breadcrumb -->
    <div class="flex flex-col sm:flex-row sm:items-center sm:justify-between mb-6">
        <nav class="text-sm text-gray-600 font-semibold" aria-label="Breadcrumb">
            <ol class="flex items-center space-x-2">
                <li><a href="{{ url('/') }}" class="text-blue-600 hover:underline">Homepage</a></li>
                <li class="text-gray-600">/</li>
                <li><a href="#" class="text-blue-600 hover:underline">Layanan</a></li>
                <li class="text-gray-600">/</li>
                <li><a href="{{ route('pengaduan.create') }}" class="text-blue-600 hover:underline">Pengaduan Kasus</a></li>
                <li class="text-gray-600">/</li>
                <li class="text-gray-500">Detail</li>
            </ol>
        </nav>
    </div>

    <!-- Detail Content -->
    <div class="overflow-x-auto bg-white rounded-lg shadow px-4 py-6">
        <div class="grid grid-cols-1 md:grid-cols-2 gap-y-6 gap-x-8 text-sm text-gray-800">
            <div>
                <p class="font-semibold">ID Pengaduan</p>
                <p class="text-gray-700">10082874</p>
            </div>
            <div>
                <p class="font-semibold">Nama Korban</p>
                <p class="text-gray-700">Aisyah Nanda</p>
            </div>
            <div>
                <p class="font-semibold">Tanggal</p>
                <p class="text-gray-700">15 - 02 - 2025</p>
            </div>
            <div>
                <p class="font-semibold">Kecamatan</p>
                <p class="text-gray-700">Bojongsoang</p>
            </div>
            <div>
                <p class="font-semibold">Jenis Kasus</p>
                <p class="text-gray-700">Kekerasan terhadap perempuan</p>
            </div>
            <div>
                <p class="font-semibold">Bentuk Kekerasan</p>
                <p class="text-gray-700">Fisik</p>
            </div>

            <!-- Tampilan Status -->
            <div class="md:col-span-2" id="status-display">
                <p class="font-semibold">Status</p>
                <div class="flex flex-col sm:flex-row sm:items-center sm:justify-between gap-3 mt-1">
                    <p class="text-gray-700">Diproses</p>
                    <button onclick="toggleForm()" class="bg-blue-600 hover:bg-blue-700 text-white px-4 py-2 text-sm rounded">
                        Update Status
                    </button>
                </div>
            </div>

            <!-- Form Update Status -->
            <div class="md:col-span-2 hidden" id="status-form">
                <form action="{{ route('pengaduan.create') }}" method="POST" class="w-full flex flex-col sm:flex-row sm:items-end sm:justify-between gap-4">
                    @csrf
                    <div class="w-full">
                        <label for="status" class="block text-sm font-medium text-gray-700 mb-1">Status *</label>
                        <select id="status" name="status"
                            class="w-full bg-blue-50 text-gray-800 px-4 py-2 border-b border-gray-300 focus:outline-none rounded">
                            <option selected disabled hidden>Pilih Status</option>
                            <option value="Diproses">Diproses</option>
                            <option value="Ditolak">Ditolak</option>
                            <option value="Selesai">Selesai</option>
                        </select>
                    </div>
                    <div class="sm:mt-[28px]">
                        <label class="block invisible mb-1">Simpan</label>
                        <button type="submit"
                            class="bg-blue-600 hover:bg-blue-700 text-white px-4 py-2 text-sm rounded">
                            Simpan
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</section>

<script>
    function toggleForm() {
        document.getElementById('status-display').classList.add('hidden');
        document.getElementById('status-form').classList.remove('hidden');
    }
</script>

@endsection
