<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Dashboard') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 text-gray-900">
                    <h3 class="text-lg font-semibold mb-4">Ringkasan Pengaduan</h3>

                    <div class="grid grid-cols-1 md:grid-cols-3 gap-4">
                        <div class="bg-blue-100 border border-blue-400 text-blue-700 px-4 py-3 rounded relative">
                            <div class="font-bold text-sm">Total Pengaduan</div>
                            <div class="text-2xl">{{ $totalPengaduan }}</div>
                        </div>

                        <!-- Pengaduan Berdasarkan Status -->
                        <div class="bg-yellow-100 border border-yellow-400 text-yellow-700 px-4 py-3 rounded relative md:col-span-2">
                            <div class="font-bold text-sm mb-2">Pengaduan Berdasarkan Status</div>
                            <ul>
                                @forelse($pengaduanByStatus as $status => $count)
                                    <li>{{ ucfirst($status) }}: {{ $count }}</li>
                                @empty
                                    <li>Tidak ada data status pengaduan.</li>
                                @endforelse
                            </ul>
                        </div>
                    </div>

                    <!-- Pengaduan Berdasarkan Bentuk Kekerasan -->
                    <div class="mt-6 bg-green-100 border border-green-400 text-green-700 px-4 py-3 rounded relative">
                         <div class="font-bold text-sm mb-2">Pengaduan Berdasarkan Bentuk Kekerasan</div>
                         <ul>
                             @forelse($pengaduanByBentukKekerasan as $bentuk => $count)
                                 <li>{{ $bentuk ?: 'Tidak Diketahui' }}: {{ $count }}</li>
                             @empty
                                 <li>Tidak ada data bentuk kekerasan.</li>
                             @endforelse
                         </ul>
                    </div>

                    {{-- Di sini nanti bisa ditambahkan grafik atau tabel lain --}}

                </div>
            </div>
        </div>
    </div>
</x-app-layout> 