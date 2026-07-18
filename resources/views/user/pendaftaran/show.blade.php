@extends('layouts.app')
@section('title', 'Detail Pendaftaran')
@section('page-title', 'Detail Pendaftaran')

@section('content')
<div class="card" style="max-width:600px;">
    <div class="card-body">
        <div class="text-center mb-4">
            <i class="bi bi-ticket-perforated fs-1 text-primary"></i>
            <h5 class="font-monospace mt-2">{{ $pendaftaran->nomor_pendaftaran }}</h5>
            <span class="badge badge-status-{{ $pendaftaran->status }} fs-6">{{ ucfirst($pendaftaran->status) }}</span>
        </div>
        <table class="table table-borderless">
            <tr><td width="140" class="text-muted">Kegiatan</td><td><strong>{{ $pendaftaran->kegiatan->nama }}</strong></td></tr>
            <tr><td class="text-muted">Tanggal</td><td>{{ $pendaftaran->kegiatan->tanggal->format('d F Y') }}</td></tr>
            <tr><td class="text-muted">Waktu</td><td>{{ $pendaftaran->kegiatan->waktu_mulai }} - {{ $pendaftaran->kegiatan->waktu_selesai }}</td></tr>
            <tr><td class="text-muted">Lokasi</td><td>{{ $pendaftaran->kegiatan->lokasi }}</td></tr>
            <tr><td class="text-muted">Biaya</td><td>{{ $pendaftaran->kegiatan->biaya > 0 ? 'Rp '.number_format($pendaftaran->kegiatan->biaya,0,',','.') : 'Gratis' }}</td></tr>
            <tr><td class="text-muted">Terdaftar</td><td>{{ $pendaftaran->tanggal_daftar->format('d F Y H:i') }}</td></tr>
            <tr><td class="text-muted">Catatan</td><td>{{ $pendaftaran->catatan ?? '-' }}</td></tr>
        </table>

        <div class="d-flex gap-2">
            <a href="{{ route('user.pendaftaran.index') }}" class="btn btn-secondary">
                <i class="bi bi-arrow-left"></i> Kembali
            </a>
            @if($pendaftaran->status === 'pending')
            <form action="{{ route('user.pendaftaran.batalkan', $pendaftaran) }}" method="POST">
                @csrf @method('PATCH')
                <button type="submit" class="btn btn-outline-danger"
                        onclick="return confirm('Batalkan pendaftaran ini?')">
                    <i class="bi bi-x-circle"></i> Batalkan Pendaftaran
                </button>
            </form>
            @endif
        </div>
    </div>
</div>
@endsection
