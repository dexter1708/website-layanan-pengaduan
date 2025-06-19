<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Riwayat Pengaduan</title>
    <style>
        body { font-family: Arial, sans-serif; margin: 20px; }
        table { border-collapse: collapse; width: 100%; margin-bottom: 40px; }
        th, td { border: 1px solid #ddd; padding: 8px; vertical-align: top; }
        th { background-color: #f2f2f2; text-align: left; }
        form { margin-bottom: 30px; }
    </style>
</head>
<body>

    <h2>Riwayat Pengaduan Anda</h2>

    {{-- Navigation Buttons --}}
    <div style="margin-bottom: 20px;">
        <a href="{{ route('pengaduan.create') }}" style="background-color: #4CAF50; color: white; padding: 10px 20px; text-decoration: none; border-radius: 4px; margin-right: 10px;">
            📝 Buat Pengaduan Baru
        </a>
        <a href="{{ route('dashboard') }}" style="background-color: #6c757d; color: white; padding: 10px 20px; text-decoration: none; border-radius: 4px;">
            🏠 Kembali ke Dashboard
        </a>
    </div>

    {{-- Form Filter --}}
    <form method="GET" action="{{ route('pengaduan.riwayat') }}" style="background-color: #f8f9fa; padding: 20px; border-radius: 8px; margin-bottom: 30px;">
        <h3 style="margin-top: 0; color: #333;">🔍 Filter Riwayat</h3>
        <div style="display: flex; gap: 15px; align-items: center; flex-wrap: wrap;">
            <div>
                <label for="dari" style="display: block; margin-bottom: 5px; font-weight: bold;">Dari Tanggal:</label>
                <input type="date" name="dari" id="dari" value="{{ request('dari') }}" style="padding: 8px; border: 1px solid #ddd; border-radius: 4px;">
            </div>
            <div>
                <label for="sampai" style="display: block; margin-bottom: 5px; font-weight: bold;">Sampai Tanggal:</label>
                <input type="date" name="sampai" id="sampai" value="{{ request('sampai') }}" style="padding: 8px; border: 1px solid #ddd; border-radius: 4px;">
            </div>
            <div style="align-self: end;">
                <button type="submit" style="background-color: #007bff; color: white; padding: 8px 16px; border: none; border-radius: 4px; cursor: pointer;">
                    🔍 Filter
                </button>
            </div>
        </div>
    </form>

    @forelse ($pengaduans as $pengaduan)
        <h3>Pengaduan #{{ $pengaduan->id }} - Status: <strong>{{ ucfirst($pengaduan->status) }}</strong></h3>
        <p><strong>Jenis Kasus:</strong> {{ $pengaduan->jenis_kasus }}</p>
        <p><strong>Tanggal Kejadian:</strong> {{ $pengaduan->tanggal_kejadian }}</p>
        <p><strong>Kronologi:</strong> {{ $pengaduan->kronologi }}</p>

        {{-- Data Korban --}}
        <h4>Data Korban:</h4>
        @if ($pengaduan->korban->count())
            <table>
                <thead>
                    <tr>
                        <th>Nama</th>
                        <th>Jenis Kelamin</th>
                        <th>Usia</th>
                        <th>Pendidikan</th>
                        <th>Pekerjaan</th>
                        <th>Status Perkawinan</th>
                        <th>Disabilitas</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach ($pengaduan->korban as $korban)
                        <tr>
                            <td>{{ $korban->nama }}</td>
                            <td>{{ $korban->jenis_kelamin }}</td>
                            <td>{{ $korban->usia ?? '-' }}</td>
                            <td>{{ $korban->pendidikan ?? '-' }}</td>
                            <td>{{ $korban->pekerjaan ?? '-' }}</td>
                            <td>{{ $korban->status_perkawinan ?? '-' }}</td>
                            <td>{{ $korban->disabilitas ?? '-' }}</td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        @else
            <p>Tidak ada data korban.</p>
        @endif

        {{-- Data Pelaku --}}
        <h4>Data Pelaku:</h4>
        @if ($pengaduan->pelaku->count())
            <table>
                <thead>
                    <tr>
                        <th>Nama</th>
                        <th>Jenis Kelamin</th>
                        <th>Usia</th>
                        <th>Pendidikan</th>
                        <th>Pekerjaan</th>
                        <th>Hubungan dengan Korban</th>
                        <th>Kewarganegaraan</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach ($pengaduan->pelaku as $pelaku)
                        <tr>
                            <td>{{ $pelaku->nama }}</td>
                            <td>{{ $pelaku->jenis_kelamin }}</td>
                            <td>{{ $pelaku->usia ?? '-' }}</td>
                            <td>{{ $pelaku->pendidikan ?? '-' }}</td>
                            <td>{{ $pelaku->pekerjaan ?? '-' }}</td>
                            <td>{{ $pelaku->hubungan ?? '-' }}</td>
                            <td>{{ $pelaku->kewarganegaraan ?? '-' }}</td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        @else
            <p>Tidak ada data pelaku.</p>
        @endif

        <hr>
    @empty
        <p>Tidak ada riwayat pengaduan ditemukan.</p>
    @endforelse

</body>
</html>
