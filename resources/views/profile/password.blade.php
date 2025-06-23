@extends('template.main')

@section('content_template')
<style>
    .profile-container {
        max-width: 600px;
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
    .form-group {
        margin-bottom: 1.5rem;
    }
    .form-group label {
        display: block;
        font-size: 0.875rem;
        font-weight: 500;
        color: #374151;
        margin-bottom: 0.5rem;
    }
    .form-group input {
        width: 100%;
        padding: 0.75rem;
        border: 1px solid #d1d5db;
        border-radius: 0.375rem;
        font-size: 1rem;
        transition: border-color 0.2s, box-shadow 0.2s;
    }
    .form-group input:focus {
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
        background-color: #10b981;
        color: #fff;
    }
    .btn-primary:hover {
        background-color: #059669;
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
    .description {
        color: #718096;
        font-size: 0.875rem;
        margin-bottom: 1.5rem;
    }
</style>

<div class="profile-container">
    <!-- Breadcrumb -->
    <div class="breadcrumb mb-4">
        <a href="{{ url('/') }}">Homepage</a> > <a href="{{ route('profile.show') }}">Profil</a> > <span>Ubah Password</span>
    </div>

    <!-- Header -->
    <div class="profile-header mb-6">
        <h1>Ubah Password</h1>
    </div>

    <!-- Alert Messages -->
    @if (session('status') === 'password-updated')
        <div class="alert alert-success">
            Password berhasil diperbarui!
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

    @if ($errors->updatePassword->any())
        <div class="alert alert-error">
            <ul class="list-disc list-inside">
                @foreach ($errors->updatePassword->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif

    <!-- Description -->
    <div class="description">
        Pastikan akun Anda menggunakan password yang panjang dan acak untuk tetap aman.
    </div>

    <!-- Form Ubah Password -->
    <form method="POST" action="{{ route('password.update') }}">
        @csrf
        @method('put')

        <div class="form-group">
            <label for="current_password">Password Saat Ini *</label>
            <input type="password" id="current_password" name="current_password" required autocomplete="current-password">
            @error('current_password', 'updatePassword')
                <div class="error">{{ $message }}</div>
            @enderror
        </div>

        <div class="form-group">
            <label for="password">Password Baru *</label>
            <input type="password" id="password" name="password" required autocomplete="new-password">
            @error('password', 'updatePassword')
                <div class="error">{{ $message }}</div>
            @enderror
        </div>

        <div class="form-group">
            <label for="password_confirmation">Konfirmasi Password Baru *</label>
            <input type="password" id="password_confirmation" name="password_confirmation" required autocomplete="new-password">
            @error('password_confirmation', 'updatePassword')
                <div class="error">{{ $message }}</div>
            @enderror
        </div>

        <!-- Tombol Aksi -->
        <div class="button-container">
            <button type="submit" class="btn btn-primary">Simpan Password</button>
            <a href="{{ route('profile.show') }}" class="btn btn-secondary">Batal</a>
        </div>
    </form>
</div>
@endsection 