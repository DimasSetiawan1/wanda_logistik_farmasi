@extends('layouts.app')

@section('title', 'Edit User')

@section('breadcrumb')
    <li class="breadcrumb-item"><a href="{{ route('dashboard') }}">Dashboard</a></li>
    <li class="breadcrumb-item"><a href="{{ route('users.index') }}">Kelola User</a></li>
    <li class="breadcrumb-item active">Edit</li>
@endsection

@section('content')
<div class="page-header">
    <h4>Edit User</h4>
</div>

<div class="card" style="max-width: 600px;">
    <div class="card-body">
        @if($errors->any())
            <div class="alert alert-danger">
                <ul class="mb-0">@foreach($errors->all() as $e)<li>{{ $e }}</li>@endforeach</ul>
            </div>
        @endif

        <form method="POST" action="{{ route('users.update', $user) }}">
            @csrf @method('PUT')
            <div class="mb-3">
                <label class="form-label">Nama</label>
                <input type="text" name="name" class="form-control" value="{{ old('name', $user->name) }}" required>
            </div>
            <div class="mb-3">
                <label class="form-label">Email</label>
                <input type="email" name="email" class="form-control" value="{{ old('email', $user->email) }}" required>
            </div>
            <div class="mb-3">
                <label class="form-label">Role</label>
                <select name="role" class="form-select" required>
                    <option value="apoteker" {{ old('role', $user->role) == 'apoteker' ? 'selected' : '' }}>Apoteker</option>
                    <option value="admin" {{ old('role', $user->role) == 'admin' ? 'selected' : '' }}>Admin</option>
                </select>
            </div>
            <div class="mb-3">
                <label class="form-label">Password <small class="text-muted">(kosongkan jika tidak diubah)</small></label>
                <input type="password" name="password" class="form-control">
            </div>
            <div class="mb-3">
                <label class="form-label">Konfirmasi Password</label>
                <input type="password" name="password_confirmation" class="form-control">
            </div>
            <button type="submit" class="btn btn-primary"><i class="bi bi-check-lg me-1"></i>Update</button>
            <a href="{{ route('users.index') }}" class="btn btn-outline-secondary ms-2">Batal</a>
        </form>
    </div>
</div>
@endsection
