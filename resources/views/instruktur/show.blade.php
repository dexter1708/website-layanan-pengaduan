<x-app-layout>
    <x-slot name="header">
        <div class="flex justify-between items-center">
            <h2 class="font-semibold text-xl text-gray-800 leading-tight">
                {{ __('Detail Instruktur') }}
            </h2>
            <div class="flex space-x-2">
                <a href="{{ route('staff.instruktur.edit', $instruktur->id) }}" class="bg-yellow-500 hover:bg-yellow-700 text-white font-bold py-2 px-4 rounded">
                    Edit
                </a>
                <a href="{{ route('staff.instruktur.index') }}" class="bg-gray-500 hover:bg-gray-700 text-white font-bold py-2 px-4 rounded">
                    Kembali
                </a>
            </div>
        </div>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 text-gray-900">
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                        <!-- Foto -->
                        <div class="flex justify-center">
                            @if($instruktur->foto)
                                <img src="{{ asset('storage/instruktur/' . $instruktur->foto) }}" 
                                     alt="Foto {{ $instruktur->nama }}" 
                                     class="h-64 w-64 rounded-lg object-cover shadow-lg">
                            @else
                                <div class="h-64 w-64 rounded-lg bg-gray-300 flex items-center justify-center shadow-lg">
                                    <span class="text-gray-600 text-4xl font-medium">
                                        {{ strtoupper(substr($instruktur->nama, 0, 2)) }}
                                    </span>
                                </div>
                            @endif
                        </div>

                        <!-- Informasi -->
                        <div class="space-y-4">
                            <div>
                                <h3 class="text-lg font-semibold text-gray-900 mb-4">Informasi Instruktur</h3>
                                
                                <div class="space-y-3">
                                    <div>
                                        <p class="text-sm text-gray-600">Nama</p>
                                        <p class="font-medium text-gray-900">{{ $instruktur->nama }}</p>
                                    </div>
                                    
                                    <div>
                                        <p class="text-sm text-gray-600">Posisi</p>
                                        <p class="font-medium text-gray-900">{{ $instruktur->posisi }}</p>
                                    </div>
                                    
                                    <div>
                                        <p class="text-sm text-gray-600">Layanan</p>
                                        <p class="font-medium text-gray-900">{{ $instruktur->nama_layanan }}</p>
                                    </div>
                                    
                                    <div>
                                        <p class="text-sm text-gray-600">Tanggal Dibuat</p>
                                        <p class="font-medium text-gray-900">{{ $instruktur->created_at->format('d M Y H:i') }}</p>
                                    </div>
                                    
                                    <div>
                                        <p class="text-sm text-gray-600">Terakhir Diupdate</p>
                                        <p class="font-medium text-gray-900">{{ $instruktur->updated_at->format('d M Y H:i') }}</p>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</x-app-layout> 