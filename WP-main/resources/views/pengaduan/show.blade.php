<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Detail Pengaduan #') }}{{ $pengaduan->id }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <!-- Success Message -->
            @if(session('success'))
                <div class="bg-green-100 border border-green-400 text-green-700 px-4 py-3 rounded relative mb-6" role="alert">
                    <span class="block sm:inline">{{ session('success') }}</span>
                </div>
            @endif

            <!-- Back Button -->
            <div class="mb-6">
                <a href="{{ route('tracking.index') }}" class="inline-flex items-center px-4 py-2 bg-gray-600 border border-transparent rounded-md font-semibold text-xs text-white uppercase tracking-widest hover:bg-gray-700 focus:bg-gray-700 active:bg-gray-900 focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:ring-offset-2 transition ease-in-out duration-150">
                    ← Kembali ke Daftar Pengaduan
                </a>
            </div>

            <!-- Status Card -->
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg mb-6">
                <div class="p-6 text-gray-900">
                    <div class="flex items-center justify-between">
                        <div>
                            <h3 class="text-lg font-semibold text-gray-900">Status Pengaduan</h3>
                            <p class="text-sm text-gray-600">Terakhir diperbarui: {{ $pengaduan->updated_at ? $pengaduan->updated_at->format('d/m/Y H:i') : '-' }}</p>
                        </div>
                        <span class="px-3 py-1 text-sm font-semibold rounded-full 
                            @if($pengaduan->status === 'selesai') bg-green-100 text-green-800
                            @elseif($pengaduan->status === 'ditolak') bg-red-100 text-red-800
                            @elseif($pengaduan->status === 'proses') bg-blue-100 text-blue-800
                            @else bg-yellow-100 text-yellow-800
                            @endif">
                            {{ ucfirst(str_replace('_', ' ', $pengaduan->status ?? 'menunggu')) }}
                        </span>
                    </div>
                </div>
            </div>

            <!-- Informasi Pengaduan -->
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg mb-6">
                <div class="p-6 text-gray-900">
                    <h3 class="text-lg font-semibold mb-4">Informasi Pengaduan</h3>
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                        <div>
                            <p class="text-sm text-gray-600">Nomor Pengaduan</p>
                            <p class="font-medium">#{{ $pengaduan->id }}</p>
                        </div>
                        <div>
                            <p class="text-sm text-gray-600">Tanggal Pengaduan</p>
                            <p class="font-medium">{{ $pengaduan->created_at ? $pengaduan->created_at->format('d/m/Y H:i') : '-' }}</p>
                        </div>
                        <div>
                            <p class="text-sm text-gray-600">Jenis Laporan</p>
                            <p class="font-medium">{{ $pengaduan->jenis_laporan ?? '-' }}</p>
                        </div>
                        <div>
                            <p class="text-sm text-gray-600">Jenis Kasus</p>
                            <p class="font-medium">{{ $pengaduan->jenis_kasus ?? '-' }}</p>
                        </div>
                        <div>
                            <p class="text-sm text-gray-600">Bentuk Kekerasan</p>
                            <p class="font-medium">{{ $pengaduan->bentuk_kekerasan ?? '-' }}</p>
                        </div>
                        <div>
                            <p class="text-sm text-gray-600">Tanggal Kejadian</p>
                            <p class="font-medium">{{ $pengaduan->tanggal_kejadian ? \Carbon\Carbon::parse($pengaduan->tanggal_kejadian)->format('d/m/Y') : '-' }}</p>
                        </div>
                        <div>
                            <p class="text-sm text-gray-600">Tempat Kejadian</p>
                            <p class="font-medium">{{ $pengaduan->tempat_kejadian ?? '-' }}</p>
                        </div>
                        <div>
                            <p class="text-sm text-gray-600">Lokasi</p>
                            <p class="font-medium">{{ $pengaduan->desa ?? '-' }}, {{ $pengaduan->kecamatan ?? '-' }}</p>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Kronologi Kejadian -->
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg mb-6">
                <div class="p-6 text-gray-900">
                    <h3 class="text-lg font-semibold mb-4">Kronologi Kejadian</h3>
                    <div class="bg-gray-50 p-4 rounded-lg">
                        <p class="text-gray-700 whitespace-pre-line">{{ $pengaduan->kronologi ?? 'Kronologi tidak tersedia' }}</p>
                    </div>
                </div>
            </div>

            <!-- Data Pelapor -->
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg mb-6">
                <div class="p-6 text-gray-900">
                    <h3 class="text-lg font-semibold mb-4">Data Pelapor</h3>
                    @if($pengaduan->pelapor)
                        <div class="grid grid-cols-1 md:grid-cols-3 gap-4">
                            <div>
                                <p class="text-sm text-gray-600">Nama Pelapor</p>
                                <p class="font-medium">{{ $pengaduan->pelapor->nama_pelapor ?? '-' }}</p>
                            </div>
                            <div>
                                <p class="text-sm text-gray-600">Email</p>
                                <p class="font-medium">{{ $pengaduan->user->email ?? '-' }}</p>
                            </div>
                            <div>
                                <p class="text-sm text-gray-600">Nomor Telepon</p>
                                <p class="font-medium">{{ $pengaduan->user->no_telepon ?? '-' }}</p>
                            </div>
                            <div class="col-span-3">
                                <p class="text-sm text-gray-600">Alamat</p>
                                <p class="font-medium">
                                    @if($pengaduan->user && $pengaduan->user->alamat)
                                        {{ $pengaduan->user->alamat->desa ?? '' }}, 
                                        {{ $pengaduan->user->alamat->kecamatan ?? '' }}, 
                                        {{ $pengaduan->user->alamat->kota ?? '' }}
                                        RT {{ $pengaduan->user->alamat->RT ?? '' }}/RW {{ $pengaduan->user->alamat->RW ?? '' }}
                                    @else
                                        Alamat tidak tersedia
                                    @endif
                                </p>
                            </div>
                        </div>
                    @else
                        <p class="text-gray-500">Data pelapor tidak tersedia</p>
                    @endif
                </div>
            </div>

            <!-- Data Korban -->
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg mb-6">
                <div class="p-6 text-gray-900">
                    <h3 class="text-lg font-semibold mb-4">Data Korban</h3>
                    @if($pengaduan->korban && $pengaduan->korban->count() > 0)
                        @foreach($pengaduan->korban as $korban)
                            <div class="bg-gray-50 p-4 rounded-lg mb-4">
                                <div class="grid grid-cols-1 md:grid-cols-3 gap-4">
                                    <div>
                                        <p class="text-sm text-gray-600">Nama</p>
                                        <p class="font-medium">{{ $korban->nama ?? '-' }}</p>
                                    </div>
                                    <div>
                                        <p class="text-sm text-gray-600">Jenis Kelamin</p>
                                        <p class="font-medium">{{ $korban->jenis_kelamin ?? '-' }}</p>
                                    </div>
                                    <div>
                                        <p class="text-sm text-gray-600">Usia</p>
                                        <p class="font-medium">{{ $korban->usia ?? '-' }} {{ $korban->usia ? 'tahun' : '' }}</p>
                                    </div>
                                    <div>
                                        <p class="text-sm text-gray-600">Nomor Telepon</p>
                                        <p class="font-medium">{{ $korban->no_telepon ?? '-' }}</p>
                                    </div>
                                    <div>
                                        <p class="text-sm text-gray-600">Status Disabilitas</p>
                                        <p class="font-medium">{{ $korban->disabilitas ?? '-' }}</p>
                                    </div>
                                    <div>
                                        <p class="text-sm text-gray-600">Pendidikan</p>
                                        <p class="font-medium">{{ $korban->pendidikan ?? '-' }}</p>
                                    </div>
                                    <div>
                                        <p class="text-sm text-gray-600">Status Perkawinan</p>
                                        <p class="font-medium">{{ $korban->status_perkawinan ?? '-' }}</p>
                                    </div>
                                    <div>
                                        <p class="text-sm text-gray-600">Pekerjaan</p>
                                        <p class="font-medium">{{ $korban->pekerjaan ?? '-' }}</p>
                                    </div>
                                </div>
                            </div>
                        @endforeach
                    @else
                        <p class="text-gray-500">Data korban tidak tersedia</p>
                    @endif
                </div>
            </div>

            <!-- Data Pelaku -->
            @if($pengaduan->pelaku && $pengaduan->pelaku->count() > 0)
                <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg mb-6">
                    <div class="p-6 text-gray-900">
                        <h3 class="text-lg font-semibold mb-4">Data Pelaku</h3>
                        @foreach($pengaduan->pelaku as $pelaku)
                            <div class="bg-gray-50 p-4 rounded-lg mb-4">
                                <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                                    <div>
                                        <p class="text-sm text-gray-600">Nama</p>
                                        <p class="font-medium">{{ $pelaku->nama ?? '-' }}</p>
                                    </div>
                                    <div>
                                        <p class="text-sm text-gray-600">Jenis Kelamin</p>
                                        <p class="font-medium">{{ $pelaku->jenis_kelamin ?? '-' }}</p>
                                    </div>
                                    <div>
                                        <p class="text-sm text-gray-600">Usia</p>
                                        <p class="font-medium">{{ $pelaku->usia ?? '-' }} {{ $pelaku->usia ? 'tahun' : '' }}</p>
                                    </div>
                                    <div>
                                        <p class="text-sm text-gray-600">Pendidikan</p>
                                        <p class="font-medium">{{ $pelaku->pendidikan ?? '-' }}</p>
                                    </div>
                                    <div>
                                        <p class="text-sm text-gray-600">Pekerjaan</p>
                                        <p class="font-medium">{{ $pelaku->pekerjaan ?? '-' }}</p>
                                    </div>
                                    <div>
                                        <p class="text-sm text-gray-600">Hubungan dengan Korban</p>
                                        <p class="font-medium">{{ $pelaku->hubungan ?? '-' }}</p>
                                    </div>
                                    <div>
                                        <p class="text-sm text-gray-600">Kewarganegaraan</p>
                                        <p class="font-medium">{{ $pelaku->kewarganegaraan ?? '-' }}</p>
                                    </div>
                                </div>
                            </div>
                        @endforeach
                    </div>
                </div>
            @endif

            <!-- Riwayat Perubahan Status -->
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg mb-6">
                <div class="p-6 text-gray-900">
                    <h3 class="text-lg font-semibold mb-4">Riwayat Perubahan Status</h3>
                    <div class="space-y-4">
                        @forelse($pengaduan->historiTracking as $histori)
                            <div class="flex items-start space-x-4 p-4 bg-gray-50 rounded-lg">
                                <div class="flex-shrink-0">
                                    <div class="w-3 h-3 bg-green-500 rounded-full"></div>
                                </div>
                                <div class="flex-1 min-w-0">
                                    <div class="flex items-center justify-between">
                                        <div>
                                            <p class="text-sm font-medium text-gray-900">
                                                @if($histori->status_sebelum)
                                                    {{ ucfirst(str_replace('_', ' ', $histori->status_sebelum)) }} → {{ ucfirst(str_replace('_', ' ', $histori->status_sesudah)) }}
                                                @else
                                                    Status: {{ ucfirst(str_replace('_', ' ', $histori->status_sesudah)) }}
                                                @endif
                                            </p>
                                            @if($histori->changedByUser)
                                                <p class="text-sm text-gray-500">Diubah oleh: {{ $histori->changedByUser->name ?? 'Sistem' }}</p>
                                            @endif
                                            @if($histori->keterangan)
                                                <p class="text-sm text-gray-600 mt-1">{{ $histori->keterangan }}</p>
                                            @endif
                                        </div>
                                        <div class="text-sm text-gray-500">
                                            {{ $histori->created_at ? $histori->created_at->format('d/m/Y H:i') : '-' }}
                                        </div>
                                    </div>
                                </div>
                            </div>
                        @empty
                            <p class="text-gray-500">Belum ada riwayat perubahan status</p>
                        @endforelse
                    </div>
                </div>
            </div>
        </div>
    </div>
</x-app-layout> 