<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Kegiatan extends Model
{
    use HasFactory;

    protected $fillable = [
        'nama',
        'deskripsi',
        'lokasi',
        'tanggal',
        'waktu_mulai',
        'waktu_selesai',
        'kuota',
        'biaya',
        'status',
        'penyelenggara',
        'created_by',
    ];

    protected $casts = [
        'tanggal' => 'date',
        'biaya'   => 'decimal:2',
    ];

    // ── Relasi ───────────────────────────────────────────────
    public function createdBy()
    {
        return $this->belongsTo(User::class, 'created_by');
    }

    public function pendaftarans()
    {
        return $this->hasMany(Pendaftaran::class);
    }

    public function pesertaDikonfirmasi()
    {
        return $this->hasMany(Pendaftaran::class)->where('status', 'dikonfirmasi');
    }

    // ── Helpers ──────────────────────────────────────────────
    public function sisaKuota(): int
    {
        return $this->kuota - $this->pesertaDikonfirmasi()->count();
    }

    public function isFull(): bool
    {
        return $this->sisaKuota() <= 0;
    }

    public function isAktif(): bool
    {
        return $this->status === 'aktif';
    }
}
