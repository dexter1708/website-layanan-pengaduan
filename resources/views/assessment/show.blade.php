<x-app-layout>
    <x-slot name="header">
        <div class="flex justify-between items-center">
            <h2 class="font-semibold text-xl text-gray-800 leading-tight">
                {{ __('Detail Assessment') }}
            </h2>
            <a href="{{ route('assessment.index') }}" class="bg-gray-500 hover:bg-gray-700 text-white font-bold py-2 px-4 rounded">
                Kembali
            </a>
        </div>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 text-gray-900">
                    @if(session('success'))
                        <div class="bg-green-100 border border-green-400 text-green-700 px-4 py-3 rounded relative mb-4" role="alert">
                            <span class="block sm:inline">{{ session('success') }}</span>
                        </div>
                    @endif

                    <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                        <div>
                            <p class="text-sm text-gray-600">ID Pengaduan</p>
                            <p class="font-medium">{{ $assessment->pengaduan->id }}</p>
                        </div>
                        <div>
                            <p class="text-sm text-gray-600">Nama Korban</p>
                            <p class="font-medium">{{ $assessment->nama_korban }}</p>
                        </div>
                        <div>
                            <p class="text-sm text-gray-600">Nama Assessor</p>
                            <p class="font-medium">{{ $assessment->nama_assessor }}</p>
                        </div>
                        <div>
                            <p class="text-sm text-gray-600">Tanggal Assessment</p>
                            <div class="bg-gray-50 p-4 rounded-lg">
                                {{ $assessment->tanggal_assesment->format('d F Y H:i') }}
                            </div>
                        </div>
                        <div>
                            <p class="text-sm text-gray-600">Tempat Assessment</p>
                            <p class="font-medium">{{ $assessment->tempat_assessment }}</p>
                        </div>
                        <div>
                            <p class="text-sm text-gray-600">Status Konfirmasi</p>
                            <p class="font-medium">
                                @if($assessment->konfirmasi === 'menunggu')
                                    <span class="px-2 inline-flex text-xs leading-5 font-semibold rounded-full bg-yellow-100 text-yellow-800">
                                        Menunggu Konfirmasi
                                    </span>
                                @elseif($assessment->konfirmasi === 'setuju')
                                    <span class="px-2 inline-flex text-xs leading-5 font-semibold rounded-full bg-green-100 text-green-800">
                                        Disetujui
                                    </span>
                                @else
                                    <span class="px-2 inline-flex text-xs leading-5 font-semibold rounded-full bg-red-100 text-red-800">
                                        Ditolak
                                    </span>
                                @endif
                            </p>
                        </div>
                    </div>

                    @if(auth()->user() && auth()->user()->role === 'staff')
                        <div class="mt-6 flex justify-end space-x-4">
                            <a href="{{ route('staff.assessment.edit', $assessment->id) }}" class="bg-yellow-500 hover:bg-yellow-700 text-white font-bold py-2 px-4 rounded">
                                Edit
                            </a>
                            <form action="{{ route('staff.assessment.destroy', $assessment->id) }}" method="POST" class="inline">
                                @csrf
                                @method('DELETE')
                                <button type="submit" class="bg-red-500 hover:bg-red-700 text-white font-bold py-2 px-4 rounded" onclick="return confirm('Apakah Anda yakin ingin menghapus jadwal assessment ini?')">
                                    Hapus
                                </button>
                            </form>
                        </div>
                    @elseif($assessment->konfirmasi === 'menunggu')
                        <div class="mt-6 flex justify-end space-x-4">
                            <form action="{{ route('assessment.update-konfirmasi', $assessment->id) }}" method="POST" class="inline">
                                @csrf
                                @method('PUT')
                                <input type="hidden" name="konfirmasi" value="setuju">
                                <x-primary-button class="bg-green-600 hover:bg-green-700">
                                    {{ __('Setuju') }}
                                </x-primary-button>
                            </form>
                            <form action="{{ route('assessment.update-konfirmasi', $assessment->id) }}" method="POST" class="inline">
                                @csrf
                                @method('PUT')
                                <input type="hidden" name="konfirmasi" value="tolak">
                                <x-danger-button>
                                    {{ __('Tolak') }}
                                </x-danger-button>
                            </form>
                        </div>
                    @endif
                </div>
            </div>
        </div>
    </div>
</x-app-layout> 