@extends('layouts.app')

@section('title', 'Kelola User')

@section('breadcrumb')
    <li class="breadcrumb-item"><a href="{{ route('dashboard') }}">Dashboard</a></li>
    <li class="breadcrumb-item active">Kelola User</li>
@endsection

@section('content')
<div class="page-header d-flex align-items-center justify-content-between">
    <h4><i class="bi bi-people me-2"></i>Kelola User</h4>
    <a href="{{ route('users.create') }}" class="btn btn-primary">
        <i class="bi bi-person-plus me-1"></i> Tambah User
    </a>
</div>

<div class="card">
    <div class="card-body p-0">
        <div class="table-responsive">
            <table class="table table-hover mb-0">
                <thead>
                    <tr>
                        <th>No</th>
                        <th>Nama</th>
                        <th>Email</th>
                        <th>Role</th>
                        <th>Terdaftar</th>
                        <th class="text-center">Aksi</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($users as $i => $user)
                        <tr>
                            <td>{{ $users->firstItem() + $i }}</td>
                            <td class="fw-semibold">{{ $user->name }}</td>
                            <td>{{ $user->email }}</td>
                            <td>
                                <span class="badge {{ $user->role === 'admin' ? 'bg-primary' : 'bg-secondary' }}">
                                    {{ ucfirst($user->role) }}
                                </span>
                            </td>
                            <td><small class="text-muted">{{ $user->created_at->format('d/m/Y') }}</small></td>
                            <td class="text-center">
                                <div class="btn-group btn-group-sm">
                                    <a href="{{ route('users.edit', $user) }}" class="btn btn-outline-warning"><i class="bi bi-pencil"></i></a>
                                    @if($user->id !== auth()->id())
                                        <form action="{{ route('users.destroy', $user) }}" method="POST" onsubmit="return confirm('Yakin hapus user ini?')">
                                            @csrf @method('DELETE')
                                            <button class="btn btn-outline-danger btn-sm"><i class="bi bi-trash"></i></button>
                                        </form>
                                    @endif
                                </div>
                            </td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    </div>
    @if($users->hasPages())
        <div class="card-footer bg-transparent">{{ $users->links() }}</div>
    @endif
</div>
@endsection
