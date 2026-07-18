@extends('layouts.app')
@section('title', 'Kelola Pendaftaran')
@section('page-title', 'Kelola Pendaftaran')

@section('content')
<div class="card">
    <div class="card-body p-0">
        <table class="table table-hover mb-0">
            <thead class="table-light">
                <tr><th>#</th><th>Nomor</th><th>Peserta</th><th>Kegiatan</th><th>Status</th><th>Tanggal Daftar</th><th>Aksi</th></tr>
            </thead>
            <tbody>
            @forelse($pendaftarans as $p)
            <tr>
                <td>{{ $loop->iteration }}</td>
                <td><small class="font-monospace">{{ $p->nomor_pendaftaran }}</small></td>
                <td>{{ $p->user->name }}<br><small class="text-muted">{{ $p->user->email }}</small></td>
                <td>{{ Str::limit($p->kegiatan->nama, 35) }}</td>
                <td><span class="badge badge-status-{{ $p->status }}">{{ ucfirst($p->status) }}</span></td>
                <td><small>{{ $p->tanggal_daftar->format('d/m/Y H:i') }}</small></td>
                <td class="d-flex gap-1">
                    <a href="{{ route('admin.pendaftaran.show', $p) }}" class="btn btn-sm btn-outline-info"><i class="bi bi-eye"></i></a>
                    @if($p->status === 'pending')
                        <form action="{{ route('admin.pendaftaran.konfirmasi', $p) }}" method="POST">
                            @csrf @method('PATCH')
                            <button type="submit" class="btn btn-sm btn-outline-success" onclick="return confirm('Konfirmasi pendaftaran ini?')">
                                <i class="bi bi-check-lg"></i>
                            </button>
                        </form>
                        <form action="{{ route('admin.pendaftaran.tolak', $p) }}" method="POST">
                            @csrf @method('PATCH')
                            <button type="submit" class="btn btn-sm btn-outline-danger" onclick="return confirm('Tolak pendaftaran ini?')">
                                <i class="bi bi-x-lg"></i>
                            </button>
                        </form>
                    @endif
                </td>
            </tr>
            @empty
            <tr><td colspan="7" class="text-center text-muted py-4">Belum ada pendaftaran.</td></tr>
            @endforelse
            </tbody>
        </table>
    </div>
    @if($pendaftarans->hasPages())
    <div class="card-footer">{{ $pendaftarans->links() }}</div>
    @endif
</div>
@endsection
