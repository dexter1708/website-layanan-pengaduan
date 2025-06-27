@extends('template.main')
@section('content_template')

<style>
    .timeline {
        position: relative;
        padding-left: 40px;
    }
    .timeline::before {
        content: '';
        position: absolute;
        left: 10px;
        top: 10px;
        bottom: 10px;
        width: 4px;
        background-color: #e5e7eb; /* gray-200 */
        border-radius: 2px;
    }
    .timeline-item {
        position: relative;
        margin-bottom: 2rem;
    }
    .timeline-item .icon {
        position: absolute;
        left: -8px;
        top: 0;
        width: 24px;
        height: 24px;
        border-radius: 50%;
        display: flex;
        align-items: center;
        justify-content: center;
        border: 4px solid #fff;
    }
    .icon-menunggu { background-color: #f59e0b; } /* amber-500 */
    .icon-proses, .icon-diproses { background-color: #3b82f6; } /* blue-500 */
    .icon-selesai { background-color: #10b981; } /* emerald-500 */
    .icon-ditolak { background-color: #ef4444; } /* red-500 */
    .icon-default { background-color: #6b7280; } /* gray-500 */
</style>

<section class="bg-gray-100 py-8 px-4 sm:px-6 lg:px-8">
    <div class="max-w-4xl mx-auto">
        <!-- Breadcrumb -->
        <nav class="text-sm text-gray-600 font-semibold mb-6" aria-label="Breadcrumb">
            <ol class="flex items-center space-x-2">
                <li><a href="{{ url('/') }}" class="text-blue-600 hover:underline">Homepage</a></li>
                <li class="text-gray-600">/</li>
                <li><a href="{{ route('tracking.index') }}" class="text-blue-600 hover:underline">Track Pengaduan</a></li>
                <li class="text-gray-600">/</li>
                <li class="text-gray-500">Riwayat Pengaduan</li>
            </ol>
        </nav>

        <div class="bg-white rounded-lg shadow-md">
            <!-- Header -->
            <div class="p-6 border-b border-gray-200 flex justify-between items-center">
                <div>
                    <h2 class="text-2xl font-bold text-gray-800">Riwayat Pengaduan #{{ $pengaduan->id }}</h2>
                    <p class="text-sm text-gray-600 mt-1">Status Saat Ini: 
                        <span class="font-semibold px-2 py-1 rounded-full 
                            @if($pengaduan->status === 'selesai') bg-green-100 text-green-800
                            @elseif($pengaduan->status === 'ditolak') bg-red-100 text-red-800
                            @elseif($pengaduan->status === 'diproses') bg-blue-100 text-blue-800
                            @else bg-yellow-100 text-yellow-800
                            @endif">
                            {{ ucfirst(str_replace('_', ' ', $pengaduan->status ?? 'Menunggu')) }}
                        </span>
                    </p>
                </div>
                <div class="flex items-center gap-4">
                    @if(Auth::user()->role === 'staff')
                        <a href="{{ route('staff.tracking.edit', $pengaduan->id) }}" class="bg-green-600 text-white px-5 py-2 rounded-lg hover:bg-green-700 transition-colors font-semibold text-sm">
                            Update Status
                        </a>
                    @endif
                    <a href="{{ route('tracking.index') }}" class="bg-blue-600 text-white px-5 py-2 rounded-lg hover:bg-blue-700 transition-colors font-semibold text-sm">
                        Kembali ke Daftar
                    </a>
                </div>
            </div>

            <!-- Detail Content -->
            <div class="p-8">
                <div class="timeline">
                    @forelse($pengaduan->historiTracking as $histori)
                        <div class="timeline-item">
                            @php
                                $iconClass = 'icon-' . strtolower($histori->status_sesudah);
                            @endphp
                            <div class="icon {{ $iconClass }}">
                                <svg class="w-4 h-4 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"></path></svg>
                            </div>
                            <div class="ml-10">
                                <h3 class="font-bold text-lg text-gray-800">
                                    Status: {{ ucfirst(str_replace('_', ' ', $histori->status_sesudah)) }}
                                </h3>
                                <p class="text-sm text-gray-500 mb-2">{{ $histori->created_at->format('d F Y, H:i') }}</p>
                                @if($histori->keterangan)
                                    <p class="bg-gray-50 p-3 rounded-md text-gray-700 italic">"{{ $histori->keterangan }}"</p>
                                @endif
                            </div>
                            <br>
                            <br>
                        </div>
                        <br>
                    @empty
                        <p class="ml-10 text-gray-500">Belum ada riwayat perubahan status untuk pengaduan ini.</p>
                    @endforelse
                </div>
            </div>
        </div>
    </div>
</section>

@endsection 