@extends('layouts.app')
@section('title', 'Kelola Kegiatan')
@section('page-title', 'Kelola Kegiatan')

@section('content')
<div class="d-flex justify-content-between align-items-center mb-3">
    <h5 class="mb-0">Daftar Kegiatan</h5>
    <a href="{{ route('admin.kegiatan.create') }}" class="btn btn-primary btn-sm">
        <i class="bi bi-plus-lg"></i> Tambah Kegiatan
    </a>
</div>

<div class="card">
    <div class="card-body p-0">
        <table class="table table-hover mb-0">
            <thead class="table-light">
                <tr>
                    <th>#</th><th>Nama Kegiatan</th><th>Tanggal</th><th>Kuota</th><th>Biaya</th><th>Status</th><th>Aksi</th>
                </tr>
            </thead>
            <tbody>
            @forelse($kegiatans as $k)
            <tr>
                <td>{{ $loop->iteration }}</td>
                <td>
                    <strong>{{ $k->nama }}</strong><br>
                    <small class="text-muted"><i class="bi bi-geo-alt"></i> {{ $k->lokasi }}</small>
                </td>
                <td>{{ $k->tanggal->format('d M Y') }}<br><small class="text-muted">{{ $k->waktu_mulai }} - {{ $k->waktu_selesai }}</small></td>
                <td>{{ $k->pendaftarans->count() }} / {{ $k->kuota }}</td>
                <td>{{ $k->biaya > 0 ? 'Rp ' . number_format($k->biaya, 0, ',', '.') : '<span class="badge bg-success">Gratis</span>' }}</td>
                <td>
                    @if($k->status === 'aktif') <span class="badge bg-success">Aktif</span>
                    @elseif($k->status === 'nonaktif') <span class="badge bg-secondary">Nonaktif</span>
                    @else <span class="badge bg-info">Selesai</span>
                    @endif
                </td>
                <td>
                    <a href="{{ route('admin.kegiatan.show', $k) }}" class="btn btn-sm btn-outline-info"><i class="bi bi-eye"></i></a>
                    <a href="{{ route('admin.kegiatan.edit', $k) }}" class="btn btn-sm btn-outline-warning"><i class="bi bi-pencil"></i></a>
                    <form action="{{ route('admin.kegiatan.destroy', $k) }}" method="POST" class="d-inline" onsubmit="return confirm('Hapus kegiatan ini?')">
                        @csrf @method('DELETE')
                        <button type="submit" class="btn btn-sm btn-outline-danger"><i class="bi bi-trash"></i></button>
                    </form>
                </td>
            </tr>
            @empty
            <tr><td colspan="7" class="text-center text-muted py-4">Belum ada kegiatan.</td></tr>
            @endforelse
            </tbody>
        </table>
    </div>
    @if($kegiatans->hasPages())
    <div class="card-footer">{{ $kegiatans->links() }}</div>
    @endif
</div>
@endsection
