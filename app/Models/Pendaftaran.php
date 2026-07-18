<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Pendaftaran extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_id',
        'kegiatan_id',
        'status',
        'nomor_pendaftaran',
        'catatan',
        'tanggal_daftar',
    ];

    protected $casts = [
        'tanggal_daftar' => 'datetime',
    ];

    // ── Relasi ───────────────────────────────────────────────
    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function kegiatan()
    {
        return $this->belongsTo(Kegiatan::class);
    }

    // ── Helpers ──────────────────────────────────────────────
    public static function generateNomor(): string
    {
        $prefix = 'SKU-' . date('Ymd') . '-';
        $last   = self::where('nomor_pendaftaran', 'like', $prefix . '%')
                      ->orderByDesc('id')
                      ->first();
        $seq    = $last ? ((int) substr($last->nomor_pendaftaran, -4)) + 1 : 1;
        return $prefix . str_pad($seq, 4, '0', STR_PAD_LEFT);
    }
}
