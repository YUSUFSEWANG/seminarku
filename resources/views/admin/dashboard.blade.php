@extends('layouts.app')
@section('title', 'Dashboard Admin')
@section('page-title', 'Dashboard')

@section('content')
<div class="row g-3 mb-4">
    <div class="col-md-4 col-xl-2">
        <div class="card stat-card border-primary">
            <div class="card-body py-3">
                <div class="d-flex justify-content-between align-items-center">
                    <div>
                        <p class="text-muted small mb-0">Total Kegiatan</p>
                        <h3 class="fw-bold mb-0">{{ $stats['total_kegiatan'] }}</h3>
                    </div>
                    <i class="bi bi-calendar-event text-primary fs-2 opacity-50"></i>
                </div>
            </div>
        </div>
    </div>
    <div class="col-md-4 col-xl-2">
        <div class="card stat-card border-success">
            <div class="card-body py-3">
                <div class="d-flex justify-content-between align-items-center">
                    <div>
                        <p class="text-muted small mb-0">Kegiatan Aktif</p>
                        <h3 class="fw-bold mb-0">{{ $stats['kegiatan_aktif'] }}</h3>
                    </div>
                    <i class="bi bi-calendar-check text-success fs-2 opacity-50"></i>
                </div>
            </div>
        </div>
    </div>
    <div class="col-md-4 col-xl-2">
        <div class="card stat-card border-info">
            <div class="card-body py-3">
                <div class="d-flex justify-content-between align-items-center">
                    <div>
                        <p class="text-muted small mb-0">Total Pendaftar</p>
                        <h3 class="fw-bold mb-0">{{ $stats['total_pendaftaran'] }}</h3>
                    </div>
                    <i class="bi bi-people text-info fs-2 opacity-50"></i>
                </div>
            </div>
        </div>
    </div>
    <div class="col-md-4 col-xl-2">
        <div class="card stat-card border-warning">
            <div class="card-body py-3">
                <div class="d-flex justify-content-between align-items-center">
                    <div>
                        <p class="text-muted small mb-0">Pending</p>
                        <h3 class="fw-bold mb-0">{{ $stats['pending'] }}</h3>
                    </div>
                    <i class="bi bi-hourglass-split text-warning fs-2 opacity-50"></i>
                </div>
            </div>
        </div>
    </div>
    <div class="col-md-4 col-xl-2">
        <div class="card stat-card border-success">
            <div class="card-body py-3">
                <div class="d-flex justify-content-between align-items-center">
                    <div>
                        <p class="text-muted small mb-0">Dikonfirmasi</p>
                        <h3 class="fw-bold mb-0">{{ $stats['dikonfirmasi'] }}</h3>
                    </div>
                    <i class="bi bi-person-check text-success fs-2 opacity-50"></i>
                </div>
            </div>
        </div>
    </div>
    <div class="col-md-4 col-xl-2">
        <div class="card stat-card border-secondary">
            <div class="card-body py-3">
                <div class="d-flex justify-content-between align-items-center">
                    <div>
                        <p class="text-muted small mb-0">Total User</p>
                        <h3 class="fw-bold mb-0">{{ $stats['total_user'] }}</h3>
                    </div>
                    <i class="bi bi-person text-secondary fs-2 opacity-50"></i>
                </div>
            </div>
        </div>
    </div>
</div>

<div class="row g-3">
    <div class="col-lg-6">
        <div class="card">
            <div class="card-header bg-white fw-semibold">
                <i class="bi bi-clock-history text-primary"></i> Pendaftaran Terbaru
            </div>
            <div class="card-body p-0">
                <table class="table table-hover mb-0">
                    <thead class="table-light"><tr><th>Nomor</th><th>Peserta</th><th>Kegiatan</th><th>Status</th></tr></thead>
                    <tbody>
                    @forelse($recentDaftar as $d)
                    <tr>
                        <td><small>{{ $d->nomor_pendaftaran }}</small></td>
                        <td><small>{{ $d->user->name }}</small></td>
                        <td><small>{{ Str::limit($d->kegiatan->nama, 30) }}</small></td>
                        <td>
                            <span class="badge badge-status-{{ $d->status }}">{{ ucfirst($d->status) }}</span>
                        </td>
                    </tr>
                    @empty
                    <tr><td colspan="4" class="text-center text-muted">Belum ada pendaftaran</td></tr>
                    @endforelse
                    </tbody>
                </table>
            </div>
        </div>
    </div>
    <div class="col-lg-6">
        <div class="card">
            <div class="card-header bg-white fw-semibold">
                <i class="bi bi-shield-check text-success"></i> Security Log Terbaru
            </div>
            <div class="card-body p-0">
                <table class="table table-hover mb-0">
                    <thead class="table-light"><tr><th>Waktu</th><th>Aksi</th><th>Pengguna</th></tr></thead>
                    <tbody>
                    @forelse($recentLogs as $log)
                    <tr>
                        <td><small class="text-muted">{{ $log->created_at->format('d/m H:i') }}</small></td>
                        <td>
                            <span class="badge {{ str_contains($log->action, 'fail') || str_contains($log->action, 'denied') ? 'bg-danger' : 'bg-secondary' }}">
                                {{ $log->action }}
                            </span>
                        </td>
                        <td><small>{{ $log->user?->name ?? 'Guest' }}</small></td>
                    </tr>
                    @empty
                    <tr><td colspan="3" class="text-center text-muted">Belum ada log</td></tr>
                    @endforelse
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>
@endsection
