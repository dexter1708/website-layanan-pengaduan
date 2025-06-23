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
    .form-grid {
        display: grid;
        grid-template-columns: repeat(1, 1fr);
        gap: 1rem;
    }
    @media (min-width: 640px) {
        .form-grid {
            grid-template-columns: repeat(2, 1fr);
        }
    }
    .form-group {
        margin-bottom: 1rem;
    }
    .form-group label {
        display: block;
        font-size: 0.875rem;
        font-weight: 500;
        color: #374151;
        margin-bottom: 0.5rem;
    }
    .form-group input, .form-group select {
        width: 100%;
        padding: 0.75rem;
        border: 1px solid #d1d5db;
        border-radius: 0.375rem;
        font-size: 1rem;
        transition: border-color 0.2s, box-shadow 0.2s;
    }
    .form-group input:focus, .form-group select:focus {
        outline: none;
        border-color: #4299e1;
        box-shadow: 0 0 0 3px rgba(66, 153, 225, 0.1);
    }
    .form-group .error {
        color: #e53e3e;
        font-size: 0.875rem;
        margin-top: 0.25rem;
    }
    .button-container {
        display: flex;
        gap: 1rem;
        justify-content: center;
        margin-top: 2rem;
        padding-top: 1.5rem;
        border-top: 1px dotted #cbd5e0;
    }
    .btn {
        padding: 0.75rem 2rem;
        border-radius: 0.375rem;
        font-weight: 600;
        text-decoration: none;
        transition: all 0.2s;
        border: none;
        cursor: pointer;
        font-size: 1rem;
    }
    .btn-primary {
        background-color: #4299e1;
        color: #fff;
    }
    .btn-primary:hover {
        background-color: #2b6cb0;
    }
    .btn-secondary {
        background-color: #718096;
        color: #fff;
    }
    .btn-secondary:hover {
        background-color: #4a5568;
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
    .alert-error {
        background-color: #fed7d7;
        color: #742a2a;
        border: 1px solid #feb2b2;
    }
</style>

<div class="profile-container">
    <!-- Breadcrumb -->
    <div class="breadcrumb mb-4">
        <a href="{{ url('/') }}">Homepage</a> > <span>Edit Profil</span>
    </div>

    <!-- Header -->
    <div class="profile-header mb-6">
        <h1>Edit Profil</h1>
    </div>

    <!-- Alert Messages -->
    @if (session('status') === 'profile-updated')
        <div class="alert alert-success">
            Profil berhasil diperbarui!
        </div>
    @endif

    @if ($errors->any())
        <div class="alert alert-error">
            <ul class="list-disc list-inside">
                @foreach ($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif

    <!-- Form Edit Profile -->
    <form method="POST" action="{{ route('profile.update') }}">
        @csrf
        @method('patch')

        <!-- Informasi Pribadi -->
        <div class="section-title">Informasi Pribadi</div>
        <div class="form-grid">
            <div class="form-group">
                <label for="name">Nama Lengkap *</label>
                <input type="text" id="name" name="name" value="{{ old('name', $user->name) }}" required>
                @error('name')
                    <div class="error">{{ $message }}</div>
                @enderror
            </div>

            <div class="form-group">
                <label for="nik">NIK *</label>
                <input type="text" id="nik" name="nik" value="{{ old('nik', $user->nik) }}" maxlength="16" required>
                @error('nik')
                    <div class="error">{{ $message }}</div>
                @enderror
            </div>

            <div class="form-group">
                <label for="email">Email *</label>
                <input type="email" id="email" name="email" value="{{ old('email', $user->email) }}" required>
                @error('email')
                    <div class="error">{{ $message }}</div>
                @enderror
            </div>

            <div class="form-group">
                <label for="no_telepon">No Handphone</label>
                <input type="text" id="no_telepon" name="no_telepon" value="{{ old('no_telepon', $user->no_telepon) }}" placeholder="08xxxxxxxxxx">
                @error('no_telepon')
                    <div class="error">{{ $message }}</div>
                @enderror
            </div>
        </div>

        <!-- Tombol Aksi -->
        <div class="button-container">
            <button type="submit" class="btn btn-primary">Simpan Perubahan</button>
            <a href="{{ route('profile.show') }}" class="btn btn-secondary">Batal</a>
        </div>
    </form>
</div>

<script>
    // Auto-format NIK input
    document.getElementById('nik').addEventListener('input', function(e) {
        let value = e.target.value.replace(/\D/g, '');
        if (value.length > 16) {
            value = value.substring(0, 16);
        }
        e.target.value = value;
    });

    // Auto-format phone number
    document.getElementById('no_telepon').addEventListener('input', function(e) {
        let value = e.target.value.replace(/\D/g, '');
        if (value.length > 13) {
            value = value.substring(0, 13);
        }
        e.target.value = value;
    });
</script>
@endsection
