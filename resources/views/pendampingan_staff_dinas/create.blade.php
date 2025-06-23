@extends('template.main')
@section('content_template')

<section class="bg-white py-6 px-4 sm:px-6 lg:px-8">
    <!-- Breadcrumb -->
    <nav class="text-sm text-gray-600 font-semibold mb-6" aria-label="Breadcrumb">
        <ol class="flex items-center space-x-2">
            <li><a href="{{ url('/') }}" class="text-blue-600 hover:underline">Homepage</a></li>
            <li class="text-gray-600">/</li>
            <li><a href="#" class="text-blue-600 hover:underline">Layanan</a></li>
            <li class="text-gray-600">/</li>
            <li><a href="{{ route('pendampingan.index') }}" class="text-blue-600 hover:underline">Pendampingan</a></li>
            <li class="text-gray-600">/</li>
            <li class="text-gray-500">Buat Jadwal</li>
        </ol>
    </nav>

    @if($errors->any())
        <div class="bg-red-100 border border-red-400 text-red-700 px-4 py-3 rounded relative mb-4" role="alert">
            <ul class="list-disc list-inside">
                @foreach($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif

    <!-- Form -->
    <form method="POST" action="{{ route('staff.pendampingan.store') }}" class="bg-white shadow-md rounded-lg p-6">
        @csrf
        <h2 class="text-lg font-semibold text-gray-800 mb-6">Layanan Pendampingan Korban</h2>

        <div class="grid grid-cols-1 sm:grid-cols-2 gap-6">
            <!-- Pengaduan -->
            <div>
                <label class="block font-semibold text-gray-800 mb-1">Pengaduan *</label>
                <select name="pengaduan_id" id="pengaduan_id" required
                    class="w-full bg-blue-50 text-gray-800 px-4 py-2 border-b border-gray-300 focus:outline-none">
                    <option value="" selected disabled>-- Pilih Pengaduan --</option>
                    @foreach($pengaduans as $pengaduan)
                        <option value="{{ $pengaduan->id }}" {{ old('pengaduan_id') == $pengaduan->id ? 'selected' : '' }}>
                            ID: {{ $pengaduan->id }} - {{ $pengaduan->korban->nama ?? 'Tidak Ada Korban' }}
                        </option>
                    @endforeach
                </select>
            </div>

            <!-- Korban -->
            <div>
                <label class="block font-semibold text-gray-800 mb-1">Korban *</label>
                <select name="korban_id" id="korban_id" required
                    class="w-full bg-blue-50 text-gray-800 px-4 py-2 border-b border-gray-300 focus:outline-none">
                    <option value="" selected disabled>-- Pilih Korban --</option>
                </select>
            </div>

            <!-- Jenis Layanan -->
            <div>
                <label class="block font-semibold text-gray-800 mb-1">Jenis Layanan *</label>
                <select name="jenis_layanan" id="jenis_layanan" required
                    class="w-full bg-blue-50 text-gray-800 px-4 py-2 border-b border-gray-300 focus:outline-none">
                    <option value="" selected disabled>-- Pilih Jenis Layanan --</option>
                    @foreach($layanans as $layanan)
                        <option value="{{ $layanan->nama_layanan }}" {{ old('jenis_layanan') == $layanan->nama_layanan ? 'selected' : '' }}>
                            {{ $layanan->nama_layanan }}
                        </option>
                    @endforeach
                </select>
            </div>

            <!-- Nama Pendamping -->
            <div>
                <label class="block font-semibold text-gray-800 mb-1">Nama Pendamping *</label>
                <select name="nama_pendamping" id="nama_pendamping" required
                    class="w-full bg-blue-50 text-gray-800 px-4 py-2 border-b border-gray-300 focus:outline-none">
                    <option value="" selected disabled>-- Pilih Pendamping --</option>
                </select>
            </div>

            <!-- Tanggal Pendampingan -->
            <div>
                <label class="block font-semibold text-gray-800 mb-1">Tanggal Pendampingan *</label>
                <input type="date" name="tanggal_pendampingan" value="{{ old('tanggal_pendampingan') }}" required
                    class="w-full bg-blue-50 text-gray-800 px-4 py-2 border-b border-gray-300 focus:outline-none" />
            </div>

            <!-- Waktu Pendampingan -->
            <div>
                <label class="block font-semibold text-gray-800 mb-1">Waktu Pendampingan *</label>
                <input type="time" name="waktu_pendampingan" value="{{ old('waktu_pendampingan') }}" required
                    class="w-full bg-blue-50 text-gray-800 px-4 py-2 border-b border-gray-300 focus:outline-none" />
            </div>

            <!-- Tempat Pendampingan -->
            <div class="sm:col-span-2">
                <label class="block font-semibold text-gray-800 mb-1">Tempat Pendampingan *</label>
                <input type="text" name="tempat_pendampingan" value="{{ old('tempat_pendampingan') }}" placeholder="Masukkan tempat pendampingan" required
                    class="w-full bg-blue-50 text-gray-800 px-4 py-2 border-b border-gray-300 focus:outline-none" />
            </div>
        </div>

        <!-- Tombol -->
        <div class="flex justify-center mt-6 gap-4">
            <a href="{{ route('pendampingan.index') }}" type="button"
                class="bg-blue-400 text-white px-6 py-2 rounded hover:bg-blue-500 transition">
                Batal
            </a>
            <button type="submit" class="bg-blue-500 text-white px-6 py-2 rounded hover:bg-blue-600">
                Simpan
            </button>
        </div>
    </form>
</section>

<script>
document.addEventListener('DOMContentLoaded', function() {
    const pengaduanSelect = document.getElementById('pengaduan_id');
    const korbanSelect = document.getElementById('korban_id');
    const jenisLayananSelect = document.getElementById('jenis_layanan');
    const namaPendampingSelect = document.getElementById('nama_pendamping');

    // Data korban berdasarkan pengaduan
    const korbanData = @json($pengaduans->mapWithKeys(function($pengaduan) {
        return [$pengaduan->id => $pengaduan->korban];
    }));

    // Data instruktur berdasarkan layanan
    const instrukturData = @json($instrukturs->groupBy('nama_layanan'));

    // Update korban ketika pengaduan berubah
    pengaduanSelect.addEventListener('change', function() {
        const pengaduanId = this.value;
        korbanSelect.innerHTML = '<option value="" selected disabled>-- Pilih Korban --</option>';
        
        if (pengaduanId && korbanData[pengaduanId]) {
            const korban = korbanData[pengaduanId];
            if (korban) {
                const option = document.createElement('option');
                option.value = korban.id;
                option.textContent = korban.nama;
                korbanSelect.appendChild(option);
                korbanSelect.value = korban.id;
            }
        }
    });

    // Update pendamping ketika jenis layanan berubah
    jenisLayananSelect.addEventListener('change', function() {
        const jenisLayanan = this.value;
        namaPendampingSelect.innerHTML = '<option value="" selected disabled>-- Pilih Pendamping --</option>';
        
        if (jenisLayanan && instrukturData[jenisLayanan]) {
            instrukturData[jenisLayanan].forEach(function(instruktur) {
                const option = document.createElement('option');
                option.value = instruktur.nama;
                option.textContent = instruktur.nama;
                namaPendampingSelect.appendChild(option);
            });
        }
    });

    // Trigger change events if values are pre-filled
    if (pengaduanSelect.value) {
        pengaduanSelect.dispatchEvent(new Event('change'));
    }
    if (jenisLayananSelect.value) {
        jenisLayananSelect.dispatchEvent(new Event('change'));
    }
});
</script>

@endsection
