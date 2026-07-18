@extends('layouts.app')
@section('title', 'Detail Pengguna')
@section('page-title', 'Detail Pengguna')

@section('content')
<div class="row g-3">
    <div class="col-md-4">
        <div class="card">
            <div class="card-body text-center py-4">
                <div class="bg-primary text-white rounded-circle d-inline-flex align-items-center justify-content-center mb-3" style="width:80px;height:80px;font-size:2rem;">
                    {{ strtoupper(substr($user->name, 0, 1)) }}
                </div>
                <h5 class="mb-1">{{ $user->name }}</h5>
                <p class="text-muted small mb-2">{{ $user->email }}</p>
                <span class="badge {{ $user->role === 'admin' ? 'bg-danger' : 'bg-primary' }}">{{ ucfirst($user->role) }}</span>
                <span class="badge {{ $user->is_active ? 'bg-success' : 'bg-secondary' }} ms-1">{{ $user->is_active ? 'Aktif' : 'Nonaktif' }}</span>
                <hr>
                <table class="table table-sm table-borderless text-start">
                    <tr><td class="text-muted">Telepon</td><td>{{ $user->phone ?? '-' }}</td></tr>
                    <tr><td class="text-muted">Instansi</td><td>{{ $user->institution ?? '-' }}</td></tr>
                    <tr><td class="text-muted">Bergabung</td><td>{{ $user->created_at->format('d M Y') }}</td></tr>
                </table>
                <a href="{{ route('admin.users.edit', $user) }}" class="btn btn-warning btn-sm w-100">
                    <i class="bi bi-pencil"></i> Edit
                </a>
            </div>
        </div>
    </div>
    <div class="col-md-8">
        <div class="card">
            <div class="card-header bg-white fw-semibold">Riwayat Pendaftaran</div>
            <div class="card-body p-0">
                <table class="table table-hover mb-0">
                    <thead class="table-light"><tr><th>Nomor</th><th>Kegiatan</th><th>Status</th><th>Tanggal</th></tr></thead>
                    <tbody>
                    @forelse($user->pendaftarans as $p)
                    <tr>
                        <td><small>{{ $p->nomor_pendaftaran }}</small></td>
                        <td>{{ Str::limit($p->kegiatan->nama, 35) }}</td>
                        <td><span class="badge badge-status-{{ $p->status }}">{{ ucfirst($p->status) }}</span></td>
                        <td><small>{{ $p->tanggal_daftar->format('d/m/Y') }}</small></td>
                    </tr>
                    @empty
                    <tr><td colspan="4" class="text-center text-muted">Belum pernah mendaftar.</td></tr>
                    @endforelse
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>
@endsection
