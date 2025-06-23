@extends('template.main')
@section('content_template')

<section class="bg-gray-100 py-8 px-4 sm:px-6 lg:px-8">
    <div class="max-w-4xl mx-auto">
        <!-- Breadcrumb -->
        <nav class="text-sm text-gray-600 font-semibold mb-6" aria-label="Breadcrumb">
            <ol class="flex items-center space-x-2">
                <li><a href="{{ route('staff.dashboard') }}" class="text-blue-600 hover:underline">Dashboard</a></li>
                <li class="text-gray-600">/</li>
                <li><a href="{{ route('staff.pendampingan.index') }}" class="text-blue-600 hover:underline">Manajemen Pendampingan</a></li>
                <li class="text-gray-600">/</li>
                <li class="text-gray-500">Buat Jadwal Baru</li>
            </ol>
        </nav>

        <div class="bg-white rounded-lg shadow-md">
            <!-- Header -->
            <div class="p-6 border-b border-gray-200">
                <h2 class="text-2xl font-bold text-gray-800">Buat Jadwal Pendampingan</h2>
                <p class="text-sm text-gray-600 mt-1">Isi formulir di bawah ini untuk membuat jadwal pendampingan baru.</p>
            </div>

            <!-- Form -->
            <form action="{{ route('staff.pendampingan.store') }}" method="POST" class="p-8">
                @csrf
                <div class="grid grid-cols-1 md:grid-cols-2 gap-x-8 gap-y-6">
                    <!-- Kolom Kiri -->
                    <div>
                        <label for="pengaduan_id" class="block text-sm font-semibold text-gray-700 mb-2">Pengaduan Terkait *</label>
                        <select id="pengaduan_id" name="pengaduan_id" class="w-full px-4 py-2 bg-gray-50 border rounded-lg" required>
                            <option value="">-- Pilih ID Pengaduan --</option>
                            @foreach ($pengaduans as $pengaduan)
                                <option value="{{ $pengaduan->id }}" data-korban-id="{{ $pengaduan->korban->id }}" data-korban-nama="{{ $pengaduan->korban->nama }}">
                                    ID: {{ $pengaduan->id }}
                                </option>
                            @endforeach
                        </select>
                    </div>

                    <div>
                        <label for="korban_id" class="block text-sm font-semibold text-gray-700 mb-2">Nama Korban *</label>
                        <input type="text" id="korban_nama" class="w-full px-4 py-2 bg-gray-200 border rounded-lg" readonly>
                        <input type="hidden" id="korban_id" name="korban_id">
                    </div>

                    <div>
                        <label for="jenis_layanan" class="block text-sm font-semibold text-gray-700 mb-2">Jenis Layanan Pendampingan *</label>
                        <select id="jenis_layanan" name="jenis_layanan" class="w-full px-4 py-2 bg-gray-50 border rounded-lg" required>
                            <option value="">-- Pilih Jenis Layanan --</option>
                            @foreach ($layanans as $layanan)
                                <option value="{{ $layanan->nama_layanan }}">{{ $layanan->nama_layanan }}</option>
                            @endforeach
                        </select>
                    </div>

                    <div>
                        <label for="nama_pendamping" class="block text-sm font-semibold text-gray-700 mb-2">Nama Pendamping *</label>
                        <select id="nama_pendamping" name="nama_pendamping" class="w-full px-4 py-2 bg-gray-50 border rounded-lg" required>
                            <option value="">-- Pilih Pendamping --</option>
                            @foreach ($instrukturs as $instruktur)
                                <option value="{{ $instruktur->nama }}" data-layanan="{{ $instruktur->nama_layanan }}">{{ $instruktur->nama }}</option>
                            @endforeach
                        </select>
                    </div>
                    
                    <!-- Kolom Kanan -->
                    <div>
                        <label for="tanggal_pendampingan" class="block text-sm font-semibold text-gray-700 mb-2">Tanggal Pendampingan *</label>
                        <input type="date" id="tanggal_pendampingan" name="tanggal_pendampingan" class="w-full px-4 py-2 bg-gray-50 border rounded-lg" required>
                    </div>

                    <div class="md:col-span-1">
                        <label for="waktu_pendampingan" class="block text-sm font-semibold text-gray-700 mb-2">Waktu Pendampingan *</label>
                        <select id="waktu_pendampingan" name="waktu_pendampingan" class="w-full px-4 py-2 bg-gray-50 border rounded-lg" required>
                            <option value="">--:--</option>
                            <option value="08:00">08:00</option>
                            <option value="09:00">09:00</option>
                            <option value="10:00">10:00</option>
                            <option value="11:00">11:00</option>
                            <option value="12:00">12:00</option>
                            <option value="13:00">13:00</option>
                            <option value="14:00">14:00</option>
                            <option value="15:00">15:00</option>
                        </select>
                        <p class="mt-1 text-sm text-gray-500">Pilih jam pendampingan.</p>
                    </div>

                    <div class="md:col-span-2">
                        <label for="tempat_pendampingan" class="block text-sm font-semibold text-gray-700 mb-2">Tempat Pendampingan *</label>
                        <textarea id="tempat_pendampingan" name="tempat_pendampingan" rows="3" class="w-full px-4 py-2 bg-gray-50 border rounded-lg" required></textarea>
                    </div>

                    <div class="md:col-span-2">
                        <label for="konfirmasi" class="block text-sm font-semibold text-gray-700 mb-2">Status Jadwal *</label>
                        <select id="konfirmasi" name="konfirmasi" class="w-full px-4 py-2 bg-gray-50 border rounded-lg" required>
                            <option value="{{ App\Models\Pendampingan::STATUS_MENUNGGU_KONFIRMASI_USER }}" selected>Menunggu Konfirmasi User</option>
                            <option value="{{ App\Models\Pendampingan::STATUS_BUTUH_KONFIRMASI_STAFF }}">Butuh Konfirmasi Staff</option>
                            <option value="{{ App\Models\Pendampingan::STATUS_TERKONFIRMASI }}">Terkonfirmasi</option>
                            <option value="{{ App\Models\Pendampingan::STATUS_DIBATALKAN }}">Dibatalkan</option>
                        </select>
                    </div>
                </div>

                <!-- Tombol Aksi -->
                <div class="flex justify-end gap-4 mt-8">
                    <a href="{{ route('staff.pendampingan.index') }}" class="bg-gray-300 text-gray-800 px-6 py-2 rounded-lg hover:bg-gray-400">Batal</a>
                    <button type="submit" class="bg-blue-600 text-white px-6 py-2 rounded-lg hover:bg-blue-700 shadow-md">Simpan Jadwal</button>
                </div>
            </form>
        </div>
    </div>
</section>

<script>
document.addEventListener('DOMContentLoaded', function () {
    const pengaduanSelect = document.getElementById('pengaduan_id');
    const korbanNamaInput = document.getElementById('korban_nama');
    const korbanIdInput = document.getElementById('korban_id');
    const layananSelect = document.getElementById('jenis_layanan');
    const pendampingSelect = document.getElementById('nama_pendamping');
    const pendampingOptions = Array.from(pendampingSelect.options);

    pengaduanSelect.addEventListener('change', function () {
        const selectedOption = this.options[this.selectedIndex];
        if (selectedOption.value) {
            korbanNamaInput.value = selectedOption.getAttribute('data-korban-nama');
            korbanIdInput.value = selectedOption.getAttribute('data-korban-id');
        } else {
            korbanNamaInput.value = '';
            korbanIdInput.value = '';
        }
    });

    layananSelect.addEventListener('change', function () {
        const selectedLayanan = this.value;
        pendampingSelect.innerHTML = '<option value="">-- Pilih Pendamping --</option>'; // Reset
        
        pendampingOptions.forEach(function (option) {
            if (option.value && option.getAttribute('data-layanan') === selectedLayanan) {
                pendampingSelect.add(option.cloneNode(true));
            }
        });
    });
});
</script>

@endsection 