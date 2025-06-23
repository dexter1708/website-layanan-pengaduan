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
                <ul class="list-disc list-inside">
                    @foreach($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
        @endif

        <!-- Form -->
        <div class="bg-white shadow-lg rounded-xl p-8">
            <form method="POST" action="{{ route('konseling.store') }}">
                @csrf
                <h2 class="text-2xl font-bold text-gray-800 mb-6 text-center">Ajukan Jadwal Konseling</h2>

                <div class="space-y-6">
                    <!-- Pengaduan -->
                    <div>
                        <label for="pengaduan_id" class="form-label">Pilih Pengaduan *</label>
                        <select name="pengaduan_id" id="pengaduan_id" required class="form-input">
                            <option value="" selected disabled>Pilih ID Pengaduan Anda</option>
                            @foreach($pengaduans as $pengaduan)
                                <option value="{{ $pengaduan->id }}" data-korban-id="{{ $pengaduan->korban->id }}" data-korban-nama="{{ $pengaduan->korban->nama ?? 'Tidak Ada Korban' }}" {{ old('pengaduan_id') == $pengaduan->id ? 'selected' : '' }}>
                                    ID: {{ $pengaduan->id }}
                                </option>
                            @endforeach
                        </select>
                    </div>

                    <!-- Korban -->
                    <div>
                        <label for="korban_id" class="form-label">Nama Korban *</label>
                        <select name="korban_id" id="korban_id" required class="form-input bg-gray-100" readonly>
                            <option value="" selected disabled>Nama Korban akan terisi otomatis</option>
                        </select>
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
                            <label for="jadwal_konseling_tanggal" class="form-label">Tanggal Konseling *</label>
                            <input type="text" id="jadwal_konseling_tanggal" name="jadwal_konseling_tanggal" placeholder="Pilih Tanggal" required class="form-input" />
                        </div>

                        <!-- Waktu Konseling -->
                        <div>
                            <label for="jadwal_konseling_waktu" class="form-label">Waktu Konseling *</label>
                            <input type="text" id="jadwal_konseling_waktu" name="jadwal_konseling_waktu" placeholder="Pilih Waktu" required class="form-input" />
                        </div>
                    </div>
                </div>

                <!-- Tombol -->
                <div class="mt-8 pt-6 border-t border-gray-200 flex justify-end">
                    <button type="submit" class="bg-blue-600 text-white font-bold px-8 py-3 rounded-lg hover:bg-blue-700 transition w-full">
                        Ajukan Konseling
                    </button>
                </div>
            </form>
        </div>
    </div>
</section>

<script>
document.addEventListener('DOMContentLoaded', function() {
    flatpickr("#jadwal_konseling_tanggal", {
        dateFormat: "Y-m-d",
        altInput: true,
        altFormat: "d-m-Y",
        minDate: "today"
    });

    flatpickr("#jadwal_konseling_waktu", {
        enableTime: true,
        noCalendar: true,
        dateFormat: "H:i",
        time_24hr: true
    });

    const pengaduanSelect = document.getElementById('pengaduan_id');
    const korbanSelect = document.getElementById('korban_id');

    pengaduanSelect.addEventListener('change', function() {
        const selectedOption = this.options[this.selectedIndex];
        const korbanId = selectedOption.getAttribute('data-korban-id');
        const korbanNama = selectedOption.getAttribute('data-korban-nama');
        
        korbanSelect.innerHTML = '';

        if (korbanId && korbanNama) {
            const option = document.createElement('option');
            option.value = korbanId;
            option.textContent = korbanNama;
            option.selected = true;
            korbanSelect.appendChild(option);
        } else {
            const defaultOption = document.createElement('option');
            defaultOption.textContent = 'Nama Korban akan terisi otomatis';
            defaultOption.disabled = true;
            defaultOption.selected = true;
            korbanSelect.appendChild(defaultOption);
        }
    });

    if (pengaduanSelect.value) {
        pengaduanSelect.dispatchEvent(new Event('change'));
    }
});
</script>

@endsection
