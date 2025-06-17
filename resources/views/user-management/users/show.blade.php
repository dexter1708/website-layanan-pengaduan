<x-app-layout>
    <x-slot name="header">
        <div class="flex justify-between items-center">
            <h2 class="font-semibold text-xl text-gray-800 leading-tight">
                {{ __('Detail Pelapor') }}
            </h2>
            <div class="flex space-x-2">
                <a href="{{ route('users.edit', $user->id) }}" class="bg-indigo-500 hover:bg-indigo-700 text-white font-bold py-2 px-4 rounded">
                    Edit
                </a>
            </div>
        </div>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <!-- Informasi Pelapor -->
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg mb-6">
                <div class="p-6 text-gray-900">
                    <h3 class="text-lg font-semibold mb-4">Informasi Pelapor</h3>
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                        <div>
                            <p class="text-sm text-gray-600">Nama</p>
                            <p class="font-medium">{{ $user->name }}</p>
                        </div>
                        <div>
                            <p class="text-sm text-gray-600">Email</p>
                            <p class="font-medium">{{ $user->email }}</p>
                        </div>
                        <div>
                            <p class="text-sm text-gray-600">NIK</p>
                            <p class="font-medium">{{ $user->nik }}</p>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Alamat -->
            @if($user->alamat)
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg mb-6">
                <div class="p-6 text-gray-900">
                    <h3 class="text-lg font-semibold mb-4">Alamat</h3>
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                        <div>
                            <p class="text-sm text-gray-600">Provinsi</p>
                            <p class="font-medium">{{ $user->alamat->provinsi }}</p>
                        </div>
                        <div>
                            <p class="text-sm text-gray-600">Kota/Kabupaten</p>
                            <p class="font-medium">{{ $user->alamat->kota }}</p>
                        </div>
                        <div>
                            <p class="text-sm text-gray-600">Kecamatan</p>
                            <p class="font-medium">{{ $user->alamat->kecamatan }}</p>
                        </div>
                        <div>
                            <p class="text-sm text-gray-600">Desa/Kelurahan</p>
                            <p class="font-medium">{{ $user->alamat->desa }}</p>
                        </div>
                        <div class="col-span-2">
                            <p class="text-sm text-gray-600">Alamat Lengkap</p>
                            <p class="font-medium">{{ $user->alamat->detail_alamat }}</p>
                        </div>
                    </div>
                </div>
            </div>
            @endif
        </div>
    </div>
</x-app-layout> 