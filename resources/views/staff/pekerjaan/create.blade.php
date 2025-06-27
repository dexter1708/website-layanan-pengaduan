@extends('template.main')
@section('content_template')

<div class="py-12">
    <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
        <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
            <div class="p-6 text-gray-900">
                <!-- Header -->
                <div class="mb-6">
                    <h1 class="text-3xl font-bold text-gray-900 mb-2">
                        Tambah Pekerjaan
                    </h1>
                    <p class="text-gray-600">
                        Tambahkan data pekerjaan baru ke dalam sistem.
                    </p>
                </div>

                <!-- Form -->
                <div class="flex justify-center">
                    <div class="bg-white shadow-md rounded-lg p-6 max-w-xl w-full">
                        <form method="POST" action="{{ route('staff.pekerjaan.store') }}" class="space-y-6">
                            @csrf

                            <div class="mb-4">
                                <label for="pekerjaan" class="block text-sm font-medium text-gray-700 mb-2">Nama Pekerjaan</label>
                                <input type="text" name="pekerjaan" id="pekerjaan" value="{{ old('pekerjaan') }}" 
                                       class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500" 
                                       placeholder="Masukkan nama pekerjaan" required>
                                @error('pekerjaan')
                                    <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                                @enderror
                            </div>

                            <div class="flex items-center justify-end mt-6">
                                <a href="{{ route('staff.pekerjaan.index') }}" class="bg-gray-500 hover:bg-gray-700 text-white font-bold py-2 px-4 rounded mr-2">
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
    </div>
</div>

@endsection 