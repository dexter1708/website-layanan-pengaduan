<!DOCTYPE html>
<html>
<head>
    <title>Form Pengaduan</title>
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <style>
        body { 
            font-family: Arial, sans-serif; 
            padding: 20px;
            background-color: #f5f5f5;
        }
        .container {
            max-width: 800px;
            margin: 0 auto;
            background: white;
            padding: 20px;
            border-radius: 8px;
            box-shadow: 0 2px 4px rgba(0,0,0,0.1);
        }
        .section {
            margin-bottom: 30px;
            padding: 20px;
            border: 1px solid #ddd;
            border-radius: 4px;
        }
        h2, h3 {
            color: #333;
            border-bottom: 2px solid #4CAF50;
            padding-bottom: 10px;
            margin-bottom: 20px;
        }
        .form-group {
            margin-bottom: 15px;
        }
        label {
            display: block;
            font-weight: bold;
            margin-bottom: 5px;
            color: #555;
        }
        input[type="text"],
        input[type="number"],
        input[type="date"],
        select,
        textarea {
            width: 100%;
            padding: 8px;
            border: 1px solid #ddd;
            border-radius: 4px;
            box-sizing: border-box;
            margin-bottom: 10px;
        }
        select {
            background-color: white;
        }
        .btn {
            background-color: #4CAF50;
            color: white;
            padding: 10px 20px;
            border: none;
            border-radius: 4px;
            cursor: pointer;
            font-size: 16px;
            width: 100%;
        }
        .btn:hover {
            background-color: #45a049;
        }
        .error {
            color: red;
            font-size: 14px;
            margin: 10px 0;
            padding: 10px;
            border: 1px solid #ffebee;
            background-color: #ffebee;
            border-radius: 4px;
        }
        hr {
            border: none;
            border-top: 1px solid #ddd;
            margin: 20px 0;
        }
        .radio-group {
            margin-bottom: 20px;
        }
        .radio-group label {
            display: inline;
            margin-right: 20px;
        }
    </style>
</head>
<body>
    <div class="container">
        <h2>Form Pengaduan</h2>

        @if ($errors->any())
            <div class="error">
                <ul>
                    @foreach ($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
        @endif

        <form action="{{ route('pengaduan.store') }}" method="POST">
            @csrf
            
            <div class="section">
                <h3>Data Pelapor</h3>
                <div class="form-group">
                    <label>Nama:</label>
                    <p>{{ Auth::user()->name }}</p>
                </div>
                <div class="form-group">
                    <label>Email:</label>
                    <p>{{ Auth::user()->email }}</p>
                </div>
                <div class="form-group">
                    <label>Alamat:</label>
                    <p>
                        {{ Auth::user()->alamat->desa }}, 
                        {{ Auth::user()->alamat->kecamatan }}, 
                        {{ Auth::user()->alamat->kota }}
                        RT {{ Auth::user()->alamat->RT }}/RW {{ Auth::user()->alamat->RW }}
                    </p>
                </div>
            </div>

            <hr>
            <h3>Data Kejadian</h3>

            <label>Tempat Kejadian:</label><br>
            <input type="text" name="tempat_kejadian" value="{{ old('tempat_kejadian') }}" required><br><br>

            <label>Kota Kejadian:</label><br>
            <select name="kota_kejadian" id="kota_kejadian" required>
                <option value="">-- Pilih Kota --</option>
                @foreach ($kotas as $kota)
                    <option value="{{ $kota->kota_id }}">{{ $kota->kota_nama }}</option>
                @endforeach
            </select><br><br>

            <label>Kecamatan Kejadian:</label><br>
            <select name="kecamatan_kejadian" id="kecamatan_kejadian" required>
                <option value="">-- Pilih Kecamatan --</option>
            </select><br><br>

            <label>Desa Kejadian:</label><br>
            <select name="desa_kejadian" id="desa_kejadian" required>
                <option value="">-- Pilih Desa --</option>
            </select><br><br>

            <label>Tanggal Kejadian:</label><br>
            <input type="date" name="tanggal_kejadian" value="{{ old('tanggal_kejadian') }}" required><br><br>

            <label>Jenis Laporan:</label><br>
            <select name="jenis_laporan" required>
                <option value="">-- Pilih Jenis Laporan --</option>
                <option value="Kekerasan">Kekerasan</option>
                <option value="Pelecehan">Pelecehan</option>
                <option value="Diskriminasi">Diskriminasi</option>
                <option value="Lainnya">Lainnya</option>
            </select><br><br>

            <label>Kronologi:</label><br>
            <textarea name="kronologi" rows="5" required>{{ old('kronologi') }}</textarea><br><br>

            <label>Jenis Kasus:</label><br>
            <select name="jenis_kasus" required>
                <option value="">-- Pilih Jenis Kasus --</option>
                <option value="KDRT">KDRT</option>
                <option value="Kekerasan Seksual">Kekerasan Seksual</option>
                <option value="Trafficking">Trafficking</option>
                <option value="Lainnya">Lainnya</option>
            </select><br><br>

            <label>Bentuk Kekerasan:</label><br>
            <select name="bentuk_kekerasan" required>
                <option value="">-- Pilih Bentuk Kekerasan --</option>
                @foreach ($bentukKekerasan as $bk)
                    <option value="{{ $bk->bentuk_kekerasan }}" {{ old('bentuk_kekerasan') == $bk->bentuk_kekerasan ? 'selected' : '' }}>{{ $bk->bentuk_kekerasan }}</option>
                @endforeach
            </select><br><br>

            <div class="section">
                <h3>Data Korban</h3>
                <div class="form-group">
                    <label>Nama Korban:</label>
                    <input type="text" name="korban[nama]" value="{{ old('korban.nama') }}" required>
                </div>

                <div class="form-group">
                    <label>Jenis Kelamin:</label>
                    <select name="korban[jenis_kelamin]" required>
                        <option value="">-- Pilih Jenis Kelamin --</option>
                        <option value="Laki-laki" {{ old('korban.jenis_kelamin') == 'Laki-laki' ? 'selected' : '' }}>Laki-laki</option>
                        <option value="Perempuan" {{ old('korban.jenis_kelamin') == 'Perempuan' ? 'selected' : '' }}>Perempuan</option>
                    </select>
                </div>

                <div class="form-group">
                    <label>Disabilitas:</label>
                    <select name="korban[disabilitas]" required>
                        <option value="">-- Pilih Status Disabilitas --</option>
                        <option value="Ya" {{ old('korban.disabilitas') == 'Ya' ? 'selected' : '' }}>Ya</option>
                        <option value="Tidak" {{ old('korban.disabilitas') == 'Tidak' ? 'selected' : '' }}>Tidak</option>
                    </select>
                </div>

                <div class="form-group">
                    <label>Usia:</label>
                    <input type="number" name="korban[usia]" value="{{ old('korban.usia') }}" required min="0">
                </div>

                <div class="form-group">
                    <label>Pendidikan:</label>
                    <select name="korban[pendidikan]" required>
                        <option value="">-- Pilih Pendidikan --</option>
                        <option value="Tidak Sekolah" {{ old('korban.pendidikan') == 'Tidak Sekolah' ? 'selected' : '' }}>Tidak Sekolah</option>
                        <option value="SD" {{ old('korban.pendidikan') == 'SD' ? 'selected' : '' }}>SD</option>
                        <option value="SMP" {{ old('korban.pendidikan') == 'SMP' ? 'selected' : '' }}>SMP</option>
                        <option value="SMA" {{ old('korban.pendidikan') == 'SMA' ? 'selected' : '' }}>SMA</option>
                        <option value="D3" {{ old('korban.pendidikan') == 'D3' ? 'selected' : '' }}>D3</option>
                        <option value="S1" {{ old('korban.pendidikan') == 'S1' ? 'selected' : '' }}>S1</option>
                        <option value="S2" {{ old('korban.pendidikan') == 'S2' ? 'selected' : '' }}>S2</option>
                        <option value="S3" {{ old('korban.pendidikan') == 'S3' ? 'selected' : '' }}>S3</option>
                    </select>
                </div>

                <div class="form-group">
                    <label>Pekerjaan:</label>
                    <select name="korban[pekerjaan]" required>
                        <option value="">-- Pilih Pekerjaan --</option>
                        @foreach ($pekerjaan as $p)
                            <option value="{{ $p->pekerjaan }}" {{ old('korban.pekerjaan') == $p->pekerjaan ? 'selected' : '' }}>{{ $p->pekerjaan }}</option>
                        @endforeach
                    </select>
                </div>

                <div class="form-group">
                    <label>Status Perkawinan:</label>
                    <select name="korban[status_perkawinan]" required>
                        <option value="">-- Pilih Status Perkawinan --</option>
                        <option value="Belum Kawin" {{ old('korban.status_perkawinan') == 'Belum Kawin' ? 'selected' : '' }}>Belum Kawin</option>
                        <option value="Kawin" {{ old('korban.status_perkawinan') == 'Kawin' ? 'selected' : '' }}>Kawin</option>
                        <option value="Cerai Hidup" {{ old('korban.status_perkawinan') == 'Cerai Hidup' ? 'selected' : '' }}>Cerai Hidup</option>
                        <option value="Cerai Mati" {{ old('korban.status_perkawinan') == 'Cerai Mati' ? 'selected' : '' }}>Cerai Mati</option>
                    </select>
                </div>
            </div>

            <div class="section">
                <h3>Data Pelaku</h3>
                <div class="form-group">
                    <label>Nama Pelaku:</label>
                    <input type="text" name="pelaku[nama]" value="{{ old('pelaku.nama') }}" required>
                </div>

                <div class="form-group">
                    <label>Jenis Kelamin:</label>
                    <select name="pelaku[jenis_kelamin]" required>
                        <option value="">-- Pilih Jenis Kelamin --</option>
                        <option value="Laki-laki" {{ old('pelaku.jenis_kelamin') == 'Laki-laki' ? 'selected' : '' }}>Laki-laki</option>
                        <option value="Perempuan" {{ old('pelaku.jenis_kelamin') == 'Perempuan' ? 'selected' : '' }}>Perempuan</option>
                    </select>
                </div>

                <div class="form-group">
                    <label>Usia:</label>
                    <input type="number" name="pelaku[usia]" value="{{ old('pelaku.usia') }}" required min="0">
                </div>

                <div class="form-group">
                    <label>Pendidikan:</label>
                    <select name="pelaku[pendidikan]" required>
                        <option value="">-- Pilih Pendidikan --</option>
                        <option value="Tidak Sekolah" {{ old('pelaku.pendidikan') == 'Tidak Sekolah' ? 'selected' : '' }}>Tidak Sekolah</option>
                        <option value="SD" {{ old('pelaku.pendidikan') == 'SD' ? 'selected' : '' }}>SD</option>
                        <option value="SMP" {{ old('pelaku.pendidikan') == 'SMP' ? 'selected' : '' }}>SMP</option>
                        <option value="SMA" {{ old('pelaku.pendidikan') == 'SMA' ? 'selected' : '' }}>SMA</option>
                        <option value="D3" {{ old('pelaku.pendidikan') == 'D3' ? 'selected' : '' }}>D3</option>
                        <option value="S1" {{ old('pelaku.pendidikan') == 'S1' ? 'selected' : '' }}>S1</option>
                        <option value="S2" {{ old('pelaku.pendidikan') == 'S2' ? 'selected' : '' }}>S2</option>
                        <option value="S3" {{ old('pelaku.pendidikan') == 'S3' ? 'selected' : '' }}>S3</option>
                    </select>
                </div>

                <div class="form-group">
                    <label>Pekerjaan:</label>
                    <select name="pelaku[pekerjaan]" required>
                        <option value="">-- Pilih Pekerjaan --</option>
                        @foreach ($pekerjaan as $p)
                            <option value="{{ $p->pekerjaan }}" {{ old('pelaku.pekerjaan') == $p->pekerjaan ? 'selected' : '' }}>{{ $p->pekerjaan }}</option>
                        @endforeach
                    </select>
                </div>

                <div class="form-group">
                    <label>Hubungan dengan Korban:</label>
                    <select name="pelaku[hubungan]" required>
                        <option value="">-- Pilih Hubungan --</option>
                        <option value="Orang Tua" {{ old('pelaku.hubungan') == 'Orang Tua' ? 'selected' : '' }}>Orang Tua</option>
                        <option value="Saudara" {{ old('pelaku.hubungan') == 'Saudara' ? 'selected' : '' }}>Saudara</option>
                        <option value="Pasangan" {{ old('pelaku.hubungan') == 'Pasangan' ? 'selected' : '' }}>Pasangan</option>
                        <option value="Tetangga" {{ old('pelaku.hubungan') == 'Tetangga' ? 'selected' : '' }}>Tetangga</option>
                        <option value="Teman" {{ old('pelaku.hubungan') == 'Teman' ? 'selected' : '' }}>Teman</option>
                        <option value="Lainnya" {{ old('pelaku.hubungan') == 'Lainnya' ? 'selected' : '' }}>Lainnya</option>
                    </select>
                </div>

                <div class="form-group">
                    <label>Kewarganegaraan:</label>
                    <select name="pelaku[kewarganegaraan]" required>
                        <option value="">-- Pilih Kewarganegaraan --</option>
                        <option value="WNI" {{ old('pelaku.kewarganegaraan') == 'WNI' ? 'selected' : '' }}>WNI</option>
                        <option value="WNA" {{ old('pelaku.kewarganegaraan') == 'WNA' ? 'selected' : '' }}>WNA</option>
                    </select>
                </div>
            </div>

            <input type="hidden" name="status" value="menunggu">

            <button type="submit" class="btn">Kirim Pengaduan</button>
        </form>
    </div>

    <script>
        $.ajaxSetup({
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            }
        });

        $(document).ready(function() {
            // Function to handle kota change
            function handleKotaChange(kotaSelect, kecamatanSelect, desaSelect) {
                $(kotaSelect).change(function() {
                    var kotaId = $(this).val();
                    if (kotaId) {
                        $.ajax({
                            url: '/api/kecamatan/' + kotaId,
                            type: 'GET',
                            success: function(data) {
                                $(kecamatanSelect).empty();
                                $(kecamatanSelect).append('<option value="">-- Pilih Kecamatan --</option>');
                                $.each(data, function(key, value) {
                                    $(kecamatanSelect).append('<option value="'+ value.id +'">'+ value.nama +'</option>');
                                });
                                $(desaSelect).empty();
                                $(desaSelect).append('<option value="">-- Pilih Desa --</option>');
                            }
                        });
                    } else {
                        $(kecamatanSelect).empty();
                        $(kecamatanSelect).append('<option value="">-- Pilih Kecamatan --</option>');
                        $(desaSelect).empty();
                        $(desaSelect).append('<option value="">-- Pilih Desa --</option>');
                    }
                });
            }

            // Function to handle kecamatan change
            function handleKecamatanChange(kecamatanSelect, desaSelect) {
                $(kecamatanSelect).change(function() {
                    var kecamatanId = $(this).val();
                    if (kecamatanId) {
                        $.ajax({
                            url: '/api/desa/' + kecamatanId,
                            type: 'GET',
                            success: function(data) {
                                $(desaSelect).empty();
                                $(desaSelect).append('<option value="">-- Pilih Desa --</option>');
                                $.each(data, function(key, value) {
                                    $(desaSelect).append('<option value="'+ value.id +'">'+ value.nama +'</option>');
                                });
                            },
                            error: function() {
                                alert('Terjadi kesalahan saat mengambil data desa');
                            }
                        });
                    } else {
                        $(desaSelect).empty();
                        $(desaSelect).append('<option value="">-- Pilih Desa --</option>');
                    }
                });
            }

            // Setup handlers for kejadian fields
            handleKotaChange('#kota_kejadian', '#kecamatan_kejadian', '#desa_kejadian');
            handleKecamatanChange('#kecamatan_kejadian', '#desa_kejadian');
        });
    </script>
</body>
</html>
