<!DOCTYPE html>
<html>
<head>
    <title>Update Status Pengaduan</title>
</head>
<body>
    <h1>Update Status Pengaduan #{{ $pengaduan->id }}</h1>
    <a href="{{ route('tracking.index') }}">Kembali</a>

    <form action="{{ route('staff.tracking.update-status', $pengaduan->id) }}" method="POST">
        @csrf
        @method('PUT')

        <div>
            <label for="status">Status Pengaduan:</label><br>
            <select id="status" name="status">
                <option value="menunggu" {{ $pengaduan->status == 'menunggu' ? 'selected' : '' }}>Menunggu</option>
                <option value="diproses" {{ $pengaduan->status == 'diproses' ? 'selected' : '' }}>Diproses</option>
                <option value="di_reskrim" {{ $pengaduan->status == 'di_reskrim' ? 'selected' : '' }}>Di Reskrim</option>
                <option value="di_kejaksaan" {{ $pengaduan->status == 'di_kejaksaan' ? 'selected' : '' }}>Di Kejaksaan</option>
                <option value="selesai" {{ $pengaduan->status == 'selesai' ? 'selected' : '' }}>Selesai</option>
            </select>
            @error('status')
                <div style="color: red">{{ $message }}</div>
            @enderror
        </div>

        <div style="margin-top: 10px">
            <label for="keterangan">Keterangan (Opsional):</label><br>
            <textarea id="keterangan" name="keterangan" rows="3" cols="50">{{ old('keterangan') }}</textarea>
            @error('keterangan')
                <div style="color: red">{{ $message }}</div>
            @enderror
        </div>

        <div style="margin-top: 10px">
            <button type="submit">Update Status</button>
        </div>
    </form>
</body>
</html> 