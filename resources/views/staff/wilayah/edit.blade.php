<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Edit Wilayah') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 text-gray-900">
                    @if (session('error'))
                        <div class="bg-red-100 border border-red-400 text-red-700 px-4 py-3 rounded relative mb-4" role="alert">
                            <span class="block sm:inline">{{ session('error') }}</span>
                        </div>
                    @endif

                    <!-- Informasi Wilayah yang Diedit -->
                    <div class="mb-6 p-4 bg-blue-50 border border-blue-200 rounded-lg">
                        <h3 class="text-lg font-semibold text-blue-800 mb-2">Informasi Wilayah:</h3>
                        @if($tipe === 'kota')
                            <p class="text-blue-700">Anda sedang mengedit <strong>Kota</strong></p>
                        @elseif($tipe === 'kecamatan')
                            <p class="text-blue-700">Anda sedang mengedit <strong>Kecamatan</strong> di Kota: <strong>{{ $wilayah->kota_nama ?? 'N/A' }}</strong></p>
                        @elseif($tipe === 'desa')
                            <p class="text-blue-700">Anda sedang mengedit <strong>Desa</strong> di Kecamatan: <strong>{{ $wilayah->kecamatan_nama ?? 'N/A' }}</strong>, Kota: <strong>{{ $wilayah->kota_nama ?? 'N/A' }}</strong></p>
                        @else
                            <p class="text-red-700">Tipe wilayah tidak valid</p>
                        @endif
                    </div>

                    @if($tipe && in_array($tipe, ['kota', 'kecamatan', 'desa']))
                    <form action="{{ route('staff.wilayah.update', $id) }}" method="POST">
                        @csrf
                        @method('PUT')

                        @if($tipe === 'kota')
                            <div class="mb-4">
                                <label for="nama_kota" class="block text-sm font-medium text-gray-700">Nama Kota</label>
                                <input type="text" name="nama" id="nama_kota" value="{{ old('nama', $wilayah->kota_nama ?? '') }}" class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500" required>
                                @error('nama')
                                    <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                                @enderror
                            </div>
                        @endif

                        @if($tipe === 'kecamatan')
                            <div class="mb-4">
                                <label for="nama_kecamatan" class="block text-sm font-medium text-gray-700">Nama Kecamatan</label>
                                <input type="text" name="nama" id="nama_kecamatan" value="{{ old('nama', $wilayah->kecamatan_nama ?? '') }}" class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500" required>
                                @error('nama')
                                    <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                                @enderror
                            </div>
                        @endif

                        @if($tipe === 'desa')
                            <div class="mb-4">
                                <label for="nama_desa" class="block text-sm font-medium text-gray-700">Nama Desa</label>
                                <input type="text" name="nama" id="nama_desa" value="{{ old('nama', $wilayah->desa_nama ?? '') }}" class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500" required>
                                @error('nama')
                                    <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                                @enderror
                            </div>
                        @endif

                        <div class="flex items-center justify-end mt-4">
                            <a href="{{ route('staff.wilayah.index') }}" class="bg-gray-500 hover:bg-gray-700 text-white font-bold py-2 px-4 rounded mr-2">
                                Batal
                            </a>
                            <button type="submit" class="bg-blue-500 hover:bg-blue-700 text-white font-bold py-2 px-4 rounded">
                                Update
                            </button>
                        </div>
                    </form>
                    @else
                        <div class="bg-red-100 border border-red-400 text-red-700 px-4 py-3 rounded relative mb-4" role="alert">
                            <span class="block sm:inline">Tipe wilayah tidak valid atau tidak ditemukan.</span>
                        </div>
                        <div class="flex items-center justify-end mt-4">
                            <a href="{{ route('staff.wilayah.index') }}" class="bg-gray-500 hover:bg-gray-700 text-white font-bold py-2 px-4 rounded">
                                Kembali
                            </a>
                        </div>
                    @endif
                </div>
            </div>
        </div>
    </div>
</x-app-layout> 