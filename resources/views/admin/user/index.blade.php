@extends('layouts.app')
@section('title', 'Kelola Pengguna')
@section('page-title', 'Kelola Pengguna')

@section('content')
<div class="d-flex justify-content-between align-items-center mb-3">
    <h5 class="mb-0">Daftar Pengguna</h5>
    <a href="{{ route('admin.users.create') }}" class="btn btn-primary btn-sm">
        <i class="bi bi-person-plus"></i> Tambah Pengguna
    </a>
</div>
<div class="card">
    <div class="card-body p-0">
        <table class="table table-hover mb-0">
            <thead class="table-light">
                <tr><th>#</th><th>Nama</th><th>Email</th><th>Instansi</th><th>Peran</th><th>Status</th><th>Aksi</th></tr>
            </thead>
            <tbody>
            @forelse($users as $u)
            <tr>
                <td>{{ $loop->iteration }}</td>
                <td>{{ $u->name }}</td>
                <td>{{ $u->email }}</td>
                <td>{{ $u->institution ?? '-' }}</td>
                <td><span class="badge {{ $u->role === 'admin' ? 'bg-danger' : 'bg-primary' }}">{{ ucfirst($u->role) }}</span></td>
                <td>
                    <span class="badge {{ $u->is_active ? 'bg-success' : 'bg-secondary' }}">
                        {{ $u->is_active ? 'Aktif' : 'Nonaktif' }}
                    </span>
                </td>
                <td class="d-flex gap-1">
                    <a href="{{ route('admin.users.show', $u) }}" class="btn btn-sm btn-outline-info"><i class="bi bi-eye"></i></a>
                    <a href="{{ route('admin.users.edit', $u) }}" class="btn btn-sm btn-outline-warning"><i class="bi bi-pencil"></i></a>
                    <form action="{{ route('admin.users.toggle-active', $u) }}" method="POST">
                        @csrf @method('PATCH')
                        <button type="submit" class="btn btn-sm {{ $u->is_active ? 'btn-outline-secondary' : 'btn-outline-success' }}"
                                onclick="return confirm('{{ $u->is_active ? 'Nonaktifkan' : 'Aktifkan' }} akun ini?')">
                            <i class="bi {{ $u->is_active ? 'bi-person-dash' : 'bi-person-check' }}"></i>
                        </button>
                    </form>
                </td>
            </tr>
            @empty
            <tr><td colspan="7" class="text-center text-muted py-4">Belum ada pengguna.</td></tr>
            @endforelse
            </tbody>
        </table>
    </div>
    @if($users->hasPages())
    <div class="card-footer">{{ $users->links() }}</div>
    @endif
</div>
@endsection
