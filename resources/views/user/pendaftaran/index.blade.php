@extends('layouts.app')
@section('title', 'Pendaftaran Saya')
@section('page-title', 'Pendaftaran Saya')

@section('content')
<div class="card">
    <div class="card-body p-0">
        <table class="table table-hover mb-0">
            <thead class="table-light">
                <tr><th>No. Pendaftaran</th><th>Kegiatan</th><th>Tanggal Kegiatan</th><th>Status</th><th>Aksi</th></tr>
            </thead>
            <tbody>
            @forelse($pendaftarans as $p)
            <tr>
                <td><small class="font-monospace">{{ $p->nomor_pendaftaran }}</small></td>
                <td>{{ Str::limit($p->kegiatan->nama, 40) }}</td>
                <td><small>{{ $p->kegiatan->tanggal->format('d M Y') }}</small></td>
                <td><span class="badge badge-status-{{ $p->status }}">{{ ucfirst($p->status) }}</span></td>
                <td class="d-flex gap-1">
                    <a href="{{ route('user.pendaftaran.show', $p) }}" class="btn btn-sm btn-outline-info">
                        <i class="bi bi-eye"></i> Detail
                    </a>
                    @if($p->status === 'pending')
                    <form action="{{ route('user.pendaftaran.batalkan', $p) }}" method="POST">
                        @csrf @method('PATCH')
                        <button type="submit" class="btn btn-sm btn-outline-danger"
                                onclick="return confirm('Batalkan pendaftaran ini?')">
                            <i class="bi bi-x-circle"></i> Batalkan
                        </button>
                    </form>
                    @endif
                </td>
            </tr>
            @empty
            <tr>
                <td colspan="5" class="text-center py-5 text-muted">
                    <i class="bi bi-ticket-perforated fs-2 d-block mb-2"></i>
                    Anda belum mendaftar kegiatan apapun.
                    <br>
                    <a href="{{ route('user.kegiatan.index') }}" class="btn btn-primary btn-sm mt-2">
                        Lihat Kegiatan
                    </a>
                </td>
            </tr>
            @endforelse
            </tbody>
        </table>
    </div>
    @if($pendaftarans->hasPages())
    <div class="card-footer">{{ $pendaftarans->links() }}</div>
    @endif
</div>
@endsection
