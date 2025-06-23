@extends('template.main')
@section('content_template')

<section class="bg-gray-100 py-8 px-4 sm:px-6 lg:px-8">
    <div class="max-w-2xl mx-auto">
        <!-- Breadcrumb -->
        <nav class="text-sm text-gray-600 font-semibold mb-6" aria-label="Breadcrumb">
            <ol class="flex items-center space-x-2">
                <li><a href="{{ url('/') }}" class="text-blue-600 hover:underline">Homepage</a></li>
                <li class="text-gray-600">/</li>
                <li><a href="{{ route('pengaduan.index') }}" class="text-blue-600 hover:underline">Layanan Pengaduan</a></li>
                <li class="text-gray-600">/</li>
                <li><a href="{{ route('pengaduan.show', $pengaduan->id) }}" class="text-blue-600 hover:underline">Detail</a></li>
                <li class="text-gray-600">/</li>
                <li class="text-gray-500">Update Status</li>
            </ol>
        </nav>

        <div class="bg-white rounded-lg shadow-md">
            <!-- Header -->
            <div class="p-6 border-b border-gray-200">
                <h2 class="text-2xl font-bold text-gray-800">Update Status Pengaduan #{{ $pengaduan->id }}</h2>
                <p class="text-sm text-gray-600 mt-1">Ubah status progres penanganan kasus.</p>
            </div>

            <!-- Form -->
            <form action="{{ route('staff.tracking.update-status', $pengaduan->id) }}" method="POST" class="p-8">
                @csrf
                @method('PUT')

                <!-- Status Dropdown -->
                <div class="mb-6">
                    <label for="status" class="block text-sm font-semibold text-gray-700 mb-2">Status Pengaduan</label>
                    <select id="status" name="status" class="w-full px-4 py-2 bg-gray-50 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-500">
                        <option value="menunggu" {{ $pengaduan->status == 'menunggu' ? 'selected' : '' }}>Menunggu</option>
                        <option value="diproses" {{ $pengaduan->status == 'diproses' ? 'selected' : '' }}>Diproses</option>
                        <option value="selesai" {{ $pengaduan->status == 'selesai' ? 'selected' : '' }}>Selesai</option>
                        <option value="ditolak" {{ $pengaduan->status == 'ditolak' ? 'selected' : '' }}>Ditolak</option>
                    </select>
                    @error('status')
                        <p class="text-red-500 text-xs mt-2">{{ $message }}</p>
                    @enderror
                </div>

                <!-- Keterangan Textarea -->
                <div class="mb-6">
                    <label for="keterangan" class="block text-sm font-semibold text-gray-700 mb-2">Keterangan (Opsional)</label>
                    <textarea id="keterangan" name="keterangan" rows="4" class="w-full px-4 py-2 bg-gray-50 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-500" placeholder="Tambahkan catatan atau keterangan tambahan...">{{ old('keterangan') }}</textarea>
                    @error('keterangan')
                        <p class="text-red-500 text-xs mt-2">{{ $message }}</p>
                    @enderror
                </div>

                <!-- Tombol Aksi -->
                <div class="flex justify-end gap-4">
                    <a href="{{ route('pengaduan.show', $pengaduan->id) }}" class="bg-gray-300 text-gray-800 px-6 py-2 rounded-lg hover:bg-gray-400 transition-colors font-semibold text-sm">
                        Batal
                    </a>
                    <button type="submit" class="bg-blue-600 text-white px-6 py-2 rounded-lg hover:bg-blue-700 transition-colors font-semibold text-sm shadow-md">
                        Update Status
                    </button>
                </div>
            </form>
        </div>
    </div>
</section>

@endsection 