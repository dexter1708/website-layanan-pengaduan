<x-app-layout>
    <x-slot name="header">
        <div class="flex justify-between items-center">
            <h2 class="font-semibold text-xl text-gray-800 leading-tight">
                {{ __('Edit Jadwal Assessment') }}
            </h2>
            <a href="{{ route('staff.assessment.index') }}" class="bg-gray-500 hover:bg-gray-700 text-white font-bold py-2 px-4 rounded">
                Kembali
            </a>
        </div>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 text-gray-900">
                    <form action="{{ route('staff.assessment.update', $assessment->id) }}" method="POST">
                        @csrf
                        @method('PUT')

                        <div class="mb-4">
                            <x-input-label for="pengaduan_id" :value="__('Pilih Pengaduan')" />
                            <select name="pengaduan_id" id="pengaduan_id" class="block mt-1 w-full border-gray-300 focus:border-indigo-500 focus:ring-indigo-500 rounded-md shadow-sm" required>
                                <option value="">Pilih Pengaduan</option>
                                @foreach($pengaduans as $pengaduan)
                                    @if($pengaduan->korban->isNotEmpty())
                                        <option value="{{ $pengaduan->id }}" 
                                            data-korban-id="{{ $pengaduan->korban->first()->id }}" 
                                            data-korban-nama="{{ $pengaduan->korban->first()->nama }}"
                                            {{ $pengaduan->id == $assessment->pengaduan_id ? 'selected' : '' }}>
                                            {{ $pengaduan->id }} - {{ $pengaduan->korban->first()->nama }}
                                        </option>
                                    @endif
                                @endforeach
                            </select>
                            <x-input-error :messages="$errors->get('pengaduan_id')" class="mt-2" />
                        </div>

                        <input type="hidden" name="korban_id" id="korban_id" value="{{ $assessment->korban_id }}">
                        <input type="hidden" name="nama_korban" id="nama_korban" value="{{ $assessment->nama_korban }}">

                        <div class="mb-4">
                            <x-input-label for="nama_assessor" :value="__('Nama Assessor')" />
                            <x-text-input id="nama_assessor" name="nama_assessor" type="text" class="mt-1 block w-full" :value="old('nama_assessor', $assessment->nama_assessor)" required autofocus />
                            <x-input-error :messages="$errors->get('nama_assessor')" class="mt-2" />
                        </div>

                        <div class="mb-4">
                            <x-input-label for="tanggal_assesment" :value="__('Tanggal Assessment')" />
                            <x-text-input id="tanggal_assesment" name="tanggal_assesment" type="datetime-local" class="mt-1 block w-full" :value="old('tanggal_assesment', $assessment->tanggal_assesment->format('Y-m-d\TH:i'))" required />
                            <x-input-error :messages="$errors->get('tanggal_assesment')" class="mt-2" />
                        </div>

                        <div class="mb-4">
                            <x-input-label for="tempat_assessment" :value="__('Tempat Assessment')" />
                            <x-text-input id="tempat_assessment" name="tempat_assessment" type="text" class="mt-1 block w-full" :value="old('tempat_assessment', $assessment->tempat_assessment)" required />
                            <x-input-error :messages="$errors->get('tempat_assessment')" class="mt-2" />
                        </div>

                        <div class="flex items-center justify-end mt-4">
                            <x-primary-button>
                                {{ __('Update Jadwal') }}
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
            if (selectedOption.value) {
                document.getElementById('korban_id').value = selectedOption.dataset.korbanId;
                document.getElementById('nama_korban').value = selectedOption.dataset.korbanNama;
            } else {
                document.getElementById('korban_id').value = '';
                document.getElementById('nama_korban').value = '';
            }
        });
    </script>
    @endpush
</x-app-layout> 