<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Status Pengaduan</title>
    <style>
        body { font-family: Arial, sans-serif; margin: 20px; }
        table { border-collapse: collapse; width: 100%; }
        th, td { border: 1px solid #ddd; padding: 8px; text-align: left; }
        th { background-color: #f2f2f2; }
        .status-badge {
            padding: 4px 10px;
            border-radius: 5px;
            color: white;
            font-weight: bold;
        }
        .menunggu { background-color: orange; }
        .diproses { background-color: blue; }
        .selesai { background-color: green; }
        .ditolak { background-color: red; }
    </style>
</head>
<body>

    <h2>Status Pengaduan Anda</h2>

    @if ($pengaduans->count())
        <table>
            <thead>
                <tr>
                    <th>ID Pengaduan</th>
                    <th>Jenis Kasus</th>
                    <th>Tanggal Kejadian</th>
                    <th>Status</th>
                </tr>
            </thead>
            <tbody>
                @foreach ($pengaduans as $pengaduan)
                    <tr>
                        <td>{{ $pengaduan->id }}</td>
                        <td>{{ $pengaduan->jenis_kasus }}</td>
                        <td>{{ $pengaduan->tanggal_kejadian }}</td>
                        <td>
                            <span class="status-badge {{ $pengaduan->status }}">
                                {{ ucfirst($pengaduan->status) }}
                            </span>
                        </td>
                    </tr>
                @endforeach
            </tbody>
        </table>
    @else
        <p>Tidak ada pengaduan yang ditemukan.</p>
    @endif

</body>
</html>
