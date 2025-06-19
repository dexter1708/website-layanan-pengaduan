@extends('template.main')
@section('content_template')
    <section class="bg-white py-6 px-4 sm:px-6 lg:px-8">
        <!-- Breadcrumb -->
        <div class="flex flex-col sm:flex-row sm:items-center sm:justify-between mb-6">
            <nav class="text-sm text-gray-600 font-semibold" aria-label="Breadcrumb">
                <ol class="flex items-center space-x-2">
                    <li><a href="#" class="text-blue-600 hover:underline">Homepage</a></li>
                    <li>/</li>
                    <li><a href="#" class="text-blue-600 hover:underline">Layanan</a></li>
                    <li>/</li>
                    <li class="text-gray-500">Kelola Data</li>
                </ol>
            </nav>
        </div>

        <!-- Wilayah Card -->
        <div class="border border-gray-300 p-4 rounded-md space-y-2 bg-white">
            <div class="flex justify-between items-center">
                <p class="font-semibold text-gray-700">Wilayah</p>
                <button onclick="toggleWilayahEdit()" id="wilayahEditBtn"
                    class="text-blue-600 text-sm hover:underline">Edit</button>
            </div>

            <!-- View Mode -->
            <div id="wilayahView">
                <div class="border border-dotted p-2 rounded-md ml-2">Provinsi Jawa Barat</div>
                <div class="border border-dotted p-2 rounded-md ml-4">Kota Bandung</div>
                <div class="border border-dotted p-2 rounded-md ml-6">Kecamatan Bojongsoang</div>
                <div class="border border-dotted p-2 rounded-md ml-8">Kelurahan Bojongsari</div>
            </div>
        </div>

        <!-- Edit Mode (Hidden at start) -->
        <div id="wilayahCheckboxForm" class="hidden border border-gray-300 p-4 rounded-md space-y-2 bg-white mt-4">
            <p class="font-semibold text-gray-700 mb-2">Pilih Wilayah</p>

            <!-- Provinsi -->
            <div>
                <label class="flex items-center font-semibold">
                    <input type="checkbox" class="mr-2"> Provinsi Jawa Barat
                </label>
                <button type="button" onclick="toggleWilayah('kotaJabar')" class="ml-6 text-xl font-bold">+</button>

                <!-- Kota -->
                <div id="kotaJabar" class="ml-6 mt-2 hidden">
                    <label class="flex items-center font-medium">
                        <input type="checkbox" class="mr-2"> Kota Bandung
                    </label>
                    <button type="button" onclick="toggleWilayah('kecamatanBandung')"
                        class="ml-6 text-xl font-bold">+</button>

                    <!-- Kecamatan -->
                    <div id="kecamatanBandung" class="ml-6 mt-2 hidden">
                        <label class="flex items-center font-medium">
                            <input type="checkbox" class="mr-2"> Kecamatan Andir
                        </label>
                        <button type="button" onclick="toggleWilayah('kelurahanAndir')"
                            class="ml-6 text-xl font-bold">+</button>

                        <!-- Kelurahan -->
                        <div id="kelurahanAndir" class="ml-6 mt-2 hidden space-y-1">
                            <label class="flex items-center"><input type="checkbox" class="mr-2"> Kelurahan
                                Campaka</label>
                            <label class="flex items-center"><input type="checkbox" class="mr-2"> Kelurahan
                                Ciriyon</label>
                            <label class="flex items-center"><input type="checkbox" class="mr-2"> Kelurahan
                                Dunguscariang</label>
                            <label class="flex items-center"><input type="checkbox" class="mr-2"> Kelurahan Garuda</label>
                            <label class="flex items-center"><input type="checkbox" class="mr-2"> Kelurahan
                                Kebonjeruk</label>
                            <label class="flex items-center"><input type="checkbox" class="mr-2"> Kelurahan
                                Maleber</label>
                        </div>
                    </div>

                    <div class="flex justify-between items-center mt-4">
                        <button class="bg-green-600 text-white px-4 py-2 rounded">Simpan Perubahan</button>
                        <div class="flex space-x-2">
                            <button onclick="hapusCheckboxWilayah()" class="bg-blue-600 text-white px-4 py-2 rounded">Hapus
                                Data</button>
                            <button onclick="toggleWilayahEdit()"
                                class="bg-blue-300 text-white px-4 py-2 rounded">Sembunyikan
                                Data</button>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Jenis Kasus Card -->
        <div class="border border-gray-300 p-4 rounded-md space-y-2 bg-white mt-6">
            <div class="flex justify-between items-center">
                <p class="font-semibold text-gray-700">Jenis Kasus</p>
                <button onclick="toggleEdit('jenis')" id="jenisEditBtn"
                    class="text-blue-600 text-sm hover:underline">Edit</button>
            </div>

            <div id="jenisView">
                <div class="p-2 ml-2">Kekerasan Terhadap Perempuan dan Anak</div>
                <div class="p-2 ml-2">Kekerasan Dalam Rumah Tangga (KDRT)</div>
                <div class="p-2 ml-2">Anak Berhadapan dengan Hukum (ABH)</div>
                <div class="p-2 ml-2">Kekerasan Dalam Pacaran</div>
                <div class="p-2 ml-2">Kekerasan Terhadap Perempuan</div>
            </div>

            <div id="jenisForm" class="hidden">
                <div class="flex items-center space-x-2"><input type="checkbox" id="jk1"><label
                        for="jk1">Kekerasan Terhadap Anak</label></div>
                <div class="flex items-center space-x-2"><input type="checkbox" id="jk2"><label
                        for="jk2">Kekerasan Dalam Rumah Tangga</label></div>
                <div class="flex items-center space-x-2"><input type="checkbox" id="jk3"><label for="jk3">Anak
                        Berhadapan Dengan Hukum</label></div>
                <div class="flex items-center space-x-2"><input type="checkbox" id="jk4"><label
                        for="jk4">Kekerasan Dalam Pacaran</label></div>
                <div class="flex items-center space-x-2"><input type="checkbox" id="jk5"><label
                        for="jk5">Kekerasan Terhadap Perempuan</label></div>
                <div class="text-blue-600 text-xl font-bold cursor-pointer">+</div>
                <div class="flex justify-between items-center mt-4">
                    <button class="bg-green-600 text-white px-4 py-2 rounded">Simpan Perubahan</button>
                    <div class="flex space-x-2">
                        <button onclick="hapusCheckboxWilayah()" class="bg-blue-600 text-white px-4 py-2 rounded">Hapus
                            Data</button>
                        <button onclick="toggleWilayahEdit()" class="bg-blue-300 text-white px-4 py-2 rounded">Sembunyikan
                            Data</button>
                    </div>
                </div>
            </div>
        </div>

        <!-- Bentuk Kekerasan Card -->
        <div class="border border-gray-300 p-4 rounded-md space-y-2 bg-white mt-6">
            <div class="flex justify-between items-center">
                <p class="font-semibold text-gray-700">Bentuk Kekerasan</p>
                <button onclick="toggleEdit('bentuk')" id="bentukEditBtn"
                    class="text-blue-600 text-sm hover:underline">Edit</button>
            </div>

            <div id="bentukView">
                <div class="p-2 ml-2">Fisik</div>
                <div class="p-2 ml-2">Psikis</div>
                <div class="p-2 ml-2">Seksual</div>
                <div class="p-2 ml-2">Ekonomi</div>
                <div class="p-2 ml-2">Berbasis Online</div>
            </div>

            <div id="bentukForm" class="hidden">
                <div class="flex items-center space-x-2"><input type="checkbox" id="bk1"><label
                        for="bk1">Fisik</label></div>
                <div class="flex items-center space-x-2"><input type="checkbox" id="bk2"><label
                        for="bk2">Psikis</label></div>
                <div class="flex items-center space-x-2"><input type="checkbox" id="bk3"><label
                        for="bk3">Seksual</label></div>
                <div class="flex items-center space-x-2"><input type="checkbox" id="bk4"><label
                        for="bk4">Ekonomi</label></div>
                <div class="flex items-center space-x-2"><input type="checkbox" id="bk5"><label
                        for="bk5">Berbasis Online</label></div>
                <div class="text-blue-600 text-xl font-bold cursor-pointer">+</div>
                <div class="flex justify-between items-center mt-4">
                    <button class="bg-green-600 text-white px-4 py-2 rounded">Simpan Perubahan</button>
                    <div class="flex space-x-2">
                        <button onclick="hapusCheckboxWilayah()" class="bg-blue-600 text-white px-4 py-2 rounded">Hapus
                            Data</button>
                        <button onclick="toggleWilayahEdit()" class="bg-blue-300 text-white px-4 py-2 rounded">Sembunyikan
                            Data</button>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <script>
        function toggleWilayahEdit() {
            const view = document.getElementById('wilayahView');
            const form = document.getElementById('wilayahCheckboxForm');
            const btn = document.getElementById('wilayahEditBtn');

            if (form.classList.contains('hidden')) {
                form.classList.remove('hidden');
                view.classList.add('hidden');
                btn.textContent = 'Batal';
            } else {
                form.classList.add('hidden');
                view.classList.remove('hidden');
                btn.textContent = 'Edit';
            }
        }

        function toggleWilayah(id) {
            const el = document.getElementById(id);
            el.classList.toggle('hidden');
        }

        function toggleEdit(section) {
            const view = document.getElementById(section + 'View');
            const form = document.getElementById(section + 'Form');
            const btn = document.getElementById(section + 'EditBtn');

            if (form.classList.contains('hidden')) {
                form.classList.remove('hidden');
                view.classList.add('hidden');
                btn.textContent = 'Batal';
            } else {
                form.classList.add('hidden');
                view.classList.remove('hidden');
                btn.textContent = 'Edit';
            }
        }
    </script>

    <script type="text/javascript">
        $(document).ready(function() {
            // Ketika kota dipilih, ambil kecamatan yang sesuai
            $('#kota').on('change', function() {
                var kota_id = $(this).val();
                if (kota_id) {
                    $.ajax({
                        url: '/api/kecamatan/' + kota_id,
                        type: 'GET',
                        success: function(data) {
                            $('#kecamatan').empty();
                            $('#kecamatan').append(
                                '<option value="">--Pilih Kecamatan--</option>');
                            $.each(data, function(key, value) {
                                $('#kecamatan').append('<option value="' + value.id +
                                    '">' + value.kecamatan_nama + '</option>');
                            });
                            // Reset desa dropdown
                            $('#desa').empty();
                            $('#desa').append('<option value="">--Pilih Desa--</option>');
                        },
                        error: function() {
                            alert('Terjadi kesalahan saat mengambil data kecamatan');
                        }
                    });
                } else {
                    // Reset both dropdowns if no kota selected
                    $('#kecamatan').empty();
                    $('#kecamatan').append('<option value="">--Pilih Kecamatan--</option>');
                    $('#desa').empty();
                    $('#desa').append('<option value="">--Pilih Desa--</option>');
                }
            });

            // Ketika kecamatan dipilih, ambil desa yang sesuai
            $('#kecamatan').on('change', function() {
                var kecamatan_id = $(this).val();
                if (kecamatan_id) {
                    $.ajax({
                        url: '/api/desa/' + kecamatan_id,
                        type: 'GET',
                        success: function(data) {
                            $('#desa').empty();
                            $('#desa').append('<option value="">--Pilih Desa--</option>');
                            $.each(data, function(key, value) {
                                $('#desa').append('<option value="' + value.id + '">' +
                                    value.desa_nama + '</option>');
                            });
                        },
                        error: function() {
                            alert('Terjadi kesalahan saat mengambil data desa');
                        }
                    });
                } else {
                    // Reset desa dropdown if no kecamatan selected
                    $('#desa').empty();
                    $('#desa').append('<option value="">--Pilih Desa--</option>');
                }
            });
        });
    </script>
@endsection
