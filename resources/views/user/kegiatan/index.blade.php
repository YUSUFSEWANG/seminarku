@extends('layouts.app')
@section('title', 'Kegiatan Tersedia')
@section('page-title', 'Kegiatan Tersedia')

@section('content')
<div class="row g-3">
@forelse($kegiatans as $k)
<div class="col-md-6 col-xl-4">
    <div class="card h-100">
        <div class="card-body">
            <div class="d-flex justify-content-between mb-2">
                <span class="badge bg-success">Aktif</span>
                <span class="badge {{ $k->isFull() ? 'bg-danger' : 'bg-light text-dark border' }}">
                    {{ $k->isFull() ? 'Penuh' : $k->sisaKuota() . ' sisa kursi' }}
                </span>
            </div>
            <h6 class="fw-semibold">{{ $k->nama }}</h6>
            <p class="text-muted small">{{ Str::limit($k->deskripsi, 90) }}</p>
            <hr class="my-2">
            <small class="text-muted d-block"><i class="bi bi-calendar3"></i> {{ $k->tanggal->format('d F Y') }}</small>
            <small class="text-muted d-block"><i class="bi bi-clock"></i> {{ $k->waktu_mulai }} - {{ $k->waktu_selesai }}</small>
            <small class="text-muted d-block"><i class="bi bi-geo-alt"></i> {{ $k->lokasi }}</small>
            <small class="text-muted d-block"><i class="bi bi-cash"></i> {{ $k->biaya > 0 ? 'Rp '.number_format($k->biaya,0,',','.') : 'Gratis' }}</small>
        </div>
        <div class="card-footer bg-white border-0 pt-0">
            <a href="{{ route('user.kegiatan.show', $k) }}" class="btn btn-primary btn-sm w-100">
                <i class="bi bi-info-circle"></i> Lihat Detail & Daftar
            </a>
        </div>
    </div>
</div>
@empty
<div class="col-12">
    <div class="text-center py-5 text-muted">
        <i class="bi bi-calendar-x fs-1"></i>
        <p class="mt-2">Belum ada kegiatan yang tersedia.</p>
    </div>
</div>
@endforelse
</div>
@if($kegiatans->hasPages())
<div class="mt-3">{{ $kegiatans->links() }}</div>
@endif
@endsection
