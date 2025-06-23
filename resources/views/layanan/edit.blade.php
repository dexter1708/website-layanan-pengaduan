@extends('template.main')
@section('content_template')

<section class="bg-white py-6 px-4 sm:px-6 lg:px-8">
    <!-- Breadcrumb -->
    <nav class="text-sm text-gray-600 font-semibold mb-6" aria-label="Breadcrumb">
        <ol class="flex items-center space-x-2">
            <li><a href="{{ url('/staff/dashboard') }}" class="text-blue-600 hover:underline">Dashboard</a></li>
            <li class="text-gray-600">/</li>
            <li><a href="{{ route('staff.layanan.index') }}" class="text-blue-600 hover:underline">Manajemen Layanan</a></li>
            <li class="text-gray-600">/</li>
            <li class="text-gray-500">Edit Layanan</li>
        </ol>
    </nav>

    <!-- Header -->
    <div class="mb-8">
        <h1 class="text-3xl font-bold text-gray-900 mb-2">Edit Layanan</h1>
        <p class="text-gray-600">Perbarui informasi layanan yang sudah ada.</p>
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
    <div class="bg-white shadow-md rounded-lg p-6 max-w-2xl">
        <form method="POST" action="{{ route('staff.layanan.update', $layanan->id) }}" class="space-y-6">
            @csrf
            @method('PUT')

            <!-- Nama Layanan -->
            <div>
                <label for="nama_layanan" class="block text-sm font-semibold text-gray-700 mb-2">
                    Nama Layanan <span class="text-red-500">*</span>
                </label>
                <input type="text" 
                       id="nama_layanan" 
                       name="nama_layanan" 
                       value="{{ old('nama_layanan', $layanan->nama_layanan) }}" 
                       class="w-full px-4 py-2 bg-gray-50 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-transparent"
                       placeholder="Masukkan nama layanan"
                       required 
                       autofocus>
                @error('nama_layanan')
                    <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                @enderror
            </div>

            <!-- Jenis Layanan -->
            <div>
                <label for="jenis_layanan" class="block text-sm font-semibold text-gray-700 mb-2">
                    Jenis Layanan <span class="text-red-500">*</span>
                </label>
                <select id="jenis_layanan" 
                        name="jenis_layanan" 
                        class="w-full px-4 py-2 bg-gray-50 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-transparent"
                        required>
                    <option value="" disabled>-- Pilih Jenis Layanan --</option>
                    <option value="pendampingan" {{ old('jenis_layanan', $layanan->jenis_layanan) == 'pendampingan' ? 'selected' : '' }}>
                        Pendampingan
                    </option>
                    <option value="konseling" {{ old('jenis_layanan', $layanan->jenis_layanan) == 'konseling' ? 'selected' : '' }}>
                        Konseling
                    </option>
                </select>
                @error('jenis_layanan')
                    <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                @enderror
            </div>

            <!-- Tombol Aksi -->
            <div class="flex justify-end gap-4 pt-6 border-t border-gray-200">
                <a href="{{ route('staff.layanan.index') }}" 
                   class="bg-gray-300 text-gray-800 px-6 py-2 rounded-lg hover:bg-gray-400 transition duration-200">
                    Batal
                </a>
                <button type="submit" 
                        class="bg-yellow-600 text-white px-6 py-2 rounded-lg hover:bg-yellow-700 transition duration-200 shadow-md">
                    <i class="fas fa-edit mr-2"></i>Update Layanan
                </button>
            </div>
        </form>
    </div>
</section>

@endsection 