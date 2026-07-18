@extends('layouts.app')
@section('title', $kegiatan->nama)
@section('page-title', 'Detail Kegiatan')

@section('content')
<div class="row g-3">
    <div class="col-lg-8">
        <div class="card">
            <div class="card-body">
                <h4>{{ $kegiatan->nama }}</h4>
                <p class="text-muted">{{ $kegiatan->deskripsi }}</p>
                <hr>
                <div class="row g-2">
                    <div class="col-sm-6">
                        <div class="d-flex align-items-center gap-2 mb-2">
                            <i class="bi bi-calendar3 text-primary fs-5"></i>
                            <div>
                                <small class="text-muted d-block">Tanggal</small>
                                <strong>{{ $kegiatan->tanggal->format('d F Y') }}</strong>
                            </div>
                        </div>
                    </div>
                    <div class="col-sm-6">
                        <div class="d-flex align-items-center gap-2 mb-2">
                            <i class="bi bi-clock text-primary fs-5"></i>
                            <div>
                                <small class="text-muted d-block">Waktu</small>
                                <strong>{{ $kegiatan->waktu_mulai }} - {{ $kegiatan->waktu_selesai }}</strong>
                            </div>
                        </div>
                    </div>
                    <div class="col-sm-6">
                        <div class="d-flex align-items-center gap-2 mb-2">
                            <i class="bi bi-geo-alt text-primary fs-5"></i>
                            <div>
                                <small class="text-muted d-block">Lokasi</small>
                                <strong>{{ $kegiatan->lokasi }}</strong>
                            </div>
                        </div>
                    </div>
                    <div class="col-sm-6">
                        <div class="d-flex align-items-center gap-2 mb-2">
                            <i class="bi bi-building text-primary fs-5"></i>
                            <div>
                                <small class="text-muted d-block">Penyelenggara</small>
                                <strong>{{ $kegiatan->penyelenggara }}</strong>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div class="col-lg-4">
        <div class="card border-primary">
            <div class="card-header bg-primary text-white fw-semibold">
                Informasi Pendaftaran
            </div>
            <div class="card-body">
                <div class="d-flex justify-content-between mb-2">
                    <span>Biaya</span>
                    <strong>{{ $kegiatan->biaya > 0 ? 'Rp '.number_format($kegiatan->biaya,0,',','.') : 'Gratis' }}</strong>
                </div>
                <div class="d-flex justify-content-between mb-3">
                    <span>Sisa Kuota</span>
                    <strong class="{{ $kegiatan->isFull() ? 'text-danger' : 'text-success' }}">
                        {{ $kegiatan->sisaKuota() }} / {{ $kegiatan->kuota }}
                    </strong>
                </div>

                @if($sudahDaftar)
                    <div class="alert alert-success py-2">
                        <i class="bi bi-check-circle"></i> Anda sudah terdaftar di kegiatan ini.
                    </div>
                    <a href="{{ route('user.pendaftaran.index') }}" class="btn btn-outline-primary w-100">
                        Lihat Pendaftaran Saya
                    </a>
                @elseif($kegiatan->isFull())
                    <div class="alert alert-danger py-2">
                        <i class="bi bi-x-circle"></i> Kuota sudah penuh.
                    </div>
                @else
                    <form action="{{ route('user.pendaftaran.store') }}" method="POST">
                        @csrf
                        <input type="hidden" name="kegiatan_id" value="{{ $kegiatan->id }}">
                        <div class="mb-3">
                            <label class="form-label small">Catatan (opsional)</label>
                            <textarea name="catatan" class="form-control form-control-sm @error('catatan') is-invalid @enderror"
                                      rows="2" maxlength="500" placeholder="Kebutuhan khusus, pertanyaan, dll.">{{ old('catatan') }}</textarea>
                            @error('catatan')<div class="invalid-feedback">{{ $message }}</div>@enderror
                        </div>
                        <button type="submit" class="btn btn-primary w-100"
                                onclick="return confirm('Konfirmasi pendaftaran kegiatan ini?')">
                            <i class="bi bi-person-plus"></i> Daftar Sekarang
                        </button>
                    </form>
                @endif
            </div>
        </div>
        <a href="{{ route('user.kegiatan.index') }}" class="btn btn-link text-decoration-none mt-2">
            <i class="bi bi-arrow-left"></i> Kembali ke Daftar Kegiatan
        </a>
    </div>
</div>
@endsection
