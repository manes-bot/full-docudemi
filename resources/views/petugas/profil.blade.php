@extends('layouts.app')

@section('title', 'Profil Petugas - DocuDemi')
@section('page-title', 'Profil Petugas')

<link rel="stylesheet" href="{{ asset('css/docudemi-ui.css') }}">
@section('content')
<div style="max-width: 800px; margin: 0 auto;">
    <div class="card">
        <div style="display: flex; gap: 20px; align-items: center; border-bottom: 1px solid var(--border-color); padding-bottom: 20px; margin-bottom: 20px;">
            <div style="width: 64px; height: 64px; background: #15803D; color: white; border-radius: 50%; display: flex; align-items: center; justify-content: center; font-size: 24px; font-weight: 700;">
                {{ strtoupper(substr($user->name, 0, 1)) }}
            </div>
            <div>
                <h2 style="font-size: 20px; font-weight: 700;">{{ $user->name }}</h2>
                <p style="font-size: 13px; color: var(--text-muted);">Petugas Kurikulum</p>
            </div>
        </div>

        @if($errors->any())
            <div style="background-color: #FEE2E2; border: 1px solid #FCA5A5; color: #B91C1C; padding: 12px 16px; border-radius: 8px; font-size: 13px; margin-bottom: 20px;">
                <ul style="margin-left: 16px;">
                    @foreach($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
        @endif

        <form action="{{ route('petugas.profil.update') }}" method="POST">
            @csrf
            <h3 style="font-size: 15px; font-weight: 700; margin-bottom: 16px;">Data Akun</h3>
            
            <div style="display: grid; grid-template-columns: 1fr 1fr; gap: 16px; margin-bottom: 24px;">
                <div>
                    <label style="font-size: 12px; font-weight: 600; color: var(--text-dark); margin-bottom: 6px; display: block;">Nama Lengkap</label>
                    <input type="text" name="name" class="form-control" value="{{ old('name', $user->name) }}" required>
                </div>
                <div>
                    <label style="font-size: 12px; font-weight: 600; color: var(--text-dark); margin-bottom: 6px; display: block;">Username</label>
                    <input type="text" name="username" class="form-control" value="{{ old('username', $user->username) }}" required>
                </div>
                <div>
                    <label style="font-size: 12px; font-weight: 600; color: var(--text-dark); margin-bottom: 6px; display: block;">Email</label>
                    <input type="email" name="email" class="form-control" value="{{ old('email', $user->email) }}" required>
                </div>
                <div>
                    <label style="font-size: 12px; font-weight: 600; color: var(--text-dark); margin-bottom: 6px; display: block;">Role</label>
                    <input type="text" class="form-control" value="Petugas Kurikulum" disabled style="background-color: #F1F5F9;">
                </div>
            </div>

            <hr style="border: 0; border-top: 1px solid var(--border-color); margin-bottom: 20px;">

            <h3 style="font-size: 15px; font-weight: 700; margin-bottom: 6px;">Keamanan / Ganti Password</h3>
            <p style="font-size: 12px; color: var(--text-muted); margin-bottom: 16px;">Kosongkan jika tidak ingin mengubah password.</p>

            <div style="display: grid; grid-template-columns: 1fr 1fr; gap: 16px; margin-bottom: 24px;">
                <div>
                    <label style="font-size: 12px; font-weight: 600; color: var(--text-dark); margin-bottom: 6px; display: block;">Password Baru</label>
                    <input type="password" name="password" class="form-control" placeholder="Minimal 6 karakter">
                </div>
                <div>
                    <label style="font-size: 12px; font-weight: 600; color: var(--text-dark); margin-bottom: 6px; display: block;">Konfirmasi Password Baru</label>
                    <input type="password" name="password_confirmation" class="form-control" placeholder="Ulangi password baru">
                </div>
            </div>

            <div style="text-align: right;">
                <button type="submit" class="btn btn-primary">
                    <i data-lucide="save" style="width: 16px;"></i> Simpan Perubahan
                </button>
            </div>
        </form>
    </div>
</div>
<script src="{{ asset('js/docudemi-ui.js') }}"></script>
@endsection