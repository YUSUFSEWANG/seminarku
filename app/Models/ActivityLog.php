<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\MassPrunable;

class ActivityLog extends Model
{
    use MassPrunable;

    protected $fillable = [
        'user_id',
        'action',
        'description',
        'ip_address',
        'user_agent',
        'model_type',
        'model_id',
    ];

    // ── Pruning — hapus log lebih dari 90 hari secara otomatis ───────────
    public function prunable(): Builder
    {
        return static::where('created_at', '<=', now()->subDays(90));
    }

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
