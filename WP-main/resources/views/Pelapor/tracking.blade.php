<!DOCTYPE html>
<html>
<head>
    <title>Tracking Pengaduan</title>
</head>
<body>
    <h1>Tracking Pengaduan</h1>
    
    @if(session('success'))
        <div style="color: green">{{ session('success') }}</div>
    @endif

    <table border="1">
        <tr>
            <th>No. Pengaduan</th>
            <th>Tanggal</th>
            <th>Pelapor</th>
            <th>Korban</th>
            <th>Status</th>
            <th>Aksi</th>
        </tr>
        @forelse($pengaduans as $pengaduan)
            <tr>
                <td>{{ $pengaduan->id }}</td>
                <td>{{ $pengaduan->created_at->format('d/m/Y') }}</td>
                <td>{{ $pengaduan->pelapor ? $pengaduan->pelapor->nama_pelapor : '-' }}</td>
                <td>{{ $pengaduan->korban && $pengaduan->korban->count() > 0 ? $pengaduan->korban->first()->nama : '-' }}</td>
                <td>{{ ucfirst(str_replace('_', ' ', $pengaduan->status)) }}</td>
                <td>
                    <a href="{{ route('pengaduan.show', $pengaduan->id) }}">Detail Pengaduan</a>
                    <a href="{{ route('tracking.show', $pengaduan->id) }}">Tracking</a>
                    @if(Auth::user()->role !== 'pelapor')
                        <a href="{{ route('staff.tracking.edit', $pengaduan->id) }}">Update Status</a>
                    @endif
                </td>
            </tr>
        @empty
            <tr>
                <td colspan="6">Tidak ada data pengaduan</td>
            </tr>
        @endforelse
    </table>
</body>
</html> 