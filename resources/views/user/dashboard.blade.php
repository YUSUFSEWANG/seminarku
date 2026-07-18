@extends('layouts.app')
@section('title', 'Dashboard')
@section('page-title', 'Dashboard')

@section('content')
<div class="row g-3 mb-4">
    <div class="col-md-4">
        <div class="card stat-card border-primary">
            <div class="card-body py-3 d-flex justify-content-between align-items-center">
                <div>
                    <p class="text-muted small mb-0">Total Pendaftaran</p>
                    <h3 class="fw-bold mb-0">{{ $stats['total_daftar'] }}</h3>
                </div>
                <i class="bi bi-ticket-perforated text-primary fs-2 opacity-50"></i>
            </div>
        </div>
    </div>
    <div class="col-md-4">
        <div class="card stat-card border-success">
            <div class="card-body py-3 d-flex justify-content-between align-items-center">
                <div>
                    <p class="text-muted small mb-0">Dikonfirmasi</p>
                    <h3 class="fw-bold mb-0">{{ $stats['dikonfirmasi'] }}</h3>
                </div>
                <i class="bi bi-check-circle text-success fs-2 opacity-50"></i>
            </div>
        </div>
    </div>
    <div class="col-md-4">
        <div class="card stat-card border-warning">
            <div class="card-body py-3 d-flex justify-content-between align-items-center">
                <div>
                    <p class="text-muted small mb-0">Menunggu Konfirmasi</p>
                    <h3 class="fw-bold mb-0">{{ $stats['pending'] }}</h3>
                </div>
                <i class="bi bi-hourglass text-warning fs-2 opacity-50"></i>
            </div>
        </div>
    </div>
</div>

<div class="row g-3">
    <div class="col-lg-7">
        <div class="card">
            <div class="card-header bg-white fw-semibold d-flex justify-content-between align-items-center">
                Pendaftaran Saya
                <a href="{{ route('user.pendaftaran.index') }}" class="btn btn-sm btn-outline-primary">Lihat Semua</a>
            </div>
            <div class="card-body p-0">
                <table class="table table-hover mb-0">
                    <thead class="table-light"><tr><th>Nomor</th><th>Kegiatan</th><th>Status</th></tr></thead>
                    <tbody>
                    @forelse($pendaftaranSaya as $p)
                    <tr>
                        <td><small class="font-monospace">{{ $p->nomor_pendaftaran }}</small></td>
                        <td>{{ Str::limit($p->kegiatan->nama, 35) }}</td>
                        <td><span class="badge badge-status-{{ $p->status }}">{{ ucfirst($p->status) }}</span></td>
                    </tr>
                    @empty
                    <tr><td colspan="3" class="text-center text-muted py-3">Belum ada pendaftaran.</td></tr>
                    @endforelse
                    </tbody>
                </table>
            </div>
        </div>
    </div>
    <div class="col-lg-5">
        <div class="card">
            <div class="card-header bg-white fw-semibold d-flex justify-content-between align-items-center">
                Kegiatan Mendatang
                <a href="{{ route('user.kegiatan.index') }}" class="btn btn-sm btn-outline-primary">Lihat Semua</a>
            </div>
            <div class="card-body">
                @forelse($kegiatanTerbaru as $k)
                <div class="border rounded p-3 mb-2">
                    <h6 class="mb-1">{{ $k->nama }}</h6>
                    <small class="text-muted"><i class="bi bi-calendar3"></i> {{ $k->tanggal->format('d M Y') }}</small>
                    <small class="text-muted ms-2"><i class="bi bi-geo-alt"></i> {{ Str::limit($k->lokasi, 25) }}</small>
                    <div class="mt-2">
                        <a href="{{ route('user.kegiatan.show', $k) }}" class="btn btn-primary btn-sm">Daftar</a>
                    </div>
                </div>
                @empty
                <p class="text-muted text-center py-2">Tidak ada kegiatan mendatang.</p>
                @endforelse
            </div>
        </div>
    </div>
</div>
@endsection
