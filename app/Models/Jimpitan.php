<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Jimpitan extends Model
{
    protected $fillable = ['warga_id', 'user_id', 'tanggal', 'nominal', 'catatan', 'status', 'token'];

    protected function casts(): array
    {
        return [
            'tanggal' => 'date',
            'nominal' => 'integer',
        ];
    }

    public function warga(): BelongsTo
    {
        return $this->belongsTo(Warga::class);
    }

    public function petugas(): BelongsTo
    {
        return $this->belongsTo(User::class, 'user_id');
    }

    public function logs(): HasMany
    {
        return $this->hasMany(JimpitanLog::class);
    }

    public function scopeTercatat(Builder $query): Builder
    {
        return $query->where('status', 'tercatat');
    }

    public function getDibatalkanAttribute(): bool
    {
        return $this->status === 'dibatalkan';
    }
}
