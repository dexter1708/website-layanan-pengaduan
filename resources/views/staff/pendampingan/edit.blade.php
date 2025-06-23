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
                <li class="text-gray-500">Edit Jadwal #{{ $pendampingan->id }}</li>
            </ol>
        </nav>

        <div class="bg-white rounded-lg shadow-md">
            <!-- Header -->
            <div class="p-6 border-b border-gray-200">
                <h2 class="text-2xl font-bold text-gray-800">Edit Jadwal Pendampingan</h2>
                <p class="text-sm text-gray-600 mt-1">Perbarui detail jadwal pendampingan.</p>
            </div>

            <!-- Form -->
            <form action="{{ route('staff.pendampingan.update', $pendampingan->id) }}" method="POST" class="p-8">
                @csrf
                @method('PUT')
                <div class="grid grid-cols-1 md:grid-cols-2 gap-x-8 gap-y-6">
                    <!-- Kolom Kiri -->
                    <div>
                        <label for="pengaduan_id" class="block text-sm font-semibold text-gray-700 mb-2">Pengaduan Terkait *</label>
                        <select id="pengaduan_id" name="pengaduan_id" class="w-full px-4 py-2 bg-gray-50 border rounded-lg" required>
                            <option value="">-- Pilih ID Pengaduan --</option>
                            @foreach ($pengaduans as $p)
                                <option value="{{ $p->id }}" 
                                        data-korban-id="{{ $p->korban->id ?? '' }}" 
                                        data-korban-nama="{{ $p->korban->nama ?? '' }}"
                                        {{ $p->id == $pendampingan->pengaduan_id ? 'selected' : '' }}>
                                    ID: {{ $p->id }}
                                </option>
                            @endforeach
                        </select>
                    </div>

                    <div>
                        <label for="korban_nama" class="block text-sm font-semibold text-gray-700 mb-2">Nama Korban *</label>
                        <input type="text" id="korban_nama" value="{{ $pendampingan->korban->nama ?? '' }}" class="w-full px-4 py-2 bg-gray-200 border rounded-lg" readonly>
                        <input type="hidden" id="korban_id" name="korban_id" value="{{ $pendampingan->korban_id }}">
                    </div>

                    <div>
                        <label for="jenis_layanan" class="block text-sm font-semibold text-gray-700 mb-2">Jenis Layanan Pendampingan *</label>
                        <select id="jenis_layanan" name="jenis_layanan" class="w-full px-4 py-2 bg-gray-50 border rounded-lg" required>
                            <option value="">-- Pilih Jenis Layanan --</option>
                            @foreach ($layanans as $layanan)
                                <option value="{{ $layanan->nama_layanan }}" {{ $layanan->nama_layanan == $pendampingan->jenis_layanan ? 'selected' : '' }}>
                                    {{ $layanan->nama_layanan }}
                                </option>
                            @endforeach
                        </select>
                    </div>

                    <div>
                        <label for="nama_pendamping" class="block text-sm font-semibold text-gray-700 mb-2">Nama Pendamping *</label>
                        <select id="nama_pendamping" name="nama_pendamping" class="w-full px-4 py-2 bg-gray-50 border rounded-lg" required>
                            <option value="">-- Pilih Pendamping --</option>
                            @foreach ($instrukturs as $instruktur)
                                <option value="{{ $instruktur->nama }}" 
                                        data-layanan="{{ $instruktur->nama_layanan }}"
                                        {{ $instruktur->nama == $pendampingan->nama_pendamping ? 'selected' : '' }}>
                                    {{ $instruktur->nama }}
                                </option>
                            @endforeach
                        </select>
                    </div>
                    
                    <!-- Kolom Kanan -->
                    <div>
                        <label for="tanggal_pendampingan" class="block text-sm font-semibold text-gray-700 mb-2">Tanggal Pendampingan *</label>
                        <input type="date" id="tanggal_pendampingan" name="tanggal_pendampingan" value="{{ \Carbon\Carbon::parse($pendampingan->tanggal_pendampingan)->format('Y-m-d') }}" class="w-full px-4 py-2 bg-gray-50 border rounded-lg" required>
                    </div>

                    <div class="md:col-span-1">
                        <label for="waktu_pendampingan" class="block text-sm font-semibold text-gray-700 mb-2">Waktu Pendampingan *</label>
                        <select id="waktu_pendampingan" name="waktu_pendampingan" class="w-full px-4 py-2 bg-gray-50 border rounded-lg" required>
                            @php
                                $waktuTersimpan = \Carbon\Carbon::parse($pendampingan->tanggal_pendampingan)->format('H:i');
                                $jamPilihan = ['08:00', '09:00', '10:00', '11:00', '12:00', '13:00', '14:00', '15:00'];
                            @endphp
                            <option value="">--:--</option>
                            @foreach ($jamPilihan as $jam)
                                <option value="{{ $jam }}" {{ $waktuTersimpan == $jam ? 'selected' : '' }}>{{ $jam }}</option>
                            @endforeach
                        </select>
                        <p class="mt-1 text-sm text-gray-500">Pilih jam pendampingan.</p>
                    </div>

                    <div class="md:col-span-2">
                        <label for="tempat_pendampingan" class="block text-sm font-semibold text-gray-700 mb-2">Tempat Pendampingan *</label>
                        <textarea id="tempat_pendampingan" name="tempat_pendampingan" rows="3" class="w-full px-4 py-2 bg-gray-50 border rounded-lg" required>{{ $pendampingan->tempat_pendampingan }}</textarea>
                    </div>

                    <div class="md:col-span-2">
                        <label for="konfirmasi" class="block text-sm font-semibold text-gray-700 mb-2">Status Jadwal *</label>
                        <select id="konfirmasi" name="konfirmasi" class="w-full px-4 py-2 bg-gray-50 border rounded-lg" required>
                            <option value="{{ App\Models\Pendampingan::STATUS_BUTUH_KONFIRMASI_STAFF }}" {{ $pendampingan->konfirmasi == App\Models\Pendampingan::STATUS_BUTUH_KONFIRMASI_STAFF ? 'selected' : '' }}>Butuh Konfirmasi Staff</option>
                            <option value="{{ App\Models\Pendampingan::STATUS_MENUNGGU_KONFIRMASI_USER }}" {{ $pendampingan->konfirmasi == App\Models\Pendampingan::STATUS_MENUNGGU_KONFIRMASI_USER ? 'selected' : '' }}>Menunggu Konfirmasi User</option>
                            <option value="{{ App\Models\Pendampingan::STATUS_TERKONFIRMASI }}" {{ $pendampingan->konfirmasi == App\Models\Pendampingan::STATUS_TERKONFIRMASI ? 'selected' : '' }}>Terkonfirmasi</option>
                            <option value="{{ App\Models\Pendampingan::STATUS_DIBATALKAN }}" {{ $pendampingan->konfirmasi == App\Models\Pendampingan::STATUS_DIBATALKAN ? 'selected' : '' }}>Dibatalkan</option>
                        </select>
                    </div>
                </div>

                <!-- Tombol Aksi -->
                <div class="flex justify-end gap-4 mt-8">
                    <a href="{{ route('staff.pendampingan.index') }}" class="bg-gray-300 text-gray-800 px-6 py-2 rounded-lg hover:bg-gray-400">Batal</a>
                    <button type="submit" class="bg-blue-600 text-white px-6 py-2 rounded-lg hover:bg-blue-700 shadow-md">Update Jadwal</button>
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

    function handlePengaduanChange() {
        const selectedOption = pengaduanSelect.options[pengaduanSelect.selectedIndex];
        if (selectedOption.value) {
            korbanNamaInput.value = selectedOption.getAttribute('data-korban-nama');
            korbanIdInput.value = selectedOption.getAttribute('data-korban-id');
        } else {
            korbanNamaInput.value = '';
            korbanIdInput.value = '';
        }
    }

    function handleLayananChange() {
        const selectedLayanan = layananSelect.value;
        const currentPendamping = pendampingSelect.value;
        
        // Clear options except the placeholder
        let placeholder = pendampingSelect.options[0];
        pendampingSelect.innerHTML = '';
        pendampingSelect.add(placeholder);

        pendampingOptions.forEach(function (option) {
            if (option.value && option.getAttribute('data-layanan') === selectedLayanan) {
                pendampingSelect.add(option.cloneNode(true));
            }
        });
        
        // Restore selection if it's still valid
        pendampingSelect.value = currentPendamping;
        if(pendampingSelect.selectedIndex === -1) {
            pendampingSelect.selectedIndex = 0;
        }
    }

    pengaduanSelect.addEventListener('change', handlePengaduanChange);
    layananSelect.addEventListener('change', handleLayananChange);

    // Initial call to set the correct state on page load
    handleLayananChange();
});
</script>

@endsection 