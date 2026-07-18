<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class ActivityLog extends Model
{
    protected $fillable = [
        'user_id',
        'action',
        'description',
        'ip_address',
        'user_agent',
        'model_type',
        'model_id',
    ];

    // ── Relasi ───────────────────────────────────────────────
    public function user()
    {
        return $this->belongsTo(User::class);
    }

    // ── Static Helper ────────────────────────────────────────
    public static function record(
        string $action,
        string $description,
        ?int $userId = null,
        ?string $modelType = null,
        ?int $modelId = null
    ): void {
        self::create([
            'user_id'     => $userId ?? auth()->id(),
            'action'      => $action,
            'description' => $description,
            'ip_address'  => request()->ip(),
            'user_agent'  => request()->userAgent(),
            'model_type'  => $modelType,
            'model_id'    => $modelId,
        ]);
    }
}
