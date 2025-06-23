@extends('template.main')
@section('content_template')

<div class="py-12">
    <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
        <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
            <div class="p-6 text-gray-900">
                <!-- Header -->
                <div class="mb-6">
                    <h1 class="text-3xl font-bold text-gray-900 mb-2">
                        Tambah Bentuk Kekerasan
                    </h1>
                    <p class="text-gray-600">
                        Tambahkan data bentuk kekerasan baru ke dalam sistem.
                    </p>
                </div>

                <form action="{{ route('staff.bentuk-kekerasan.store') }}" method="POST">
                    @csrf

                    <div class="mb-4">
                        <label for="nama_bentuk_kekerasan" class="block text-sm font-medium text-gray-700 mb-2">Nama Bentuk Kekerasan</label>
                        <input type="text" name="nama_bentuk_kekerasan" id="nama_bentuk_kekerasan" value="{{ old('nama_bentuk_kekerasan') }}" 
                               class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500" 
                               placeholder="Masukkan nama bentuk kekerasan" required>
                        @error('nama_bentuk_kekerasan')
                            <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                        @enderror
                    </div>

                    <div class="flex items-center justify-end mt-6">
                        <a href="{{ route('staff.bentuk-kekerasan.index') }}" class="bg-gray-500 hover:bg-gray-700 text-white font-bold py-2 px-4 rounded mr-2">
                            Batal
                        </a>
                        <button type="submit" class="bg-blue-500 hover:bg-blue-700 text-white font-bold py-2 px-4 rounded">
                            Simpan
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>

@endsection 