<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Edit Layanan') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 text-gray-900">
                    <form method="POST" action="{{ route('staff.layanan.update', $layanan->id) }}" class="space-y-6">
                        @csrf
                        @method('PUT')

                        <!-- Nama Layanan -->
                        <div>
                            <x-input-label for="nama_layanan" :value="__('Nama Layanan')" />
                            <x-text-input id="nama_layanan" 
                                         class="block mt-1 w-full" 
                                         type="text" 
                                         name="nama_layanan" 
                                         :value="old('nama_layanan', $layanan->nama_layanan)" 
                                         required 
                                         autofocus />
                            <x-input-error class="mt-2" :messages="$errors->get('nama_layanan')" />
                        </div>

                        <!-- Jenis Layanan -->
                        <div>
                            <x-input-label for="jenis_layanan" :value="__('Jenis Layanan')" />
                            <select id="jenis_layanan" name="jenis_layanan" class="mt-1 block w-full border-gray-300 focus:border-indigo-500 focus:ring-indigo-500 rounded-md shadow-sm" required>
                                <option value="">Pilih Jenis Layanan</option>
                                <option value="pendampingan" {{ old('jenis_layanan', $layanan->jenis_layanan) == 'pendampingan' ? 'selected' : '' }}>
                                    Pendampingan
                                </option>
                                <option value="konseling" {{ old('jenis_layanan', $layanan->jenis_layanan) == 'konseling' ? 'selected' : '' }}>
                                    Konseling
                                </option>
                            </select>
                            <x-input-error class="mt-2" :messages="$errors->get('jenis_layanan')" />
                        </div>

                        <!-- Deskripsi -->
                        <!-- Removed as per user's request -->

                        <div class="flex items-center gap-4">
                            <x-primary-button>{{ __('Update') }}</x-primary-button>
                            <a href="{{ route('staff.layanan.index') }}" class="bg-gray-500 hover:bg-gray-700 text-white font-bold py-2 px-4 rounded">
                                Batal
                            </a>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</x-app-layout> 