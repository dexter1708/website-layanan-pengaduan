<x-app-layout>
    <x-slot name="header">
        <div class="flex justify-between items-center">
            <h2 class="font-semibold text-xl text-gray-800 leading-tight">
                {{ __('Detail Layanan') }}
            </h2>
            <div class="flex space-x-2">
                <a href="{{ route('staff.layanan.edit', $layanan->id) }}" class="bg-yellow-500 hover:bg-yellow-700 text-white font-bold py-2 px-4 rounded">
                    Edit
                </a>
                <a href="{{ route('staff.layanan.index') }}" class="bg-gray-500 hover:bg-gray-700 text-white font-bold py-2 px-4 rounded">
                    Kembali
                </a>
            </div>
        </div>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 text-gray-900">
                    <div class="space-y-6">
                        <div>
                            <h3 class="text-lg font-semibold text-gray-900 mb-4">Informasi Layanan</h3>
                            
                            <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                                <div>
                                    <p class="text-sm text-gray-600">Nama Layanan</p>
                                    <p class="font-medium text-gray-900">{{ $layanan->nama_layanan }}</p>
                                </div>
                                
                                <div>
                                    <p class="text-sm text-gray-600">Jenis Layanan</p>
                                    <span class="px-2 inline-flex text-xs leading-5 font-semibold rounded-full 
                                        @if($layanan->jenis_layanan === 'pendampingan') bg-blue-100 text-blue-800
                                        @else bg-green-100 text-green-800
                                        @endif">
                                        {{ ucfirst($layanan->jenis_layanan) }}
                                    </span>
                                </div>
                                
                                <div>
                                    <p class="text-sm text-gray-600">Tanggal Dibuat</p>
                                    <p class="font-medium text-gray-900">{{ $layanan->created_at->format('d M Y H:i') }}</p>
                                </div>
                                
                                <div>
                                    <p class="text-sm text-gray-600">Terakhir Diupdate</p>
                                    <p class="font-medium text-gray-900">{{ $layanan->updated_at->format('d M Y H:i') }}</p>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</x-app-layout> 