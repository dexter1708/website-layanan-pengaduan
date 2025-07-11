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
            <li><a href="{{ route('konseling.index') }}" class="text-blue-600 hover:underline">Konseling</a></li>
            <li class="text-gray-600">/</li>
            <li class="text-gray-500">Ajukan Konseling</li>
        </ol>
    </nav>

    @if($pengaduans->isEmpty())
        <br>
        <div class="flex items-center justify-center min-h-[300px]">
            <div class="bg-yellow-50 border border-yellow-300 text-yellow-800 rounded-lg shadow p-6 max-w-xl w-full text-center">
                <div class="font-bold mb-2 text-lg flex items-center justify-center gap-2">
                    <svg class="w-6 h-6 text-yellow-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 16h-1v-4h-1m1-4h.01M12 20a8 8 0 100-16 8 8 0 000 16z"/>
                    </svg>
                    Informasi
                </div>
                <div>
                    Saat ini Anda tidak memiliki pengaduan yang dapat diajukan untuk layanan konseling.<br>
                    Semua pengaduan Anda mungkin sudah memiliki jadwal konseling.
                </div>
            </div>
        </div>
    @else
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
        <form method="POST" action="{{ route('konseling.request.store') }}" class="bg-white shadow-md rounded-lg p-6">
            @csrf
            <h2 class="text-lg font-semibold text-gray-800 mb-6">Ajukan Layanan Konseling</h2>

            <div class="grid grid-cols-1 sm:grid-cols-2 gap-6">
                <!-- Pengaduan -->
                <div>
                    <label class="block font-semibold text-gray-800 mb-1">Pilih Pengaduan *</label>
                    <select name="pengaduan_id" id="pengaduan_id" required
                        class="w-full bg-blue-50 text-gray-800 px-4 py-2 border-b border-gray-300 focus:outline-none">
                        <option value="" selected disabled>-- Pilih Pengaduan --</option>
                        @foreach($pengaduans as $pengaduan)
                            <option value="{{ $pengaduan->id }}" 
                                    data-korban-id="{{ $pengaduan->korban->id ?? '' }}"
                                    data-korban-nama="{{ $pengaduan->korban->nama ?? '' }}"
                                    {{ old('pengaduan_id') == $pengaduan->id ? 'selected' : '' }}>
                                ID Pengaduan: {{ $pengaduan->id }}
                            </option>
                        @endforeach
                    </select>
                </div>

                <!-- Korban -->
                <div>
                    <label class="block font-semibold text-gray-800 mb-1">Nama Korban *</label>
                    <select name="korban_id" id="korban_id" required
                        class="w-full bg-blue-50 text-gray-800 px-4 py-2 border-b border-gray-300 focus:outline-none" readonly>
                        <option value="" selected disabled>-- Pilih Pengaduan terlebih dahulu --</option>
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

                <!-- Tanggal Konseling -->
                <div>
                    <label class="block font-semibold text-gray-800 mb-1">Tanggal Konseling yang Diinginkan *</label>
                    <input type="date" name="tanggal_konseling" value="{{ old('tanggal_konseling') }}" required
                        class="w-full bg-blue-50 text-gray-800 px-4 py-2 border-b border-gray-300 focus:outline-none" />
                </div>

                <!-- Waktu Konseling -->
                <div>
                    <label class="block font-semibold text-gray-800 mb-1">Waktu Konseling yang Diinginkan *</label>
                    <select name="waktu_konseling" required class="w-full bg-blue-50 text-gray-800 px-4 py-2 border-b border-gray-300 focus:outline-none">
                        <option value="" selected disabled>-- Pilih Waktu --</option>
                        @for ($i = 8; $i <= 15; $i++)
                            @php $time = str_pad($i, 2, '0', STR_PAD_LEFT) . ':00'; @endphp
                            <option value="{{ $time }}" {{ old('waktu_konseling') == $time ? 'selected' : '' }}>
                                {{ $time }} WIB
                            </option>
                        @endfor
                    </select>
                </div>
            </div>

            <!-- Tombol -->
            <div class="flex justify-center mt-6 gap-4">
                <a href="{{ route('konseling.index') }}" type="button"
                    class="bg-blue-400 text-white px-6 py-2 rounded hover:bg-blue-500 transition">
                    Batal
                </a>
                <button type="submit" class="bg-green-500 text-white px-6 py-2 rounded hover:bg-green-600">
                    Ajukan Konseling
                </button>
            </div>
        </form>
    @endif
</section>

<script>
document.addEventListener('DOMContentLoaded', function() {
    const pengaduanSelect = document.getElementById('pengaduan_id');
    const korbanSelect = document.getElementById('korban_id');

    function updateKorbanDropdown() {
        const pengaduanId = pengaduanSelect.value;
        korbanSelect.innerHTML = '<option value="" selected disabled>-- Pilih Korban --</option>';

        if (pengaduanId) {
            const pengaduanOption = pengaduanSelect.options[pengaduanSelect.selectedIndex];
            const korbanId = pengaduanOption.getAttribute('data-korban-id');
            const korbanNama = pengaduanOption.getAttribute('data-korban-nama');
            
            if (korbanId && korbanNama) {
                const option = new Option(korbanNama, korbanId);
                korbanSelect.add(option);
                korbanSelect.value = korbanId;
            }
        }
    }

    pengaduanSelect.addEventListener('change', updateKorbanDropdown);

    if (pengaduanSelect.value) {
        updateKorbanDropdown();
    }
});
</script>

@endsection