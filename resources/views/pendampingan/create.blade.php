<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Buat Jadwal Pendampingan') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 text-gray-900">
                    <form method="POST" action="{{ route('staff.pendampingan.store') }}" class="space-y-6">
                        @csrf

                        <!-- Pengaduan -->
                        <div>
                            <x-input-label for="pengaduan_id" :value="__('Pilih Pengaduan')" />
                            <select id="pengaduan_id" name="pengaduan_id" class="mt-1 block w-full border-gray-300 focus:border-indigo-500 focus:ring-indigo-500 rounded-md shadow-sm" required>
                                <option value="">Pilih Pengaduan</option>
                                @foreach($pengaduans as $pengaduan)
                                    @if($pengaduan->korban->isNotEmpty())
                                        <option value="{{ $pengaduan->id }}" data-korban-id="{{ $pengaduan->korban->first()->id }}" data-korban-nama="{{ $pengaduan->korban->first()->nama }}">
                                            {{ $pengaduan->id }} - {{ $pengaduan->korban->first()->nama }}
                                        </option>
                                    @endif
                                @endforeach
                            </select>
                            <x-input-error :messages="$errors->get('pengaduan_id')" class="mt-2" />
                        </div>

                        <!-- Hidden Korban ID -->
                        <input type="hidden" name="korban_id" id="korban_id">

                        <!-- Nama Pendamping -->
                        <div>
                            <x-input-label for="nama_pendamping" :value="__('Nama Pendamping')" />
                            <x-text-input id="nama_pendamping" class="block mt-1 w-full" type="text" name="nama_pendamping" :value="old('nama_pendamping')" required />
                            <x-input-error :messages="$errors->get('nama_pendamping')" class="mt-2" />
                        </div>

                        <!-- Jadwal Pendampingan -->
                        <div>
                            <x-input-label for="tanggal_pendampingan" :value="__('Jadwal Pendampingan')" />
                            <x-text-input id="tanggal_pendampingan" class="block mt-1 w-full" type="datetime-local" name="tanggal_pendampingan" :value="old('tanggal_pendampingan')" required />
                            <x-input-error :messages="$errors->get('tanggal_pendampingan')" class="mt-2" />
                        </div>

                        <!-- Tempat Pendampingan -->
                        <div>
                            <x-input-label for="tempat_pendampingan" :value="__('Tempat Pendampingan')" />
                            <x-text-input id="tempat_pendampingan" class="block mt-1 w-full" type="text" name="tempat_pendampingan" :value="old('tempat_pendampingan')" required />
                            <x-input-error :messages="$errors->get('tempat_pendampingan')" class="mt-2" />
                        </div>

                        <div class="flex items-center justify-end mt-4">
                            <x-secondary-button onclick="window.history.back()" class="mr-3">
                                {{ __('Batal') }}
                            </x-secondary-button>
                            <x-primary-button>
                                {{ __('Buat Jadwal') }}
                            </x-primary-button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>

    @push('scripts')
    <script>
        document.getElementById('pengaduan_id').addEventListener('change', function() {
            const selectedOption = this.options[this.selectedIndex];
            document.getElementById('korban_id').value = selectedOption.dataset.korbanId;
        });
    </script>
    @endpush
</x-app-layout> 