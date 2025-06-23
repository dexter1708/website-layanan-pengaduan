@extends('template.main')

@section('content_template')
<style>
    .profile-container {
        max-width: 800px;
        margin: 2rem auto;
        padding: 2rem;
        background-color: #fff;
        border: 2px dotted #a0aec0;
        border-radius: 0.5rem;
    }
    .profile-header h1 {
        font-size: 2.25rem;
        font-weight: 700;
        color: #2d3748;
    }
    .breadcrumb {
        color: #718096;
        font-size: 0.875rem;
    }
    .breadcrumb a {
        color: #4299e1;
        text-decoration: none;
    }
    .breadcrumb a:hover {
        text-decoration: underline;
    }
    .section-title {
        font-size: 1.25rem;
        font-weight: 600;
        color: #2d3748;
        border-bottom: 1px dotted #cbd5e0;
        padding-bottom: 0.5rem;
        margin-top: 1.5rem;
        margin-bottom: 1rem;
    }
    .info-grid {
        display: grid;
        grid-template-columns: repeat(1, 1fr);
        gap: 1rem;
    }
    @media (min-width: 640px) {
        .info-grid {
            grid-template-columns: repeat(2, 1fr);
        }
    }
    .info-item label {
        display: block;
        font-size: 0.875rem;
        font-weight: 500;
        color: #718096;
    }
    .info-item p {
        font-size: 1rem;
        color: #4a5568;
    }
    .edit-button-container {
        text-align: center;
        margin-top: 2rem;
        padding-top: 1.5rem;
        border-top: 1px dotted #cbd5e0;
    }
    .edit-button {
        background-color: #4299e1;
        color: #fff;
        font-weight: 600;
        padding: 0.75rem 2rem;
        border-radius: 0.375rem;
        text-decoration: none;
        transition: background-color 0.2s;
    }
    .edit-button:hover {
        background-color: #2b6cb0;
    }
    .alert {
        padding: 1rem;
        border-radius: 0.375rem;
        margin-bottom: 1rem;
    }
    .alert-success {
        background-color: #c6f6d5;
        color: #22543d;
        border: 1px solid #9ae6b4;
    }
</style>

<div class="profile-container">
    <!-- Breadcrumb -->
    <div class="breadcrumb mb-4">
        <a href="{{ url('/') }}">Homepage</a> > <span>Profil</span>
    </div>

    <!-- Header -->
    <div class="profile-header mb-6">
        <h1>Profil</h1>
    </div>

    <!-- Alert Messages -->
    @if (session('status') === 'profile-updated')
        <div class="alert alert-success">
            Profil berhasil diperbarui!
        </div>
    @endif

    @if (session('status') === 'password-updated')
        <div class="alert alert-success">
            Password berhasil diperbarui!
        </div>
    @endif

    <!-- Informasi Pribadi -->
    <div class="section-title">Informasi Pribadi</div>
    <div class="info-grid">
        <div class="info-item">
            <label>Nama Lengkap</label>
            <p>{{ $user->name }}</p>
        </div>
        <div class="info-item">
            <label>NIK</label>
            <p>{{ $user->nik ?? '-' }}</p>
        </div>
        <div class="info-item">
            <label>Email</label>
            <p>{{ $user->email }}</p>
        </div>
        <div class="info-item">
            <label>No Handphone</label>
            <p>{{ $user->no_telepon ?? '-' }}</p>
        </div>
    </div>

    <!-- Informasi Alamat -->
    <div class="section-title">Informasi Alamat</div>
    <div class="info-grid">
        @if ($user->alamat)
            <div class="info-item">
                <label>Provinsi</label>
                <p>Jawa Barat</p>
            </div>
            <div class="info-item">
                <label>Kabupaten/ Kota</label>
                <p>{{ $user->alamat->kota ?? '-' }}</p>
            </div>
            <div class="info-item">
                <label>Kecamatan</label>
                <p>{{ $user->alamat->kecamatan ?? '-' }}</p>
            </div>
            <div class="info-item">
                <label>Kelurahan</label>
                <p>{{ $user->alamat->desa ?? '-' }}</p>
            </div>
            <div class="info-item">
                <label>RT</label>
                <p>{{ $user->alamat->RT ?? '-' }}</p>
            </div>
            <div class="info-item">
                <label>RW</label>
                <p>{{ $user->alamat->RW ?? '-' }}</p>
            </div>
        @else
            <p class="text-gray-500 sm:col-span-2">Informasi alamat tidak tersedia.</p>
        @endif
    </div>

    <!-- Tombol Edit -->
    <div class="edit-button-container">
        <a href="{{ route('profile.edit') }}" class="edit-button">Edit Profil</a>
        <a href="{{ route('profile.password') }}" class="edit-button" style="margin-left: 1rem; background-color: #10b981;">Ubah Password</a>
    </div>
</div>
@endsection 