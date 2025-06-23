@extends('template.main')
@section('content_template')

<style>
    .form-input {
        width: 100%;
        background-color: #f0f8ff;
        color: #333;
        padding: 0.75rem 1rem;
        border: 1px solid #d1d5db;
        border-radius: 0.5rem;
        transition: border-color 0.2s;
    }
    .form-input:focus {
        outline: none;
        border-color: #2563eb;
        box-shadow: 0 0 0 2px rgba(37, 99, 235, 0.2);
    }
    .form-label {
        display: block;
        margin-bottom: 0.5rem;
        font-weight: 600;
        color: #374151;
    }
    .status-badge {
        padding: 0.25rem 0.75rem;
        border-radius: 9999px;
        font-size: 0.75rem;
        font-weight: 600;
        text-transform: uppercase;
    }
    .status-menunggu { background-color: #fef3c7; color: #92400e; }
    .status-proses { background-color: #dbeafe; color: #1e40af; }
    .status-selesai { background-color: #d1fae5; color: #065f46; }
    .status-ditolak { background-color: #fee2e2; color: #991b1b; }
</style>

<section class="bg-white py-6 px-4 sm:px-6 lg:px-8">
    <!-- Breadcrumb -->
    <nav class="text-sm text-gray-600 font-semibold mb-6" aria-label="Breadcrumb">
        <ol class="flex items-center space-x-2">
            <li><a href="{{ url('/') }}" class="text-blue-600 hover:underline">Homepage</a></li>
            <li class="text-gray-600">/</li>
            <li><a href="{{ route('pengaduan.index') }}" class="text-blue-600 hover:underline">Layanan Pengaduan</a></li>
            <li class="text-gray-600">/</li>
            <li class="text-gray-500">Buat Pengaduan Baru</li>
        </ol>
    </nav>

    <!-- Main Form -->
    <div class="bg-white rounded-lg shadow-md">
        <div class="p-6 border-b border-gray-200">
            <h2 class="text-xl font-semibold text-gray-800">Buat Pengaduan Baru</h2>
            <p class="text-sm text-gray-600 mt-1">Silakan isi detail identitas korban dan informasi kejadian.</p>
        </div>

        <form action="{{ route('pengaduan.store') }}" method="POST" class="p-6">
            @csrf

            @if ($errors->any())
                <div class="bg-red-100 border-l-4 border-red-500 text-red-700 p-4 rounded-lg mb-6" role="alert">
                    <p class="font-bold mb-2">Terjadi Kesalahan</p>
                    <ul class="list-disc list-inside">
                        @foreach ($errors->all() as $error)
                            <li>{{ $error }}</li>
                        @endforeach
                    </ul>
                </div>
            @endif

            <h3 class="text-lg font-semibold text-gray-700 mb-6 border-l-4 border-blue-500 pl-4">Identitas Korban</h3>
            
            <div class="grid grid-cols-1 md:grid-cols-2 gap-x-8 gap-y-6">
                <!-- Nama Lengkap -->
                <div>
                    <label for="korban_nama" class="form-label">Nama Lengkap *</label>
                    <input type="text" id="korban_nama" name="korban[nama]" value="{{ old('korban.nama') }}" class="form-input" placeholder="Masukkan nama lengkap korban" required>
                </div>

                <!-- Jenis Kelamin -->
                <div>
                    <label for="korban_jenis_kelamin" class="form-label">Jenis Kelamin *</label>
                    <select id="korban_jenis_kelamin" name="korban[jenis_kelamin]" class="form-input" required>
                        <option value="" disabled selected>Pilih Jenis Kelamin</option>
                        <option value="Laki-laki" {{ old('korban.jenis_kelamin') == 'Laki-laki' ? 'selected' : '' }}>Laki-laki</option>
                        <option value="Perempuan" {{ old('korban.jenis_kelamin') == 'Perempuan' ? 'selected' : '' }}>Perempuan</option>
                    </select>
                </div>

                <!-- Disabilitas -->
                <div>
                    <label for="korban_disabilitas" class="form-label">Disabilitas *</label>
                    <select id="korban_disabilitas" name="korban[disabilitas]" class="form-input" required>
                        <option value="" disabled selected>Pilih Status Disabilitas</option>
                        <option value="Tidak" {{ old('korban.disabilitas', 'Tidak') == 'Tidak' ? 'selected' : '' }}>Tidak</option>
                        <option value="Ya" {{ old('korban.disabilitas') == 'Ya' ? 'selected' : '' }}>Ya</option>
                    </select>
                </div>

                <!-- Usia saat Kejadian -->
                <div>
                    <label for="korban_usia" class="form-label">Usia saat Kejadian *</label>
                    <input type="number" id="korban_usia" name="korban[usia]" value="{{ old('korban.usia') }}" class="form-input" placeholder="Masukkan usia korban" required min="0">
                </div>

                <!-- Pendidikan -->
                <div>
                    <label for="korban_pendidikan" class="form-label">Pendidikan *</label>
                    <select id="korban_pendidikan" name="korban[pendidikan]" class="form-input" required>
                        <option value="">-- Pilih Pendidikan --</option>
                        <option value="Tidak Sekolah" {{ old('korban.pendidikan') == 'Tidak Sekolah' ? 'selected' : '' }}>Tidak Sekolah</option>
                        <option value="SD" {{ old('korban.pendidikan') == 'SD' ? 'selected' : '' }}>SD</option>
                        <option value="SMP" {{ old('korban.pendidikan') == 'SMP' ? 'selected' : '' }}>SMP</option>
                        <option value="SMA" {{ old('korban.pendidikan') == 'SMA' ? 'selected' : '' }}>SMA</option>
                        <option value="D3" {{ old('korban.pendidikan') == 'D3' ? 'selected' : '' }}>D3</option>
                        <option value="S1" {{ old('korban.pendidikan') == 'S1' ? 'selected' : '' }}>S1</option>
                        <option value="S2" {{ old('korban.pendidikan') == 'S2' ? 'selected' : '' }}>S2</option>
                        <option value="S3" {{ old('korban.pendidikan') == 'S3' ? 'selected' : '' }}>S3</option>
                    </select>
                </div>

                <!-- Pekerjaan -->
                <div>
                    <label for="korban_pekerjaan" class="form-label">Pekerjaan *</label>
                    <select id="korban_pekerjaan" name="korban[pekerjaan]" class="form-input" required>
                        <option value="">-- Pilih Pekerjaan --</option>
                        @foreach ($pekerjaan as $p)
                            <option value="{{ $p->pekerjaan }}" {{ old('korban.pekerjaan') == $p->pekerjaan ? 'selected' : '' }}>{{ $p->pekerjaan }}</option>
                        @endforeach
                    </select>
                </div>

                <!-- Status Perkawinan -->
                <div>
                    <label for="korban_status_perkawinan" class="form-label">Status Perkawinan *</label>
                    <select id="korban_status_perkawinan" name="korban[status_perkawinan]" class="form-input" required>
                        <option value="">-- Pilih Status Perkawinan --</option>
                        <option value="Belum Kawin" {{ old('korban.status_perkawinan') == 'Belum Kawin' ? 'selected' : '' }}>Belum Kawin</option>
                        <option value="Kawin" {{ old('korban.status_perkawinan') == 'Kawin' ? 'selected' : '' }}>Kawin</option>
                        <option value="Cerai Hidup" {{ old('korban.status_perkawinan') == 'Cerai Hidup' ? 'selected' : '' }}>Cerai Hidup</option>
                        <option value="Cerai Mati" {{ old('korban.status_perkawinan') == 'Cerai Mati' ? 'selected' : '' }}>Cerai Mati</option>
                    </select>
                </div>

                <!-- No Handphone -->
                <div>
                    <label for="korban_no_telepon" class="form-label">No Handphone *</label>
                    <input type="tel" id="korban_no_telepon" name="korban[no_telepon]" value="{{ old('korban.no_telepon') }}" class="form-input" placeholder="Contoh: 08123456789" required>
                </div>

                <h3 class="text-lg font-semibold text-gray-700 mb-2 border-l-4 border-blue-500 pl-4 md:col-span-2 mt-6">Informasi Kejadian</h3>

                <!-- Tempat Kejadian -->
                <div>
                    <label for="tempat_kejadian" class="form-label">Tempat Kejadian *</label>
                    <input type="text" id="tempat_kejadian" name="tempat_kejadian" value="{{ old('tempat_kejadian') }}" class="form-input" placeholder="Contoh: Jl. Merdeka No. 10" required>
                </div>
                
                <!-- Tanggal Kejadian -->
                <div>
                    <label for="tanggal_kejadian" class="form-label">Tanggal Kejadian *</label>
                    <input type="date" id="tanggal_kejadian" name="tanggal_kejadian" value="{{ old('tanggal_kejadian') }}" class="form-input" required>
                </div>

                <!-- Kecamatan -->
                <div class="md:col-span-2">
                    <label for="kecamatan_kejadian" class="form-label">Kecamatan *</label>
                    <select id="kecamatan_kejadian" name="kecamatan_kejadian" class="form-input" required>
                        <option value="">-- Pilih Kecamatan --</option>
                        @foreach ($kecamatans as $kecamatan)
                            <option value="{{ $kecamatan->kecamatan_id }}">{{ $kecamatan->kecamatan_nama }}</option>
                        @endforeach
                    </select>
                </div>
                
                <!-- Kronologi Singkat -->
                <div class="md:col-span-2">
                    <label for="kronologi" class="form-label">Kronologi Singkat *</label>
                    <textarea id="kronologi" name="kronologi" rows="5" class="form-input" placeholder="Deskripsikan kronologi kejadian secara singkat dan jelas" required>{{ old('kronologi') }}</textarea>
                </div>
            </div>

            <!-- Buttons -->
            <div class="flex justify-end items-center mt-8 gap-4">
                <a href="{{ route('pengaduan.index') }}" class="bg-gray-200 text-gray-800 font-semibold px-6 py-2 rounded-lg hover:bg-gray-300 transition-colors">
                    Batal
                </a>
                <button type="submit" class="bg-blue-600 text-white font-semibold px-6 py-2 rounded-lg hover:bg-blue-700 transition-colors">
                    Simpan
                </button>
            </div>
        </form>
    </div>
</section>

@endsection 