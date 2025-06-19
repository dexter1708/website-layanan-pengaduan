<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Edit Instruktur') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 text-gray-900">
                    <form method="POST" action="{{ route('staff.instruktur.update', $instruktur->id) }}" enctype="multipart/form-data" class="space-y-6">
                        @csrf
                        @method('PUT')

                        <!-- Nama Instruktur -->
                        <div>
                            <x-input-label for="nama" :value="__('Nama Instruktur')" />
                            <x-text-input id="nama" 
                                         class="block mt-1 w-full" 
                                         type="text" 
                                         name="nama" 
                                         :value="old('nama', $instruktur->nama)" 
                                         required 
                                         autofocus />
                            <x-input-error class="mt-2" :messages="$errors->get('nama')" />
                        </div>

                        <!-- Posisi -->
                        <div>
                            <x-input-label for="posisi" :value="__('Posisi')" />
                            <x-text-input id="posisi" 
                                         class="block mt-1 w-full" 
                                         type="text" 
                                         name="posisi" 
                                         :value="old('posisi', $instruktur->posisi)" 
                                         required />
                            <x-input-error class="mt-2" :messages="$errors->get('posisi')" />
                        </div>

                        <!-- Layanan -->
                        <div>
                            <x-input-label for="nama_layanan" :value="__('Layanan')" />
                            <select id="nama_layanan" name="nama_layanan" class="mt-1 block w-full border-gray-300 focus:border-indigo-500 focus:ring-indigo-500 rounded-md shadow-sm" required>
                                <option value="">Pilih Layanan</option>
                                @foreach($layanans as $layanan)
                                    <option value="{{ $layanan->nama_layanan }}" 
                                            {{ old('nama_layanan', $instruktur->nama_layanan) == $layanan->nama_layanan ? 'selected' : '' }}>
                                        {{ $layanan->nama_layanan }}
                                    </option>
                                @endforeach
                            </select>
                            <x-input-error class="mt-2" :messages="$errors->get('nama_layanan')" />
                        </div>

                        <!-- Foto Saat Ini -->
                        @if($instruktur->foto)
                        <div>
                            <x-input-label :value="__('Foto Saat Ini')" />
                            <div class="mt-2">
                                <img src="{{ asset('storage/instruktur/' . $instruktur->foto) }}" 
                                     alt="Foto {{ $instruktur->nama }}" 
                                     class="h-32 w-32 rounded-lg object-cover">
                            </div>
                        </div>
                        @endif

                        <!-- Foto Baru -->
                        <div>
                            <x-input-label for="foto" :value="__('Foto Baru (Opsional)')" />
                            <input id="foto" 
                                   class="mt-1 block w-full border-gray-300 focus:border-indigo-500 focus:ring-indigo-500 rounded-md shadow-sm" 
                                   type="file" 
                                   name="foto" 
                                   accept="image/*" />
                            <p class="mt-1 text-sm text-gray-500">Format: JPEG, PNG, JPG, GIF. Maksimal 2MB. Biarkan kosong untuk mempertahankan foto saat ini.</p>
                            <x-input-error class="mt-2" :messages="$errors->get('foto')" />
                        </div>

                        <div class="flex items-center gap-4">
                            <x-primary-button>{{ __('Update') }}</x-primary-button>
                            <a href="{{ route('staff.instruktur.index') }}" class="bg-gray-500 hover:bg-gray-700 text-white font-bold py-2 px-4 rounded">
                                Batal
                            </a>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</x-app-layout> 