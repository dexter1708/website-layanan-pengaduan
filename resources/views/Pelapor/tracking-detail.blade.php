<!DOCTYPE html>
<html>
<head>
    <title>Detail Pengaduan</title>
</head>
<body>
    <h1>Detail Pengaduan #{{ $pengaduan->id }}</h1>
    <a href="{{ route('tracking.index') }}">Kembali</a>
    
    <h2>Informasi Pengaduan</h2>
    <p>Tanggal: {{ $pengaduan->created_at->format('d/m/Y H:i') }}</p>
    <p>Status: {{ ucfirst(str_replace('_', ' ', $pengaduan->status)) }}</p>

    <h2>Data Pelapor</h2>
    @if($pengaduan->pelapor)
        <p>Nama: {{ $pengaduan->pelapor->nama_pelapor }}</p>
        <p>NIK: {{ $pengaduan->pelapor->nik }}</p>
        <p>Alamat: {{ $pengaduan->pelapor->alamat }}</p>
    @else
        <p>Data pelapor tidak tersedia</p>
    @endif

    <h2>Data Korban</h2>
    @if($pengaduan->korban && $pengaduan->korban->count() > 0)
        @foreach($pengaduan->korban as $korban)
            <div style="margin-bottom: 20px">
                <p>Nama: {{ $korban->nama }}</p>
                <p>NIK: {{ $korban->nik }}</p>
                <p>Alamat: {{ $korban->alamat }}</p>
            </div>
        @endforeach
    @else
        <p>Data korban tidak tersedia</p>
    @endif

    @if($pengaduan->pelaku && $pengaduan->pelaku->count() > 0)
        <h2>Data Pelaku</h2>
        @foreach($pengaduan->pelaku as $pelaku)
            <div style="margin-bottom: 20px">
                <p>Nama: {{ $pelaku->nama }}</p>
                <p>Alamat: {{ $pelaku->alamat }}</p>
            </div>
        @endforeach
    @endif

    <h2>Kronologi Kejadian</h2>
    <p>{{ $pengaduan->kronologi }}</p>
</body>
</html> 