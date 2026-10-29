<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Warga extends Model
{
    protected $table = 'warga';

    protected $fillable = ['kode_warga', 'nama', 'no_rumah', 'alamat', 'no_hp', 'status'];

    public function jimpitans(): HasMany
    {
        return $this->hasMany(Jimpitan::class);
    }

    public function scopeAktif(Builder $query): Builder
    {
        return $query->where('status', 'aktif');
    }

    public function scopeCari(Builder $query, ?string $kata): Builder
    {
        $kata = trim((string) $kata);

        if ($kata === '') {
            return $query;
        }

        $like = '%'.addcslashes($kata, '%_\\').'%';

        return $query->where(function (Builder $w) use ($like) {
            $w->where('nama', 'like', $like)
                ->orWhere('kode_warga', 'like', $like)
                ->orWhere('no_rumah', 'like', $like);
        });
    }

    public function getAktifAttribute(): bool
    {
        return $this->status === 'aktif';
    }

    public function getInisialAttribute(): string
    {
        return collect(explode(' ', trim($this->nama)))
            ->filter()
            ->take(2)
            ->map(fn ($kata) => mb_strtoupper(mb_substr($kata, 0, 1)))
            ->implode('');
    }

    public static function kodeDariId(int $id): string
    {
        return 'WARGA-'.str_pad((string) $id, 6, '0', STR_PAD_LEFT);
    }
}
