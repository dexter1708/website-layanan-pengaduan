@extends('template.main')
@section('content_template')

<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/flatpickr/dist/flatpickr.min.css">
<script src="https://cdn.jsdelivr.net/npm/flatpickr"></script>

<style>
    .form-input {
        border-radius: 0.375rem;
        border: 1px solid #d1d5db;
        padding: 0.5rem 0.75rem;
        width: 100%;
        transition: border-color 0.2s ease-in-out;
        background-color: #fff;
    }
    .form-input:focus {
        outline: none;
        border-color: #3b82f6;
        box-shadow: 0 0 0 3px rgba(59, 130, 246, 0.25);
    }
    .form-label {
        font-weight: 600;
        color: #374151;
        margin-bottom: 0.5rem;
        display: block;
    }
</style>

<section class="bg-gray-50 py-8 px-4 sm:px-6 lg:px-8">
    <div class="max-w-2xl mx-auto">
        <!-- Breadcrumb -->
        <nav class="text-sm text-gray-600 font-semibold mb-6" aria-label="Breadcrumb">
            <ol class="flex items-center space-x-2">
                <li><a href="{{ route('dashboard') }}" class="text-blue-600 hover:underline">Dashboard</a></li>
                <li class="text-gray-600">/</li>
                <li><a href="{{ route('konseling.index') }}" class="text-blue-600 hover:underline">Konseling</a></li>
                <li class="text-gray-600">/</li>
                <li class="text-gray-500">Ajukan Konseling</li>
            </ol>
        </nav>

        @if($errors->any())
            <div class="bg-red-100 border border-red-400 text-red-700 px-4 py-3 rounded relative mb-4" role="alert">
                <strong class="font-bold">Oops!</strong>
                <ul class="list-disc list-inside mt-2">
                    @foreach($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
        @endif

        <!-- Form -->
        <div class="bg-white shadow-lg rounded-xl p-8">
            <form method="POST" action="{{ route('konseling.request.store') }}">
                @csrf
                <h2 class="text-2xl font-bold text-gray-800 mb-6 text-center">Ajukan Jadwal Konseling</h2>

                <div class="space-y-6">
                    <!-- Pengaduan -->
                    <div>
                        <label for="pengaduan_id" class="form-label">Pilih Pengaduan *</label>
                        <select name="pengaduan_id" id="pengaduan_id" required class="form-input">
                            <option value="" selected disabled>Pilih ID Pengaduan Anda</option>
                            @foreach($pengaduans as $pengaduan)
                                <option value="{{ $pengaduan->id }}" {{ old('pengaduan_id') == $pengaduan->id ? 'selected' : '' }}>
                                    ID: {{ $pengaduan->id }}
                                </option>
                            @endforeach
                        </select>
                    </div>

                    <!-- Korban -->
                    <div>
                        <label for="korban_id" class="form-label">Nama Korban *</label>
                        <select name="korban_id" id="korban_id" required class="form-input bg-gray-100" readonly>
                            <option value="" selected disabled>Pilih Korban</option>
                        </select>
                         <p id="no-korban-message" class="mt-2 text-sm text-red-600" style="display: none;">
                            Pengaduan ini belum memiliki data korban. Silakan lengkapi data korban terlebih dahulu.
                        </p>
                    </div>

                    <!-- Jenis Layanan -->
                    <div>
                        <label for="jenis_layanan" class="form-label">Jenis Layanan Konseling *</label>
                        <select name="jenis_layanan" id="jenis_layanan" required class="form-input">
                            <option value="" selected disabled>Pilih Jenis Layanan</option>
                            @foreach($layanans as $layanan)
                                <option value="{{ $layanan->nama_layanan }}" {{ old('jenis_layanan') == $layanan->nama_layanan ? 'selected' : '' }}>
                                    {{ $layanan->nama_layanan }}
                                </option>
                            @endforeach
                        </select>
                    </div>
                    
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                        <!-- Tanggal Konseling -->
                        <div>
                            <label for="tanggal_konseling" class="form-label">Tanggal Konseling *</label>
                            <input type="date" id="tanggal_konseling" name="tanggal_konseling" value="{{ old('tanggal_konseling') }}" placeholder="Pilih Tanggal" required class="form-input" />
                        </div>

                        <!-- Waktu Konseling -->
                        <div>
                            <label for="waktu_konseling" class="form-label">Waktu Konseling *</label>
                            <select id="waktu_konseling" name="waktu_konseling" required class="form-input">
                                <option value="" selected disabled>-- Pilih Waktu --</option>
                                @for ($i = 8; $i <= 15; $i++)
                                    @php $time = str_pad($i, 2, '0', STR_PAD_LEFT) . ':00'; @endphp
                                    <option value="{{ $time }}" {{ old('waktu_konseling') == $time ? 'selected' : '' }}>{{ $time }} WIB</option>
                                @endfor
                            </select>
                        </div>
                    </div>
                </div>

                <!-- Tombol -->
                <div class="mt-8 pt-6 border-t border-gray-200 flex justify-end">
                    <button type="submit" class="bg-gray-800 text-white font-bold px-8 py-3 rounded-lg hover:bg-gray-900 transition w-full">
                        Ajukan Konseling
                    </button>
                </div>
            </form>
        </div>
    </div>
</section>

<!-- Hidden data container for JavaScript -->
<div id="pengaduan-data" 
     data-pengaduan="{{ json_encode($pengaduans->map(function($pengaduan) {
         return [
             'id' => $pengaduan->id,
             'korban' => $pengaduan->korban ? [[
                 'id' => $pengaduan->korban->id,
                 'nama' => $pengaduan->korban->nama ?? 'Nama tidak tersedia'
             ]] : []
         ];
     })) }}"
     style="display: none;">
</div>

<script>
document.addEventListener('DOMContentLoaded', function() {
    const pengaduanSelect = document.getElementById('pengaduan_id');
    const korbanSelect = document.getElementById('korban_id');
    const noKorbanMessage = document.getElementById('no-korban-message');
    const dataContainer = document.getElementById('pengaduan-data');
    const pengaduanData = JSON.parse(dataContainer.getAttribute('data-pengaduan'));

    function updateKorbanOptions() {
        const selectedPengaduanId = pengaduanSelect.value;
        korbanSelect.innerHTML = '<option value="" selected disabled>Pilih Korban</option>';
        korbanSelect.disabled = true;
        noKorbanMessage.style.display = 'none';

        if (selectedPengaduanId) {
            const selectedPengaduan = pengaduanData.find(p => p.id == selectedPengaduanId);
            
            if (selectedPengaduan && selectedPengaduan.korban && selectedPengaduan.korban.length > 0) {
                selectedPengaduan.korban.forEach(function(korban) {
                    const option = document.createElement('option');
                    option.value = korban.id;
                    option.textContent = korban.nama;
                    korbanSelect.appendChild(option);
                });
                korbanSelect.disabled = false;
                korbanSelect.classList.remove('bg-gray-100');
            } else {
                noKorbanMessage.style.display = 'block';
                korbanSelect.classList.add('bg-gray-100');
            }
        } else {
             korbanSelect.classList.add('bg-gray-100');
        }
    }

    pengaduanSelect.addEventListener('change', updateKorbanOptions);

    const oldPengaduanId = "{{ old('pengaduan_id') }}";
    if (oldPengaduanId) {
        pengaduanSelect.value = oldPengaduanId;
        updateKorbanOptions();
        const oldKorbanId = "{{ old('korban_id') }}";
        if (oldKorbanId) {
            // Memberi sedikit waktu agar opsi korban ter-render sebelum dipilih
            setTimeout(() => { korbanSelect.value = oldKorbanId; }, 100);
        }
    }
});
</script>

@endsection 