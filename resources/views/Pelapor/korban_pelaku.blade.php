<!DOCTYPE html>
<html>
<head>
    <title>Form Data Korban dan Pelaku</title>
    <meta name="csrf-token" content="{{ csrf_token() }}">
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
        h2 {
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
        select {
            width: 100%;
            padding: 8px;
            border: 1px solid #ddd;
            border-radius: 4px;
            box-sizing: border-box;
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
        }
        .btn:hover {
            background-color: #45a049;
        }
        .error {
            color: red;
            font-size: 14px;
            margin-top: 5px;
        }
    </style>
</head>
<body>
    <div class="container">
        <h2>Form Data Korban dan Pelaku</h2>
        
        @if ($errors->any())
            <div class="error">
                <ul>
                    @foreach ($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
        @endif

        <form action="{{ route('korban-pelaku.store', $pengaduan->id) }}" method="POST">
            @csrf
            
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
                        <option value="Laki-laki">Laki-laki</option>
                        <option value="Perempuan">Perempuan</option>
                    </select>
                </div>

                <div class="form-group">
                    <label>Disabilitas:</label>
                    <select name="korban[disabilitas]" required>
                        <option value="">-- Pilih Status Disabilitas --</option>
                        <option value="Ya">Ya</option>
                        <option value="Tidak">Tidak</option>
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
                        <option value="Tidak Sekolah">Tidak Sekolah</option>
                        <option value="SD">SD</option>
                        <option value="SMP">SMP</option>
                        <option value="SMA">SMA</option>
                        <option value="D3">D3</option>
                        <option value="S1">S1</option>
                        <option value="S2">S2</option>
                        <option value="S3">S3</option>
                    </select>
                </div>

                <div class="form-group">
                    <label>Status Perkawinan:</label>
                    <select name="korban[status_perkawinan]" required>
                        <option value="">-- Pilih Status Perkawinan --</option>
                        <option value="Belum Kawin">Belum Kawin</option>
                        <option value="Kawin">Kawin</option>
                        <option value="Cerai Hidup">Cerai Hidup</option>
                        <option value="Cerai Mati">Cerai Mati</option>
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
                        <option value="Laki-laki">Laki-laki</option>
                        <option value="Perempuan">Perempuan</option>
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
                        <option value="Tidak Sekolah">Tidak Sekolah</option>
                        <option value="SD">SD</option>
                        <option value="SMP">SMP</option>
                        <option value="SMA">SMA</option>
                        <option value="D3">D3</option>
                        <option value="S1">S1</option>
                        <option value="S2">S2</option>
                        <option value="S3">S3</option>
                    </select>
                </div>

                <div class="form-group">
                    <label>Hubungan dengan Korban:</label>
                    <select name="pelaku[hubungan]" required>
                        <option value="">-- Pilih Hubungan --</option>
                        <option value="Orang Tua">Orang Tua</option>
                        <option value="Saudara">Saudara</option>
                        <option value="Pasangan">Pasangan</option>
                        <option value="Tetangga">Tetangga</option>
                        <option value="Teman">Teman</option>
                        <option value="Lainnya">Lainnya</option>
                    </select>
                </div>

                <div class="form-group">
                    <label>Kewarganegaraan:</label>
                    <select name="pelaku[kewarganegaraan]" required>
                        <option value="">-- Pilih Kewarganegaraan --</option>
                        <option value="WNI">WNI</option>
                        <option value="WNA">WNA</option>
                    </select>
                </div>
            </div>

            <button type="submit" class="btn">Simpan Data</button>
        </form>
    </div>
</body>
</html> 