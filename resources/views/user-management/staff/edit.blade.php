@extends('template.main')
@section('content_template')

<section class="bg-white py-6 px-4 sm:px-6 lg:px-8">
    <!-- Breadcrumb -->
    <nav class="text-sm text-gray-600 font-semibold mb-6" aria-label="Breadcrumb">
        <ol class="flex items-center space-x-2">
            <li><a href="{{ url('/') }}" class="text-blue-600 hover:underline">Homepage</a></li>
            <li class="text-gray-600">/</li>
            <li><a href="{{ route('admin.staff.index') }}" class="text-blue-600 hover:underline">Manajemen Staff</a></li>
            <li class="text-gray-600">/</li>
            <li class="text-gray-500">Edit Staff</li>
        </ol>
    </nav>

    <!-- Header Section -->
    <div class="mb-8">
        <h1 class="text-3xl font-bold text-gray-900 mb-2">Edit Staff</h1>
        <p class="text-gray-600">Perbarui informasi akun staff</p>
    </div>

    <!-- Form Card -->
    <div class="bg-white rounded-lg shadow-md p-6">
        <form method="POST" action="{{ route('admin.staff.update', $staff->id) }}" class="space-y-6">
            @csrf
            @method('PUT')

            <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                <!-- Name -->
                <div>
                    <label for="name" class="block font-semibold text-gray-800 mb-2">Nama Lengkap *</label>
                    <input type="text" id="name" name="name" value="{{ old('name', $staff->name) }}" required
                        class="w-full bg-blue-50 text-gray-800 px-4 py-3 border-b border-gray-300 focus:outline-none focus:border-blue-500 rounded-lg">
                    @error('name')
                        <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                    @enderror
                </div>

                <!-- Email -->
                <div>
                    <label for="email" class="block font-semibold text-gray-800 mb-2">Email *</label>
                    <input type="email" id="email" name="email" value="{{ old('email', $staff->email) }}" required
                        class="w-full bg-blue-50 text-gray-800 px-4 py-3 border-b border-gray-300 focus:outline-none focus:border-blue-500 rounded-lg">
                    @error('email')
                        <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                    @enderror
                </div>

                <!-- NIK -->
                <div>
                    <label for="nik" class="block font-semibold text-gray-800 mb-2">NIK *</label>
                    <input type="text" id="nik" name="nik" value="{{ old('nik', $staff->nik) }}" required
                        class="w-full bg-blue-50 text-gray-800 px-4 py-3 border-b border-gray-300 focus:outline-none focus:border-blue-500 rounded-lg">
                    @error('nik')
                        <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                    @enderror
                </div>

                <!-- No Telepon -->
                <div>
                    <label for="no_telepon" class="block font-semibold text-gray-800 mb-2">No. Telepon</label>
                    <input type="text" id="no_telepon" name="no_telepon" value="{{ old('no_telepon', $staff->no_telepon) }}"
                        class="w-full bg-blue-50 text-gray-800 px-4 py-3 border-b border-gray-300 focus:outline-none focus:border-blue-500 rounded-lg">
                    @error('no_telepon')
                        <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                    @enderror
                </div>

                <!-- Password -->
                <div>
                    <label for="password" class="block font-semibold text-gray-800 mb-2">Password Baru</label>
                    <input type="password" id="password" name="password" 
                        placeholder="Kosongkan jika tidak ingin mengubah"
                        class="w-full bg-blue-50 text-gray-800 px-4 py-3 border-b border-gray-300 focus:outline-none focus:border-blue-500 rounded-lg">
                    @error('password')
                        <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                    @enderror
                </div>

                <!-- Confirm Password -->
                <div>
                    <label for="password_confirmation" class="block font-semibold text-gray-800 mb-2">Konfirmasi Password Baru</label>
                    <input type="password" id="password_confirmation" name="password_confirmation"
                        placeholder="Kosongkan jika tidak ingin mengubah"
                        class="w-full bg-blue-50 text-gray-800 px-4 py-3 border-b border-gray-300 focus:outline-none focus:border-blue-500 rounded-lg">
                    @error('password_confirmation')
                        <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                    @enderror
                </div>
            </div>

            <!-- Action Buttons -->
            <div class="flex justify-end space-x-4 pt-6 border-t border-gray-200">
                <a href="{{ route('admin.staff.index') }}" 
                   class="bg-gray-500 hover:bg-gray-600 text-white px-6 py-2 rounded-lg font-semibold transition duration-200">
                    Batal
                </a>
                <button type="submit" 
                        class="bg-blue-600 hover:bg-blue-700 text-white px-6 py-2 rounded-lg font-semibold transition duration-200">
                    Simpan Perubahan
                </button>
            </div>
        </form>
    </div>
</section>

@endsection 