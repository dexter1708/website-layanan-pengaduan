@extends('template.main')
@section('content_template')
    <style>
        #btnBuatPengaduan:disabled {
            background-color: #9ca3af;
            /* abu-abu */
            cursor: not-allowed;
            /* hapus efek hover supaya gak berubah warna */
        }

        #btnBuatPengaduan:disabled:hover {
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
                    <li class="text-gray-500 font-semibold">Pengaduan Kasus</li>
                </ol>
            </nav>


            <!-- Tombol -->
            <button id="btnBuatPengaduan" onclick="tampilkanFormPengaduan()"
                class="bg-blue-500 text-white text-sm font-medium py-2 px-4 rounded hover:bg-blue-600 transition">
                + Buat Pengaduan
            </button>


        </div>

        <!-- Konten Kosong -->
        @if (true)
            <section id="index-pengaduan-kosong" class="bg-white py-6 px-4 sm:px-6 lg:px-8">
                <main class="max-w-6xl mx-auto p-6 bg-white rounded-md">
                    <div
                        class="inline-block bg-blue-400 text-white text-sm font-medium px-6 py-2 rounded-tl-lg rounded-tr-lg mb-6">
                        Laporan Pengaduan 1
                    </div>

                    <!-- Identitas Pelapor -->
                    <section class="mb-8">
                        <h3 class="font-bold text-gray-800 text-lg mb-4">Identitas Pelapor</h3>
                        <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                            <div>
                                <label class="block font-semibold text-gray-800 mb-1">Nama Lengkap *</label>
                                <p class="px-4 py-2">Aisyah Nanda</p>
                            </div>
                            <div>
                                <label class="block font-semibold text-gray-800 mb-1">Sebagai *</label>
                                <p class="px-4 py-2">Pelapor</p>
                            </div>
                            <div>
                                <label class="block font-semibold text-gray-800 mb-1">Alamat *</label>
                                <p class="px-4 py-2">Jl. Telekomunikasi No. 49, Kel. Sukapura, Kec. Dayeuhkolot, Kab.
                                    Bandung</p>
                            </div>
                            <div>
                                <label class="block font-semibold text-gray-800 mb-1">No Handphone *</label>
                                <p class="px-4 py-2">089123456789</p>
                            </div>
                        </div>
                    </section>

                    <hr class="border-t border-gray-300 my-4" />

                    <!-- Identitas Korban -->
                    <section class="mb-8">
                        <h3 class="font-bold text-gray-800 text-lg mb-4">Identitas Korban</h3>
                        <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                            <div>
                                <label class="block font-semibold text-gray-800 mb-1">Nama Lengkap *</label>
                                <p class="px-4 py-2">Dina Lestari</p>
                            </div>
                            <div>
                                <label class="block font-semibold text-gray-800 mb-1">Jenis Kelamin *</label>
                                <p class="px-4 py-2">Perempuan</p>
                            </div>
                            <div>
                                <label class="block font-semibold text-gray-800 mb-1">Disabilitas *</label>
                                <p class="px-4 py-2">Tidak</p>
                            </div>
                            <div>
                                <label class="block font-semibold text-gray-800 mb-1">Usia saat kejadian *</label>
                                <p class="px-4 py-2">25</p>
                            </div>
                            <div>
                                <label class="block font-semibold text-gray-800 mb-1">Pendidikan *</label>
                                <p class="px-4 py-2">S1</p>
                            </div>
                            <div>
                                <label class="block font-semibold text-gray-800 mb-1">Pekerjaan *</label>
                                <p class="px-4 py-2">Pegawai Swasta</p>
                            </div>
                            <div>
                                <label class="block font-semibold text-gray-800 mb-1">Status Perkawinan *</label>
                                <p class="px-4 py-2">Belum Menikah</p>
                            </div>
                            <div>
                                <label class="block font-semibold text-gray-800 mb-1">No Handphone *</label>
                                <p class="px-4 py-2">089876543210</p>
                            </div>
                        </div>
                    </section>

                    <hr class="border-t border-gray-300 my-4" />

                    <!-- Identitas Pelaku -->
                    <section class="mb-8">
                        <h3 class="font-bold text-gray-800 text-lg mb-4">Identitas Pelaku</h3>
                        <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                            <div>
                                <label class="block font-semibold text-gray-800 mb-1">Nama Lengkap *</label>
                                <p class="px-4 py-2">Rizal Fadillah</p>
                            </div>
                            <div>
                                <label class="block font-semibold text-gray-800 mb-1">Jenis Kelamin *</label>
                                <p class="px-4 py-2">Laki-laki</p>
                            </div>
                            <div>
                                <label class="block font-semibold text-gray-800 mb-1">Hubungan dengan Korban *</label>
                                <p class="px-4 py-2">Pacar</p>
                            </div>
                            <div>
                                <label class="block font-semibold text-gray-800 mb-1">Usia Saat Kejadian *</label>
                                <p class="px-4 py-2">27</p>
                            </div>
                            <div>
                                <label class="block font-semibold text-gray-800 mb-1">Pendidikan *</label>
                                <p class="px-4 py-2">S1</p>
                            </div>
                            <div>
                                <label class="block font-semibold text-gray-800 mb-1">Pekerjaan *</label>
                                <p class="px-4 py-2">Pegawai Swasta</p>
                            </div>
                        </div>
                    </section>

                    <hr class="border-t border-gray-300 my-4" />

                    <!-- Detail Kasus -->
                    <section>
                        <h3 class="font-bold text-gray-800 text-lg mb-4">Detail Kasus</h3>
                        <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                            <div>
                                <label class="block font-semibold text-gray-800 mb-1">Jenis Kasus *</label>
                                <p class="px-4 py-2">Kekerasan Seksual</p>
                            </div>
                            <div>
                                <label class="block font-semibold text-gray-800 mb-1">Bentuk Kekerasan *</label>
                                <p class="px-4 py-2">Seksual</p>
                            </div>
                            <div>
                                <label class="block font-semibold text-gray-800 mb-1">Tempat Kejadian *</label>
                                <p class="px-4 py-2">Rumah</p>
                            </div>
                            <div>
                                <label class="block font-semibold text-gray-800 mb-1">Kecamatan *</label>
                                <p class="px-4 py-2">Dayeuhkolot</p>
                            </div>
                            <div>
                                <label class="block font-semibold text-gray-800 mb-1">Tanggal Kejadian *</label>
                                <p class="px-4 py-2">2025-06-12</p>
                            </div>
                            <div>
                                <label class="block font-semibold text-gray-800 mb-1">Apakah sudah pernah dilaporkan?
                                    *</label>
                                <p class="px-4 py-2">Sudah Pernah</p>
                            </div>
                        </div>

                        <div class="mt-6">
                            <label class="block font-semibold text-gray-800 mb-1">Kronologi Singkat *</label>
                            <p class="px-4 py-2">Kejadian terjadi saat korban sedang berada di rumah sendirian dan pelaku
                                memaksa masuk untuk melakukan tindakan kekerasan seksual.</p>
                        </div>
                    </section>

                    <div class="flex justify-center mt-6 gap-4">
                        <button type="button" class="bg-blue-500 text-white px-6 py-2 rounded hover:bg-blue-600">
                            lihat Status Pengaduan
                        </button>
                    </div>
                </main>
            </section>
        @else
            <div id="index-pengaduan-kosong" class="text-center py-16 text-gray-500 max-w-xl mx-auto">
                <p class="text-2xl font-semibold mb-2 w-full">Tidak Ada Pengaduan</p>
                <p class="text-2xl w-full">Anda belum melakukan pengaduan kasus.</p>
            </div>
        @endif

    </section>



    <style>
        input[type="checkbox"].toggle-switch {
            appearance: none;
            width: 44px;
            height: 24px;
            background-color: #cbd5e1;
            border-radius: 9999px;
            position: relative;
            outline: none;
            cursor: pointer;
            transition: background-color 0.3s ease;
        }

        input[type="checkbox"].toggle-switch:checked {
            background-color: #3b82f6;
        }

        input[type="checkbox"].toggle-switch::before {
            content: "";
            position: absolute;
            width: 18px;
            height: 18px;
            background-color: white;
            border-radius: 9999px;
            top: 3px;
            left: 3px;
            transition: transform 0.3s ease;
        }

        input[type="checkbox"].toggle-switch:checked::before {
            transform: translateX(20px);
        }
    </style>
    <section id="form-pengaduan" class=" hidden bg-white py-6 px-4 sm:px-6 lg:px-8">
        <main class="max-w-6xl mx-auto p-6 bg-white rounded-md">
            <div class="inline-block bg-blue-400 text-white text-sm font-medium px-6 py-2 rounded-tl-lg rounded-tr-lg mb-6">
                Laporan Pengaduan 2
            </div>

            <form class="space-y-10">
                <!-- Identitas Pelapor -->
                <section>
                    <h3 class="font-bold text-gray-800 text-lg mb-4">Identitas Pelapor</h3>
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                        <div>
                            <label class="block font-semibold text-gray-800 mb-1">Nama Lengkap *</label>
                            <input type="text" value="Aisyah Nanda"
                                class="w-full bg-blue-50 text-gray-800 px-4 py-2 border-b border-gray-300 focus:outline-none" />
                        </div>
                        <div>
                            <label class="block font-semibold text-gray-800 mb-1">Sebagai *</label>
                            <input type="text" value="Pelapor"
                                class="w-full bg-blue-50 text-gray-800 px-4 py-2 border-b border-gray-300 focus:outline-none" />
                        </div>
                        <div>
                            <label class="block font-semibold text-gray-800 mb-1">Alamat *</label>
                            <input type="text"
                                value="Jl. Telekomunikasi No. 49, Kel. Sukapura, Kec. Dayeuhkolot, Kab. Bandung"
                                class="w-full bg-blue-50 text-gray-800 px-4 py-2 border-b border-gray-300 focus:outline-none" />
                        </div>
                        <div>
                            <label class="block font-semibold text-gray-800 mb-1">No Handphone *</label>
                            <input type="text" value="089123456789"
                                class="w-full bg-blue-50 text-gray-800 px-4 py-2 border-b border-gray-300 focus:outline-none" />
                        </div>
                    </div>
                </section>
                <hr class="border-t border-gray-300 my-4" />

                <!-- Identitas Korban -->
                <section>

                    <div class="flex justify-between items-center mb-4">
                        <h3 class="font-bold text-gray-800 text-lg">Identitas Korban</h3>
                        <label class="flex items-center space-x-2 text-sm font-semibold text-gray-700">
                            <span>Identitas diambil dari data pelapor</span>
                            <input type="checkbox" class="toggle-switch" />
                        </label>
                    </div>

                    <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                        <div>
                            <label class="block font-semibold text-gray-800 mb-1">Nama Lengkap *</label>
                            <input type="text" placeholder="Nama"
                                class="w-full bg-blue-50 text-gray-800 px-4 py-2 border-b border-gray-300 focus:outline-none" />
                        </div>
                        <div>
                            <label class="block font-semibold text-gray-800 mb-1">Jenis Kelamin *</label>
                            <select
                                class="w-full bg-blue-50 text-gray-800 px-4 py-2 border-b border-gray-300 focus:outline-none">
                                <option selected disabled hidden>Jenis Kelamin</option>
                                <option value="laki-laki">Laki-laki</option>
                                <option value="perempuan">Perempuan</option>
                            </select>
                        </div>
                        <div>
                            <label class="block font-semibold text-gray-800 mb-1">Disabilitas *</label>
                            <select
                                class="w-full bg-blue-50 text-gray-800 px-4 py-2 border-b border-gray-300 focus:outline-none">
                                <option selected disabled hidden>Disabilitas</option>
                                <option value="tidak">Tidak</option>
                                <option value="ya">Ya</option>
                            </select>
                        </div>
                        <div>
                            <label class="block font-semibold text-gray-800 mb-1">Usia saat kejadian *</label>
                            <input type="text" placeholder="Usia Korban"
                                class="w-full bg-blue-50 text-gray-800 px-4 py-2 border-b border-gray-300 focus:outline-none" />
                        </div>
                        <div>
                            <label class="block font-semibold text-gray-800 mb-1">Pendidikan *</label>
                            <select
                                class="w-full bg-blue-50 text-gray-800 px-4 py-2 border-b border-gray-300 focus:outline-none">
                                <option selected disabled hidden>Pendidikan</option>
                                <option value="sma">SMA</option>
                                <option value="s1">S1</option>
                            </select>
                        </div>
                        <div>
                            <label class="block font-semibold text-gray-800 mb-1">Pekerjaan *</label>
                            <select
                                class="w-full bg-blue-50 text-gray-800 px-4 py-2 border-b border-gray-300 focus:outline-none">
                                <option selected disabled hidden>Pekerjaan</option>
                                <option value="pegawai_negeri">Pegawai Negeri</option>
                                <option value="pegawai_swasta">Pegawai Swasta</option>
                                <option value="wirausaha">Wirausaha</option>
                                <option value="buruh">Buruh</option>
                                <option value="petani">Petani</option>
                                <option value="nelayan">Nelayan</option>
                                <option value="pelajar">Pelajar/Mahasiswa</option>
                                <option value="tidak_bekerja">Tidak Bekerja</option>
                                <option value="lainnya">Lainnya</option>
                            </select>
                        </div>
                        <div>
                            <label class="block font-semibold text-gray-800 mb-1">Status Perkawinan *</label>
                            <select
                                class="w-full bg-blue-50 text-gray-800 px-4 py-2 border-b border-gray-300 focus:outline-none">
                                <option selected disabled hidden>Status Perkawinan</option>
                                <option value="belum_menikah">Belum Menikah</option>
                                <option value="menikah">Menikah</option>
                                <option value="cerai_hidup">Cerai Hidup</option>
                                <option value="cerai_mati">Cerai Mati</option>
                            </select>
                        </div>

                        <div>
                            <label class="block font-semibold text-gray-800 mb-1">No Handphone *</label>
                            <input type="text" placeholder="No Handphone"
                                class="w-full bg-blue-50 text-gray-800 px-4 py-2 border-b border-gray-300 focus:outline-none" />
                        </div>
                    </div>
                </section>
                <hr class="border-t border-gray-300 my-4" />

                <!-- Identitas Pelaku -->
                <section>
                    <div class="flex justify-between items-center mb-4">
                        <h3 class="font-bold text-gray-800 text-lg">Identitas Pelaku</h3>
                    </div>

                    <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                        <!-- Nama Lengkap -->
                        <div>
                            <label class="block font-semibold text-gray-800 mb-1">Nama Lengkap *</label>
                            <input type="text" placeholder="Nama Lengkap Pelaku"
                                class="w-full bg-blue-50 text-gray-800 px-4 py-2 border-b border-gray-300 focus:outline-none" />
                        </div>

                        <!-- Jenis Kelamin -->
                        <div>
                            <label class="block font-semibold text-gray-800 mb-1">Jenis Kelamin *</label>
                            <select
                                class="w-full bg-blue-50 text-gray-800 px-4 py-2 border-b border-gray-300 focus:outline-none">
                                <option selected disabled hidden>Jenis Kelamin</option>
                                <option value="laki-laki">Laki-laki</option>
                                <option value="perempuan">Perempuan</option>
                            </select>
                        </div>

                        <!-- Hubungan dengan Korban -->
                        <div>
                            <label class="block font-semibold text-gray-800 mb-1">Hubungan dengan Korban *</label>
                            <select
                                class="w-full bg-blue-50 text-gray-800 px-4 py-2 border-b border-gray-300 focus:outline-none">
                                <option selected disabled hidden>Pilih Hubungan</option>
                                <option value="suami">Suami</option>
                                <option value="istri">Istri</option>
                                <option value="orang_tua">Orang Tua</option>
                                <option value="anak">Anak</option>
                                <option value="saudara_kandung">Saudara Kandung</option>
                                <option value="teman">Teman</option>
                                <option value="pacar">Pacar</option>
                                <option value="mantan">Mantan</option>
                                <option value="guru_dosen">Guru/Dosen</option>
                                <option value="atasan">Atasan</option>
                                <option value="rekan_kerja">Rekan Kerja</option>
                                <option value="tetangga">Tetangga</option>
                                <option value="lainnya">Lainnya</option>
                            </select>
                        </div>


                        <!-- Usia Saat Kejadian -->
                        <div>
                            <label class="block font-semibold text-gray-800 mb-1">Usia Saat Kejadian *</label>
                            <input type="text" placeholder="Usia Pelaku saat kejadian"
                                class="w-full bg-blue-50 text-gray-800 px-4 py-2 border-b border-gray-300 focus:outline-none" />
                        </div>

                        <!-- Pendidikan -->
                        <div>
                            <label class="block font-semibold text-gray-800 mb-1">Pendidikan *</label>
                            <select
                                class="w-full bg-blue-50 text-gray-800 px-4 py-2 border-b border-gray-300 focus:outline-none">
                                <option selected disabled hidden>Pendidikan</option>
                                <option value="tidak_sekolah">Tidak Sekolah</option>
                                <option value="sd">SD</option>
                                <option value="smp">SMP</option>
                                <option value="sma">SMA</option>
                                <option value="d3">D3</option>
                                <option value="s1">S1</option>
                                <option value="s2">S2</option>
                                <option value="s3">S3</option>
                            </select>
                        </div>

                        <!-- Pekerjaan -->
                        <div>
                            <label class="block font-semibold text-gray-800 mb-1">Pekerjaan *</label>
                            <select
                                class="w-full bg-blue-50 text-gray-800 px-4 py-2 border-b border-gray-300 focus:outline-none">
                                <option selected disabled hidden>Pekerjaan</option>
                                <option value="pegawai_negeri">Pegawai Negeri</option>
                                <option value="pegawai_swasta">Pegawai Swasta</option>
                                <option value="wirausaha">Wirausaha</option>
                                <option value="buruh">Buruh</option>
                                <option value="petani">Petani</option>
                                <option value="nelayan">Nelayan</option>
                                <option value="pelajar">Pelajar/Mahasiswa</option>
                                <option value="tidak_bekerja">Tidak Bekerja</option>
                                <option value="lainnya">Lainnya</option>
                            </select>
                        </div>
                    </div>
                </section>

                <hr class="border-t border-gray-300 my-4" />

                <!-- Detail Kasus -->
                <section>
                    <h3 class="font-bold text-gray-800 text-lg mb-4">Detail Kasus</h3>
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-6">

                        <div>
                            <label class="block font-semibold text-gray-800 mb-1">Jenis Kasus *</label>
                            <select
                                class="w-full bg-blue-50 text-gray-800 px-4 py-2 border-b border-gray-300 focus:outline-none">
                                <option selected disabled hidden>Jenis Kasus</option>
                                <option value="kdrt">Kekerasan Dalam Rumah Tangga</option>
                                <option value="kekerasan_seksual">Kekerasan Seksual</option>
                                <option value="penelantaran">Penelantaran</option>
                                <option value="eksploitasi">Eksploitasi</option>
                                <option value="perdagangan_orang">Perdagangan Orang</option>
                                <option value="psikis">Kekerasan Psikis</option>
                            </select>
                        </div>

                        <div>
                            <label class="block font-semibold text-gray-800 mb-1">Bentuk Kekerasan *</label>
                            <select
                                class="w-full bg-blue-50 text-gray-800 px-4 py-2 border-b border-gray-300 focus:outline-none">
                                <option selected disabled hidden>Bentuk Kekerasan</option>
                                <option value="fisik">Fisik</option>
                                <option value="psikis">Psikis</option>
                                <option value="seksual">Seksual</option>
                                <option value="ekonomi">Ekonomi</option>
                                <option value="eksploitasi">Eksploitasi</option>
                            </select>
                        </div>

                        <div>
                            <label class="block font-semibold text-gray-800 mb-1">Tempat Kejadian *</label>
                            <select
                                class="w-full bg-blue-50 text-gray-800 px-4 py-2 border-b border-gray-300 focus:outline-none">
                                <option selected disabled hidden>Tempat Kejadian</option>
                                <option value="rumah">Rumah</option>
                                <option value="kantor">Tempat Kerja</option>
                                <option value="sekolah">Sekolah/Kampus</option>
                                <option value="jalan">Ruang Publik</option>
                                <option value="lainnya">Lainnya</option>
                            </select>
                        </div>

                        <div>
                            <label class="block font-semibold text-gray-800 mb-1">Kecamatan *</label>
                            <select
                                class="w-full bg-blue-50 text-gray-800 px-4 py-2 border-b border-gray-300 focus:outline-none">
                                <option selected disabled hidden>Pilih Kecamatan</option>
                                <option value="dayeuhkolot">Dayeuhkolot</option>
                                <option value="bojongsoang">Bojongsoang</option>
                                <option value="cileunyi">Cileunyi</option>
                                <option value="margahayu">Margahayu</option>
                                <option value="lainnya">Lainnya</option>
                            </select>
                        </div>

                        <div>
                            <label class="block font-semibold text-gray-800 mb-1">Tanggal Kejadian *</label>
                            <input type="date"
                                class="w-full bg-blue-50 text-gray-800 px-4 py-2 border-b border-gray-300 focus:outline-none" />
                        </div>

                        <div>
                            <label class="block font-semibold text-gray-800 mb-1">Apakah sudah pernah dilaporkan? *</label>
                            <select
                                class="w-full bg-blue-50 text-gray-800 px-4 py-2 border-b border-gray-300 focus:outline-none">
                                <option selected disabled hidden>Status Laporan</option>
                                <option value="belum">Belum Pernah</option>
                                <option value="sudah">Sudah Pernah</option>
                            </select>
                        </div>
                    </div>

                    <div class="mt-6">
                        <label class="block font-semibold text-gray-800 mb-1">Kronologi Singkat *</label>
                        <textarea rows="5" placeholder="Tuliskan kronologi singkat kejadian..."
                            class="w-full bg-blue-50 text-gray-800 px-4 py-2 border-b border-gray-300 focus:outline-none"></textarea>
                    </div>
                </section>

                <div class="flex justify-center mt-6 gap-4">
                    <button type="button" onclick="kembaliKeKontenKosong()"
                        class="bg-blue-400 text-white px-6 py-2 rounded hover:bg-blue-500 transition">
                        Batal
                    </button>
                    <button type="submit" class="bg-blue-500 text-white px-6 py-2 rounded hover:bg-blue-600">
                        Simpan
                    </button>
                </div>

            </form>
        </main>
    </section>
    <script>
        function tampilkanFormPengaduan() {
            document.getElementById('index-pengaduan-kosong').classList.add('hidden');
            document.getElementById('form-pengaduan').classList.remove('hidden');
            const btn = document.getElementById('btnBuatPengaduan');
            btn.disabled = true; // disable tombol sebenarnya
        }


        function kembaliKeKontenKosong() {
            document.getElementById('form-pengaduan').classList.add('hidden');
            document.getElementById('index-pengaduan-kosong').classList.remove('hidden');
            const btn = document.getElementById('btnBuatPengaduan');
            btn.disabled = false; // enable tombol kembali
        }
    </script>
@endsection
