@extends('layouts.app')
@section('title', 'Edit Kegiatan')
@section('page-title', 'Edit Kegiatan')

@section('content')
<div class="card" style="max-width:760px;">
    <div class="card-body">
        <form action="{{ route('admin.kegiatan.update', $kegiatan) }}" method="POST">
            @csrf @method('PUT')
            <div class="row g-3">
                <div class="col-12">
                    <label class="form-label fw-semibold">Nama Kegiatan <span class="text-danger">*</span></label>
                    <input type="text" name="nama" class="form-control @error('nama') is-invalid @enderror"
                           value="{{ old('nama', $kegiatan->nama) }}" required maxlength="255">
                    @error('nama')<div class="invalid-feedback">{{ $message }}</div>@enderror
                </div>
                <div class="col-12">
                    <label class="form-label fw-semibold">Deskripsi <span class="text-danger">*</span></label>
                    <textarea name="deskripsi" rows="4" class="form-control @error('deskripsi') is-invalid @enderror" required>{{ old('deskripsi', $kegiatan->deskripsi) }}</textarea>
                    @error('deskripsi')<div class="invalid-feedback">{{ $message }}</div>@enderror
                </div>
                <div class="col-md-6">
                    <label class="form-label fw-semibold">Lokasi <span class="text-danger">*</span></label>
                    <input type="text" name="lokasi" class="form-control @error('lokasi') is-invalid @enderror"
                           value="{{ old('lokasi', $kegiatan->lokasi) }}" required maxlength="255">
                    @error('lokasi')<div class="invalid-feedback">{{ $message }}</div>@enderror
                </div>
                <div class="col-md-6">
                    <label class="form-label fw-semibold">Penyelenggara <span class="text-danger">*</span></label>
                    <input type="text" name="penyelenggara" class="form-control @error('penyelenggara') is-invalid @enderror"
                           value="{{ old('penyelenggara', $kegiatan->penyelenggara) }}" required maxlength="255">
                    @error('penyelenggara')<div class="invalid-feedback">{{ $message }}</div>@enderror
                </div>
                <div class="col-md-4">
                    <label class="form-label fw-semibold">Tanggal</label>
                    <input type="date" name="tanggal" class="form-control @error('tanggal') is-invalid @enderror"
                           value="{{ old('tanggal', $kegiatan->tanggal->format('Y-m-d')) }}" required>
                    @error('tanggal')<div class="invalid-feedback">{{ $message }}</div>@enderror
                </div>
                <div class="col-md-4">
                    <label class="form-label fw-semibold">Waktu Mulai</label>
                    <input type="time" name="waktu_mulai" class="form-control"
                           value="{{ old('waktu_mulai', $kegiatan->waktu_mulai) }}" required>
                </div>
                <div class="col-md-4">
                    <label class="form-label fw-semibold">Waktu Selesai</label>
                    <input type="time" name="waktu_selesai" class="form-control"
                           value="{{ old('waktu_selesai', $kegiatan->waktu_selesai) }}" required>
                </div>
                <div class="col-md-4">
                    <label class="form-label fw-semibold">Kuota</label>
                    <input type="number" name="kuota" class="form-control"
                           value="{{ old('kuota', $kegiatan->kuota) }}" min="1" required>
                </div>
                <div class="col-md-4">
                    <label class="form-label fw-semibold">Biaya (Rp)</label>
                    <input type="number" name="biaya" class="form-control"
                           value="{{ old('biaya', $kegiatan->biaya) }}" min="0" step="1000" required>
                </div>
                <div class="col-md-4">
                    <label class="form-label fw-semibold">Status</label>
                    <select name="status" class="form-select">
                        <option value="aktif" {{ old('status', $kegiatan->status) === 'aktif' ? 'selected' : '' }}>Aktif</option>
                        <option value="nonaktif" {{ old('status', $kegiatan->status) === 'nonaktif' ? 'selected' : '' }}>Nonaktif</option>
                        <option value="selesai" {{ old('status', $kegiatan->status) === 'selesai' ? 'selected' : '' }}>Selesai</option>
                    </select>
                </div>
                <div class="col-12 d-flex gap-2">
                    <button type="submit" class="btn btn-warning"><i class="bi bi-pencil"></i> Update</button>
                    <a href="{{ route('admin.kegiatan.index') }}" class="btn btn-secondary">Batal</a>
                </div>
            </div>
        </form>
    </div>
</div>
@endsection
