<!DOCTYPE html>
<html>
<head>
    <title>Detail Pengaduan</title>
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
        h1, h2 {
            color: #333;
            border-bottom: 2px solid #4CAF50;
            padding-bottom: 10px;
            margin-bottom: 20px;
        }
        .timeline {
            position: relative;
            padding-left: 30px;
        }
        .timeline::before {
            content: '';
            position: absolute;
            left: 15px;
            top: 0;
            bottom: 0;
            width: 2px;
            background: #4CAF50;
        }
        .timeline-item {
            position: relative;
            margin-bottom: 20px;
            padding: 15px;
            background: #f9f9f9;
            border-radius: 8px;
            border-left: 4px solid #4CAF50;
        }
        .timeline-item::before {
            content: '';
            position: absolute;
            left: -22px;
            top: 20px;
            width: 12px;
            height: 12px;
            border-radius: 50%;
            background: #4CAF50;
            border: 3px solid white;
        }
        .timeline-status {
            font-weight: bold;
            color: #4CAF50;
            margin-bottom: 5px;
        }
        .timeline-time {
            color: #666;
            font-size: 0.9em;
            margin-bottom: 5px;
        }
        .timeline-user {
            color: #333;
            font-size: 0.9em;
            margin-bottom: 5px;
        }
        .timeline-keterangan {
            color: #555;
            font-style: italic;
        }
        .btn-back {
            background-color: #4CAF50;
            color: white;
            padding: 10px 20px;
            text-decoration: none;
            border-radius: 4px;
            display: inline-block;
            margin-bottom: 20px;
        }
        .btn-back:hover {
            background-color: #45a049;
        }
    </style>
</head>
<body>
    <div class="container">
        <h1>Detail Pengaduan #{{ $pengaduan->id }}</h1>
        <a href="{{ route('tracking.index') }}" class="btn-back">← Kembali</a>
        
        <div class="section">
            <h2>Informasi Pengaduan</h2>
            <p><strong>Tanggal:</strong> {{ $pengaduan->created_at->format('d/m/Y H:i') }}</p>
            <p><strong>Status Saat Ini:</strong> {{ ucfirst(str_replace('_', ' ', $pengaduan->status)) }}</p>
        </div>

        <div class="section">
            <h2>Riwayat Perubahan Status</h2>
            <div class="timeline">
                @forelse($pengaduan->historiTracking as $histori)
                    <div class="timeline-item">
                        <div class="timeline-status">
                            @if($histori->status_sebelum)
                                {{ ucfirst(str_replace('_', ' ', $histori->status_sebelum)) }} → {{ ucfirst(str_replace('_', ' ', $histori->status_sesudah)) }}
                            @else
                                Status: {{ ucfirst(str_replace('_', ' ', $histori->status_sesudah)) }}
                            @endif
                        </div>
                        <div class="timeline-time">
                            {{ $histori->created_at->format('d/m/Y H:i') }}
                        </div>
                        @if($histori->changedByUser)
                            <div class="timeline-user">
                                Diubah oleh: {{ $histori->changedByUser->name }}
                            </div>
                        @endif
                        @if($histori->keterangan)
                            <div class="timeline-keterangan">
                                Keterangan: {{ $histori->keterangan }}
                            </div>
                        @endif
                    </div>
                @empty
                    <p>Belum ada riwayat perubahan status</p>
                @endforelse
            </div>
        </div>

        <div class="section">
            <h2>Data Pelapor</h2>
            @if($pengaduan->pelapor)
                <p><strong>Nama:</strong> {{ $pengaduan->pelapor->nama_pelapor }}</p>
                <p><strong>NIK:</strong> {{ $pengaduan->pelapor->nik }}</p>
                <p><strong>Alamat:</strong> {{ $pengaduan->pelapor->alamat }}</p>
            @else
                <p>Data pelapor tidak tersedia</p>
            @endif
        </div>

        <div class="section">
            <h2>Data Korban</h2>
            @if($pengaduan->korban && $pengaduan->korban->count() > 0)
                @foreach($pengaduan->korban as $korban)
                    <div style="margin-bottom: 20px; padding: 15px; background: #f9f9f9; border-radius: 4px;">
                        <p><strong>Nama:</strong> {{ $korban->nama }}</p>
                        <p><strong>NIK:</strong> {{ $korban->nik }}</p>
                        <p><strong>Alamat:</strong> {{ $korban->alamat }}</p>
                    </div>
                @endforeach
            @else
                <p>Data korban tidak tersedia</p>
            @endif
        </div>

        @if($pengaduan->pelaku && $pengaduan->pelaku->count() > 0)
            <div class="section">
                <h2>Data Pelaku</h2>
                @foreach($pengaduan->pelaku as $pelaku)
                    <div style="margin-bottom: 20px; padding: 15px; background: #f9f9f9; border-radius: 4px;">
                        <p><strong>Nama:</strong> {{ $pelaku->nama }}</p>
                        <p><strong>Alamat:</strong> {{ $pelaku->alamat }}</p>
                    </div>
                @endforeach
            </div>
        @endif

        <div class="section">
            <h2>Kronologi Kejadian</h2>
            <p>{{ $pengaduan->kronologi }}</p>
        </div>
    </div>
</body>
</html> 