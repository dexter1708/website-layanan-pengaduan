<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Tambah Instruktur') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 text-gray-900">
                    <form method="POST" action="{{ route('staff.instruktur.store') }}" enctype="multipart/form-data" class="space-y-6">
                        @csrf

                        <!-- Nama Instruktur -->
                        <div>
                            <x-input-label for="nama" :value="__('Nama Instruktur')" />
                            <x-text-input id="nama" 
                                         class="block mt-1 w-full" 
                                         type="text" 
                                         name="nama" 
                                         :value="old('nama')" 
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
                                         :value="old('posisi')" 
                                         required />
                            <x-input-error class="mt-2" :messages="$errors->get('posisi')" />
                        </div>

                        <!-- Layanan -->
                        <div>
                            <x-input-label for="nama_layanan" :value="__('Layanan')" />
                            <select id="nama_layanan" name="nama_layanan" class="mt-1 block w-full border-gray-300 focus:border-indigo-500 focus:ring-indigo-500 rounded-md shadow-sm" required>
                                <option value="">Pilih Layanan</option>
                                @foreach($layanans as $layanan)
                                    <option value="{{ $layanan->nama_layanan }}" {{ old('nama_layanan') == $layanan->nama_layanan ? 'selected' : '' }}>
                                        {{ $layanan->nama_layanan }}
                                    </option>
                                @endforeach
                            </select>
                            <x-input-error class="mt-2" :messages="$errors->get('nama_layanan')" />
                        </div>

                        <!-- Foto -->
                        <div>
                            <x-input-label for="foto" :value="__('Foto (Opsional)')" />
                            <input id="foto" 
                                   class="mt-1 block w-full border-gray-300 focus:border-indigo-500 focus:ring-indigo-500 rounded-md shadow-sm" 
                                   type="file" 
                                   name="foto" 
                                   accept="image/*" />
                            <p class="mt-1 text-sm text-gray-500">Format: JPEG, PNG, JPG, GIF. Maksimal 2MB.</p>
                            <x-input-error class="mt-2" :messages="$errors->get('foto')" />
                        </div>

                        <div class="flex items-center gap-4">
                            <x-primary-button>{{ __('Simpan') }}</x-primary-button>
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