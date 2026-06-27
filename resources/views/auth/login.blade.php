@extends('layouts.guest')

@section('title', 'Login')

@section('content')
<div class="auth-card">
    <div class="auth-header">
        <i class="bi bi-hospital" style="font-size: 2.5rem;"></i>
        <h3>RS Puspa Husada</h3>
        <p>Sistem Manajemen Logistik Farmasi</p>
    </div>
    <div class="auth-body">
        @if($errors->any())
            <div class="alert alert-danger py-2" style="font-size: 0.85rem;">
                <i class="bi bi-exclamation-circle me-1"></i>
                {{ $errors->first() }}
            </div>
        @endif

        <form method="POST" action="{{ route('login') }}">
            @csrf
            <div class="mb-3">
                <label class="form-label">Email</label>
                <div class="input-group">
                    <span class="input-group-text bg-light border-end-0"><i class="bi bi-envelope"></i></span>
                    <input type="email" name="email" class="form-control border-start-0" value="{{ old('email') }}" placeholder="email@rsph.co.id" required autofocus>
                </div>
            </div>
            <div class="mb-3">
                <label class="form-label">Password</label>
                <div class="input-group">
                    <span class="input-group-text bg-light border-end-0"><i class="bi bi-lock"></i></span>
                    <input type="password" name="password" class="form-control border-start-0" placeholder="••••••••" required>
                </div>
            </div>
            <div class="mb-3 form-check">
                <input type="checkbox" name="remember" class="form-check-input" id="remember">
                <label class="form-check-label" for="remember" style="font-size: 0.8rem;">Ingat saya</label>
            </div>
            <button type="submit" class="btn btn-auth mb-3">
                <i class="bi bi-box-arrow-in-right me-1"></i> Masuk
            </button>
        </form>
        <div class="auth-footer">
            Belum punya akun? <a href="{{ route('register') }}">Daftar di sini</a>
        </div>
    </div>
</div>
@endsection
