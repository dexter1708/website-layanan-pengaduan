@extends('template.main')
@section('content_template')

<section class="bg-white py-6 px-4 sm:px-6 lg:px-8">
    <!-- Breadcrumb -->
    <nav class="text-sm text-gray-600 font-semibold mb-6" aria-label="Breadcrumb">
        <ol class="flex items-center space-x-2">
            <li><a href="{{ url('/staff/dashboard') }}" class="text-blue-600 hover:underline">Dashboard</a></li>
            <li class="text-gray-600">/</li>
            <li><a href="{{ route('staff.instruktur.index') }}" class="text-blue-600 hover:underline">Manajemen Instruktur</a></li>
            <li class="text-gray-600">/</li>
            <li class="text-gray-500">Tambah Instruktur</li>
        </ol>
    </nav>

    <!-- Header -->
    <div class="mb-8">
        <h1 class="text-3xl font-bold text-gray-900 mb-2">Tambah Instruktur Baru</h1>
        <p class="text-gray-600">Tambahkan data instruktur baru untuk layanan konseling dan pendampingan.</p>
    </div>

    @if($errors->any())
        <div class="bg-red-100 border border-red-400 text-red-700 px-4 py-3 rounded relative mb-6" role="alert">
            <ul class="list-disc list-inside">
                @foreach($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif

    <!-- Form -->
    <div class="flex justify-center">
        <div class="bg-white shadow-md rounded-lg p-6 max-w-2xl w-full">
            <form method="POST" action="{{ route('staff.instruktur.store') }}" enctype="multipart/form-data" class="space-y-6">
                @csrf

                <!-- Nama Instruktur -->
                <div>
                    <label for="nama" class="block text-sm font-semibold text-gray-700 mb-2">
                        Nama Instruktur <span class="text-red-500">*</span>
                    </label>
                    <input type="text" 
                           id="nama" 
                           name="nama" 
                           value="{{ old('nama') }}" 
                           class="w-full px-4 py-2 bg-gray-50 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-transparent"
                           placeholder="Masukkan nama instruktur"
                           required 
                           autofocus>
                    @error('nama')
                        <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                    @enderror
                </div>

                <!-- Posisi -->
                <div>
                    <label for="posisi" class="block text-sm font-semibold text-gray-700 mb-2">
                        Posisi <span class="text-red-500">*</span>
                    </label>
                    <input type="text" 
                           id="posisi" 
                           name="posisi" 
                           value="{{ old('posisi') }}" 
                           class="w-full px-4 py-2 bg-gray-50 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-transparent"
                           placeholder="Masukkan posisi/jabatan"
                           required>
                    @error('posisi')
                        <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                    @enderror
                </div>

                <!-- Layanan -->
                <div>
                    <label for="nama_layanan" class="block text-sm font-semibold text-gray-700 mb-2">
                        Layanan <span class="text-red-500">*</span>
                    </label>
                    <select id="nama_layanan" 
                            name="nama_layanan" 
                            class="w-full px-4 py-2 bg-gray-50 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-transparent"
                            required>
                        <option value="" selected disabled>-- Pilih Layanan --</option>
                        @foreach($layanans as $layanan)
                            <option value="{{ $layanan->nama_layanan }}" {{ old('nama_layanan') == $layanan->nama_layanan ? 'selected' : '' }}>
                                {{ $layanan->nama_layanan }}
                            </option>
                        @endforeach
                    </select>
                    @error('nama_layanan')
                        <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                    @enderror
                </div>

                <!-- Tombol Aksi -->
                <div class="flex justify-end gap-4 pt-6 border-t border-gray-200">
                    <a href="{{ route('staff.instruktur.index') }}" 
                       class="bg-gray-300 text-gray-800 px-6 py-2 rounded-lg hover:bg-gray-400 transition duration-200">
                        Batal
                    </a>
                    <button type="submit" 
                            class="bg-blue-600 text-white px-6 py-2 rounded-lg hover:bg-blue-700 transition duration-200 shadow-md">
                        <i class="fas fa-save mr-2"></i>Simpan Instruktur
                    </button>
                </div>
            </form>
        </div>
    </div>
</section>

<script>
// Preview foto yang dipilih
document.getElementById('foto').addEventListener('change', function(e) {
    const file = e.target.files[0];
    if (file) {
        const reader = new FileReader();
        reader.onload = function(e) {
            const preview = document.querySelector('.space-y-1');
            preview.innerHTML = `
                <img src="${e.target.result}" class="mx-auto h-12 w-12 object-cover rounded-full">
                <p class="text-sm text-gray-600">${file.name}</p>
                <p class="text-xs text-gray-500">Klik untuk ganti foto</p>
            `;
        };
        reader.readAsDataURL(file);
    }
});
</script>

@endsection 