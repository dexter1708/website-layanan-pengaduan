@extends('template.main')
@section('content_template')
    <style>
        #btnBuatpendamping:disabled {
            background-color: #9ca3af;
            /* abu-abu */
            cursor: not-allowed;
            /* hapus efek hover supaya gak berubah warna */
        }

        #btnBuatpendamping:disabled:hover {
            background-color: #9ca3af;
        }
    </style>
    <section class="bg-white py-6 px-4 sm:px-6 lg:px-8">
        <!-- Breadcrumb dan Tombol dalam 1 baris -->
        <div class="flex flex-col sm:flex-row sm:items-center sm:justify-between mb-10 space-y-3 sm:space-y-0">
            <!-- Breadcrumb -->
            <nav class="text-sm text-gray-600 font-semibold" aria-label="Breadcrumb">
                <ol class="list-none flex flex-wrap items-center space-x-2">
                    <li>
                        <a href="{{ url('/') }}" class="hover:underline text-blue-600 font-semibold">Homepage</a>
                    </li>
                    <li class="text-gray-600 select-none font-semibold">/</li>
                    <li>
                        <a href="#" class="hover:underline text-blue-600 font-semibold">Layanan</a>
                    </li>
                    <li class="text-gray-600 select-none font-semibold">/</li>
                    <li class="text-gray-500 font-semibold">Pendampingan </li>
                </ol>
            </nav>


            <!-- Tombol -->
            <button id="btnBuatpendamping" onclick="tampilkanFormPendamping()"
                class="bg-blue-500 text-white text-sm font-medium py-2 px-4 rounded hover:bg-blue-600 transition">
                + Ajukan Jadwal
            </button>
        </div>

        <!-- Konten Kosong -->
        @if (true)
    <section class="mt-10 px-4 sm:px-6 lg:px-8" id="index-pendamping-kosong">
  <h3 class="font-bold text-gray-800 text-lg mb-6">Layanan Pendampingan Korban</h3>

  <!-- Data 1: Konfirmasi -->
  <div class="bg-white relative p-4 border-t border-gray-300">
    <!-- Tombol container: absolute di md ke atas, block di mobile -->
    <div class="absolute md:top-4 md:right-4 md:flex md:gap-2 right-0 top-0 w-full md:w-auto bg-white md:bg-transparent p-4 md:p-0 flex justify-center gap-2">
      <button
        class="bg-gray-600 text-white text-sm font-semibold px-3 py-1 rounded hover:bg-gray-700"
        onclick="kembaliKeKontenPenjadwalanMasuk();">Penjadwalan Masuk</button>
      <button
        class="bg-blue-500 text-white text-sm font-semibold px-3 py-1 rounded hover:bg-blue-600">Konfirmasi</button>
    </div>

    <div class="grid grid-cols-1 md:grid-cols-2 gap-y-6 gap-x-10 mt-12 md:mt-4">
      <div>
        <label class="block font-semibold text-gray-800 mb-1">Jenis Pendampingan</label>
        <p class="text-gray-700">Pendampingan Layanan Kesehatan</p>
      </div>
      <div>
        <label class="block font-semibold text-gray-800 mb-1">Catatan</label>
        <p class="text-gray-700">-</p>
      </div>
      <div>
        <label class="block font-semibold text-gray-800 mb-1">Tanggal Pendampingan</label>
        <p class="text-gray-700">15 - 02 - 2025</p>
      </div>
      <div>
        <label class="block font-semibold text-gray-800 mb-1">Waktu Pendampingan</label>
        <p class="text-gray-700">09 : 00</p>
      </div>
    </div>
  </div>

  <!-- Data 2: Diproses -->
  <div class="bg-white relative p-4 border-t border-gray-300">
    <!-- Badge container: absolute di md ke atas, block di mobile -->
    <div
      class="absolute md:top-4 md:right-4 right-0 top-0 w-full md:w-auto bg-white md:bg-transparent p-4 md:p-0 flex justify-center md:justify-end">
      <span
        class="bg-yellow-400 text-white text-sm font-semibold px-3 py-1 rounded inline-block whitespace-nowrap">Penjadwalan Diproses</span>
    </div>

    <div class="grid grid-cols-1 md:grid-cols-2 gap-y-6 gap-x-10 mt-12 md:mt-4">
      <div>
        <label class="block font-semibold text-gray-800 mb-1">Jenis Pendampingan</label>
        <p class="text-gray-700">Pendampingan Layanan Kesehatan</p>
      </div>
      <div>
        <label class="block font-semibold text-gray-800 mb-1">Catatan</label>
        <p class="text-gray-700">-</p>
      </div>
      <div>
        <label class="block font-semibold text-gray-800 mb-1">Tanggal Pendampingan</label>
        <p class="text-gray-700">15 - 02 - 2025</p>
      </div>
      <div>
        <label class="block font-semibold text-gray-800 mb-1">Waktu Pendampingan</label>
        <p class="text-gray-700">09 : 00</p>
      </div>
    </div>
  </div>

  <!-- Data 3: Berhasil -->
  <div class="bg-white relative p-4 border-t border-gray-300">
    <div
      class="absolute md:top-4 md:right-4 right-0 top-0 w-full md:w-auto bg-white md:bg-transparent p-4 md:p-0 flex justify-center md:justify-end">
      <span
        class="bg-green-500 text-white text-sm font-semibold px-3 py-1 rounded inline-block whitespace-nowrap">Penjadwalan Berhasil</span>
    </div>

    <div class="grid grid-cols-1 md:grid-cols-2 gap-y-6 gap-x-10 mt-12 md:mt-4">
      <div>
        <label class="block font-semibold text-gray-800 mb-1">Jenis Pendampingan</label>
        <p class="text-gray-700">Pendampingan Psikologis</p>
      </div>
      <div>
        <label class="block font-semibold text-gray-800 mb-1">Catatan</label>
        <p class="text-gray-700">Dilakukan secara daring.</p>
      </div>
      <div>
        <label class="block font-semibold text-gray-800 mb-1">Tanggal Pendampingan</label>
        <p class="text-gray-700">10 - 02 - 2025</p>
      </div>
      <div>
        <label class="block font-semibold text-gray-800 mb-1">Waktu Pendampingan</label>
        <p class="text-gray-700">14 : 00</p>
      </div>
    </div>
  </div>

  <!-- Data 4: Gagal -->
  <div class="bg-white relative p-4 border-t border-gray-300">
    <div
      class="absolute md:top-4 md:right-4 right-0 top-0 w-full md:w-auto bg-white md:bg-transparent p-4 md:p-0 flex justify-center md:justify-end">
      <span
        class="bg-red-500 text-white text-sm font-semibold px-3 py-1 rounded inline-block whitespace-nowrap">Penjadwalan Gagal</span>
    </div>

    <div class="grid grid-cols-1 md:grid-cols-2 gap-y-6 gap-x-10 mt-12 md:mt-4">
      <div>
        <label class="block font-semibold text-gray-800 mb-1">Jenis Pendampingan</label>
        <p class="text-gray-700">Pendampingan Hukum</p>
      </div>
      <div>
        <label class="block font-semibold text-gray-800 mb-1">Catatan</label>
        <p class="text-gray-700">Pelapor tidak hadir.</p>
      </div>
      <div>
        <label class="block font-semibold text-gray-800 mb-1">Tanggal Pendampingan</label>
        <p class="text-gray-700">12 - 02 - 2025</p>
      </div>
      <div>
        <label class="block font-semibold text-gray-800 mb-1">Waktu Pendampingan</label>
        <p class="text-gray-700">10 : 00</p>
      </div>
    </div>
  </div>
</section>


        @else
            <div id="index-pendamping-kosong" class="text-center py-16 text-gray-500 max-w-xl mx-auto">
                <p class="text-2xl font-semibold mb-2">Tidak Ada Jadwal Pendampingan</p>
                <p class="text-base sm:text-lg">Anda belum mendapatkan penjadwalan pendampingan.</p>
            </div>
        @endif
        <section id="show-penjadwalan-masuk" class=" hidden bg-white py-6 px-4 sm:px-6 lg:px-8">
            <div class="max-w-4xl mx-auto bg-white p-6 rounded shadow">
                <h3 class="font-bold text-gray-800 text-lg mb-6">Layanan Pendampingan Korban</h3>

                <div class="grid grid-cols-1 md:grid-cols-2 gap-y-6 gap-x-10 mb-8">
                    <!-- Jenis Pendampingan -->
                    <div>
                        <label class="block font-semibold text-gray-800 mb-1">Jenis Pendampingan</label>
                        <p class="text-gray-700">Pendampingan Layanan Kesehatan</p>
                    </div>

                    <!-- Catatan -->
                    <div>
                        <label class="block font-semibold text-gray-800 mb-1">Catatan</label>
                        <p class="text-gray-700">-</p>
                    </div>

                    <!-- Tanggal Pendampingan -->
                    <div>
                        <label class="block font-semibold text-gray-800 mb-1">Tanggal Pendampingan</label>
                        <p class="text-gray-700">15 - 02 - 2025</p>
                    </div>

                    <!-- Waktu Pendampingan -->
                    <div>
                        <label class="block font-semibold text-gray-800 mb-1">Waktu Pendampingan</label>
                        <p class="text-gray-700">09 : 00</p>
                    </div>
                </div>

                <hr class="mb-8">

                <!-- Tombol Konfirmasi -->
                <div class="flex justify-center gap-4">
                    <button class="bg-blue-600 hover:bg-blue-700 text-white font-semibold px-6 py-2 rounded transition"
                        onclick="kembaliKeKontenPendampingan();">
                        Konfirmasi Kehadiran
                    </button>
                    <button class="bg-blue-400 text-white px-6 py-2 rounded hover:bg-blue-500 transition"
                        onclick="kembaliKeKontenPendampingan();">
                        Berhalangan Hadir
                    </button>
                </div>
            </div>
        </section>

    </section>
    <section id="form-layanan-pendampingan" class="hidden bg-white py-6 px-4 sm:px-6 lg:px-8">
        <main class="max-w-6xl mx-auto p-6 bg-white rounded-md">
            <div class="inline-block bg-blue-400 text-white text-sm font-medium px-6 py-2 rounded-tl-lg rounded-tr-lg mb-6">
                Layanan Pendampingan Korban
            </div>

            <form class="space-y-10">
                <section>
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                        <!-- Jenis Pendampingan -->
                        <div>
                            <label class="block font-semibold text-gray-800 mb-1">Jenis Pendampingan *</label>
                            <select
                                class="w-full bg-blue-50 text-gray-800 px-4 py-2 border-b border-gray-300 focus:outline-none">
                                <option selected disabled hidden>Jenis Pendampingan</option>
                                <option value="hukum">Pendampingan Hukum</option>
                                <option value="psikologis">Pendampingan Psikologis</option>
                                <option value="medis">Pendampingan Medis</option>
                            </select>
                        </div>

                        <!-- Catatan -->
                        <div>
                            <label class="block font-semibold text-gray-800 mb-1">Catatan</label>
                            <input type="text" placeholder="Catatan"
                                class="w-full bg-blue-50 text-gray-800 px-4 py-2 border-b border-gray-300 focus:outline-none" />
                        </div>

                        <!-- Tanggal Pendampingan -->
                        <div>
                            <label class="block font-semibold text-gray-800 mb-1">Tanggal Pendampingan *</label>
                            <input type="date"
                                class="w-full bg-blue-50 text-gray-800 px-4 py-2 border-b border-gray-300 focus:outline-none" />
                        </div>

                        <!-- Waktu Pendampingan -->
                        <div>
                            <label class="block font-semibold text-gray-800 mb-1">Waktu Pendampingan *</label>
                            <select
                                class="w-full bg-blue-50 text-gray-800 px-4 py-2 border-b border-gray-300 focus:outline-none">
                                <option selected disabled hidden>- - : - -</option>
                                @for ($i = 8; $i <= 17; $i++)
                                    @php
                                        $formattedTime = sprintf('%02d:00', $i);
                                    @endphp
                                    <option value="{{ $formattedTime }}">{{ $formattedTime }}</option>
                                @endfor
                            </select>
                        </div>

                    </div>
                </section>

                <!-- Tombol Aksi -->
                <div class="flex justify-center mt-6 gap-4">
                    <button type="button" onclick="kembaliKeKontenPendampingKosong()"
                        class="bg-blue-400 text-white px-6 py-2 rounded hover:bg-blue-500 transition">Batal</button>
                    <button type="submit"
                        class="bg-blue-500 text-white px-6 py-2 rounded hover:bg-blue-600 transition">Simpan</button>
                </div>
            </form>
        </main>
    </section>

    <script>
        function tampilkanFormPendamping() {
            document.getElementById('index-pendamping-kosong').classList.add('hidden');
            document.getElementById('form-layanan-pendampingan').classList.remove('hidden');
            const btn = document.getElementById('btnBuatpendamping');
            btn.disabled = true; // disable tombol sebenarnya
        }


        function kembaliKeKontenPendampingKosong() {
            document.getElementById('form-layanan-pendampingan').classList.add('hidden');
            document.getElementById('index-pendamping-kosong').classList.remove('hidden');
            const btn = document.getElementById('btnBuatpendamping');
            btn.disabled = false; // enable tombol kembali
        }

        function kembaliKeKontenPenjadwalanMasuk() {
            document.getElementById('form-layanan-pendampingan').classList.add('hidden');
            document.getElementById('index-pendamping-kosong').classList.add('hidden');
            document.getElementById('show-penjadwalan-masuk').classList.remove('hidden');
            const btn = document.getElementById('btnBuatpendamping');
            btn.disabled = true; // enable tombol kembali
        }

        function kembaliKeKontenPenjadwalanMasuk() {
            document.getElementById('form-layanan-pendampingan').classList.add('hidden');
            document.getElementById('index-pendamping-kosong').classList.add('hidden');
            document.getElementById('show-penjadwalan-masuk').classList.remove('hidden');
            const btn = document.getElementById('btnBuatpendamping');
            btn.disabled = true; // enable tombol kembali
        }

        function kembaliKeKontenPendampingan() {
            document.getElementById('index-pendamping-kosong').classList.remove('hidden');
            document.getElementById('show-penjadwalan-masuk').classList.add('hidden');
            const btn = document.getElementById('btnBuatpendamping');
            btn.disabled = false; // enable tombol kembali
        }
    </script>
@endsection




{{-- <x-app-layout>
    <x-slot name="header">
        <div class="flex justify-between items-center">
            <h2 class="font-semibold text-xl text-gray-800 leading-tight">
                {{ __('Jadwal Pendampingan') }}
            </h2>
            <div class="flex space-x-2">
                @if (auth()->user()->role === 'staff')
                    <a href="{{ route('staff.pendampingan.create') }}" class="bg-blue-500 hover:bg-blue-700 text-white font-bold py-2 px-4 rounded">
                        {{ __('Buat Jadwal Pendampingan') }}
                    </a>
                @else
                    <a href="{{ route('user.pendampingan.request') }}" class="bg-green-500 hover:bg-green-700 text-white font-bold py-2 px-4 rounded">
                        {{ __('Ajukan Pendampingan') }}
                    </a>
                @endif
            </div>
        </div>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 text-gray-900">
                    @if (session('success'))
                        <div class="bg-green-100 border border-green-400 text-green-700 px-4 py-3 rounded relative mb-4" role="alert">
                            <span class="block sm:inline">{{ session('success') }}</span>
                        </div>
                    @endif

                    <div class="overflow-x-auto">
                        <table class="min-w-full divide-y divide-gray-200">
                            <thead class="bg-gray-50">
                                <tr>
                                    <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                        ID pendamping
                                    </th>
                                    <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                        Nama Korban
                                    </th>
                                    <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                        Nama Pendamping
                                    </th>
                                    <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                        Tanggal Pendampingan
                                    </th>
                                    <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                        Waktu Pendampingan
                                    </th>
                                    <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                        Tempat Pendampingan
                                    </th>
                                    <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                        Jenis Layanan
                                    </th>
                                    <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                        Status
                                    </th>
                                    <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                        Aksi
                                    </th>
                                </tr>
                            </thead>
                            <tbody class="bg-white divide-y divide-gray-200">
                                @forelse($pendampingans as $pendampingan)
                                    <tr>
                                        <td class="px-6 py-4 whitespace-nowrap">{{ $pendampingan->pendamping->id ?? 'N/A' }}</td>
                                        <td class="px-6 py-4 whitespace-nowrap">{{ $pendampingan->korban->nama ?? 'N/A' }}</td>
                                        <td class="px-6 py-4 whitespace-nowrap">
                                            @if ($pendampingan->nama_pendamping === 'Belum ditentukan')
                                                <span class="text-gray-500 italic">Belum ditentukan</span>
                                            @else
                                                {{ $pendampingan->nama_pendamping }}
                                            @endif
                                        </td>
                                        <td class="px-6 py-4 whitespace-nowrap">
                                            <div>
                                                <div class="font-medium">{{ $pendampingan->getTanggalPendampinganFormatted() }}</div>
                                            </div>
                                        </td>
                                        <td class="px-6 py-4 whitespace-nowrap">
                                            <div>
                                                <div class="font-medium">{{ $pendampingan->getWaktuPendampinganFormatted() }}</div>
                                            </div>
                                        </td>
                                        <td class="px-6 py-4 whitespace-nowrap">
                                            @if ($pendampingan->tempat_pendampingan === 'Belum ditentukan')
                                                <span class="text-gray-500 italic">Belum ditentukan</span>
                                            @else
                                                {{ $pendampingan->tempat_pendampingan }}
                                            @endif
                                        </td>
                                        <td class="px-6 py-4 whitespace-nowrap">{{ $pendampingan->getJenisLayananLabel() }}</td>
                                        <td class="px-6 py-4 whitespace-nowrap">
                                            <span class="px-2 inline-flex text-xs leading-5 font-semibold rounded-full
                                                @if ($pendampingan->isButuhKonfirmasiStaff()) bg-yellow-100 text-yellow-800
                                                @elseif($pendampingan->isMenungguKonfirmasiUser()) bg-blue-100 text-blue-800
                                                @elseif($pendampingan->isTerkonfirmasi()) bg-green-100 text-green-800
                                                @else bg-red-100 text-red-800 @endif">
                                                {{ $pendampingan->getStatusLabel() }}
                                            </span>
                                        </td>
                                        <td class="px-6 py-4 whitespace-nowrap text-right text-sm font-medium">
                                            <a href="{{ route('pendampingan.show', $pendampingan->id) }}" class="text-indigo-600 hover:text-indigo-900 mr-3">Lihat</a>
                                            @if (auth()->user()->role === 'staff')
                                                <a href="{{ route('staff.pendampingan.edit', $pendampingan->id) }}" class="text-blue-600 hover:text-blue-900 mr-3">Edit</a>
                                                <form action="{{ route('staff.pendampingan.destroy', $pendampingan->id) }}" method="POST" class="inline" onsubmit="return confirm('Apakah Anda yakin ingin menghapus jadwal pendampingan ini?');">
                                                    @csrf
                                                    @method('DELETE')
                                                    <button type="submit" class="text-red-600 hover:text-red-900">Hapus</button>
                                                </form>
                                            @endif
                                        </td>
                                    </tr>
                                @empty
                                    <tr>
                                        <td colspan="9" class="px-6 py-4 whitespace-nowrap text-center text-gray-500">
                                            Tidak ada jadwal pendampingan
                                        </td>
                                    </tr>
                                @endforelse
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>  --}}
