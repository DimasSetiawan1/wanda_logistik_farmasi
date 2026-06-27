@extends('layouts.guest')

@section('title', 'Register')

@section('content')
<div class="auth-card">
    <div class="auth-header">
        <i class="bi bi-hospital" style="font-size: 2.5rem;"></i>
        <h3>Daftar Akun</h3>
        <p>Sistem Manajemen Logistik Farmasi RSPH</p>
    </div>
    <div class="auth-body">
        @if($errors->any())
            <div class="alert alert-danger py-2" style="font-size: 0.85rem;">
                <ul class="mb-0 ps-3">
                    @foreach($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
        @endif

        <form method="POST" action="{{ route('register') }}">
            @csrf
            <div class="mb-3">
                <label class="form-label">Nama Lengkap</label>
                <input type="text" name="name" class="form-control" value="{{ old('name') }}" placeholder="Nama lengkap" required>
            </div>
            <div class="mb-3">
                <label class="form-label">Email</label>
                <input type="email" name="email" class="form-control" value="{{ old('email') }}" placeholder="email@rsph.co.id" required>
            </div>
            <div class="mb-3">
                <label class="form-label">Password</label>
                <input type="password" name="password" class="form-control" placeholder="Min 8 karakter" required>
            </div>
            <div class="mb-3">
                <label class="form-label">Konfirmasi Password</label>
                <input type="password" name="password_confirmation" class="form-control" placeholder="Ulangi password" required>
            </div>
            <button type="submit" class="btn btn-auth mb-3">
                <i class="bi bi-person-plus me-1"></i> Daftar
            </button>
        </form>
        <div class="auth-footer">
            Sudah punya akun? <a href="{{ route('login') }}">Masuk di sini</a>
        </div>
    </div>
</div>
@endsection
