@extends('layouts.app')
@section('title', 'Detail Kegiatan')
@section('page-title', 'Detail Kegiatan')

@section('content')
<div class="row g-3">
    <div class="col-lg-5">
        <div class="card">
            <div class="card-header bg-white fw-semibold">Informasi Kegiatan</div>
            <div class="card-body">
                <h5>{{ $kegiatan->nama }}</h5>
                <p class="text-muted">{{ $kegiatan->deskripsi }}</p>
                <table class="table table-sm table-borderless">
                    <tr><td class="text-muted" width="120">Lokasi</td><td>{{ $kegiatan->lokasi }}</td></tr>
                    <tr><td class="text-muted">Tanggal</td><td>{{ $kegiatan->tanggal->format('d F Y') }}</td></tr>
                    <tr><td class="text-muted">Waktu</td><td>{{ $kegiatan->waktu_mulai }} - {{ $kegiatan->waktu_selesai }}</td></tr>
                    <tr><td class="text-muted">Penyelenggara</td><td>{{ $kegiatan->penyelenggara }}</td></tr>
                    <tr><td class="text-muted">Kuota</td><td>{{ $kegiatan->sisaKuota() }} sisa dari {{ $kegiatan->kuota }}</td></tr>
                    <tr><td class="text-muted">Biaya</td><td>{{ $kegiatan->biaya > 0 ? 'Rp '.number_format($kegiatan->biaya,0,',','.') : 'Gratis' }}</td></tr>
                    <tr><td class="text-muted">Status</td><td>
                        @if($kegiatan->status === 'aktif') <span class="badge bg-success">Aktif</span>
                        @elseif($kegiatan->status === 'nonaktif') <span class="badge bg-secondary">Nonaktif</span>
                        @else <span class="badge bg-info">Selesai</span>
                        @endif
                    </td></tr>
                </table>
                <a href="{{ route('admin.kegiatan.edit', $kegiatan) }}" class="btn btn-warning btn-sm">
                    <i class="bi bi-pencil"></i> Edit
                </a>
            </div>
        </div>
    </div>
    <div class="col-lg-7">
        <div class="card">
            <div class="card-header bg-white fw-semibold">
                Daftar Peserta ({{ $kegiatan->pendaftarans->count() }})
            </div>
            <div class="card-body p-0">
                <table class="table table-hover mb-0">
                    <thead class="table-light">
                        <tr><th>Nomor</th><th>Nama</th><th>Email</th><th>Status</th><th>Tanggal Daftar</th></tr>
                    </thead>
                    <tbody>
                    @forelse($kegiatan->pendaftarans as $p)
                    <tr>
                        <td><small>{{ $p->nomor_pendaftaran }}</small></td>
                        <td>{{ $p->user->name }}</td>
                        <td><small>{{ $p->user->email }}</small></td>
                        <td><span class="badge badge-status-{{ $p->status }}">{{ ucfirst($p->status) }}</span></td>
                        <td><small>{{ $p->tanggal_daftar->format('d/m/Y H:i') }}</small></td>
                    </tr>
                    @empty
                    <tr><td colspan="5" class="text-center text-muted">Belum ada peserta.</td></tr>
                    @endforelse
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>
@endsection
