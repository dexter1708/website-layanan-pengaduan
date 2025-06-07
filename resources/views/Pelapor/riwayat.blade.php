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

    {{-- Form Filter --}}
    <form method="GET" action="{{ route('pengaduan.riwayat') }}">
        <label for="dari">Dari Tanggal:</label>
        <input type="date" name="dari" id="dari" value="{{ request('dari') }}">

        <label for="sampai">Sampai Tanggal:</label>
        <input type="date" name="sampai" id="sampai" value="{{ request('sampai') }}">

        <button type="submit">Filter</button>
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
                            <td>{{ $pelaku->hubungan_dengan_korban ?? '-' }}</td>
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
