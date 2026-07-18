@extends('layouts.app')
@section('title', 'Detail Pendaftaran')
@section('page-title', 'Detail Pendaftaran')

@section('content')
<div class="card" style="max-width:600px;">
    <div class="card-header bg-white fw-semibold">Informasi Pendaftaran</div>
    <div class="card-body">
        <table class="table table-borderless">
            <tr><td width="160" class="text-muted">No. Pendaftaran</td><td><strong class="font-monospace">{{ $pendaftaran->nomor_pendaftaran }}</strong></td></tr>
            <tr><td class="text-muted">Status</td><td><span class="badge badge-status-{{ $pendaftaran->status }}">{{ ucfirst($pendaftaran->status) }}</span></td></tr>
            <tr><td class="text-muted">Peserta</td><td>{{ $pendaftaran->user->name }}<br><small class="text-muted">{{ $pendaftaran->user->email }}</small></td></tr>
            <tr><td class="text-muted">Kegiatan</td><td>{{ $pendaftaran->kegiatan->nama }}</td></tr>
            <tr><td class="text-muted">Tanggal Kegiatan</td><td>{{ $pendaftaran->kegiatan->tanggal->format('d F Y') }}</td></tr>
            <tr><td class="text-muted">Tanggal Daftar</td><td>{{ $pendaftaran->tanggal_daftar->format('d F Y H:i') }}</td></tr>
            <tr><td class="text-muted">Catatan</td><td>{{ $pendaftaran->catatan ?? '-' }}</td></tr>
        </table>

        @if($pendaftaran->status === 'pending')
        <div class="d-flex gap-2">
            <form action="{{ route('admin.pendaftaran.konfirmasi', $pendaftaran) }}" method="POST">
                @csrf @method('PATCH')
                <button type="submit" class="btn btn-success">
                    <i class="bi bi-check-circle"></i> Konfirmasi
                </button>
            </form>
            <form action="{{ route('admin.pendaftaran.tolak', $pendaftaran) }}" method="POST">
                @csrf @method('PATCH')
                <button type="submit" class="btn btn-danger" onclick="return confirm('Tolak pendaftaran ini?')">
                    <i class="bi bi-x-circle"></i> Tolak
                </button>
            </form>
        </div>
        @endif
    </div>
</div>
@endsection
