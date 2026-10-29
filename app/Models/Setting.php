<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Setting extends Model
{
    protected $fillable = ['nama_rt', 'nama_rw', 'desa', 'kecamatan', 'nominal_default', 'nominal_cepat'];

    /** Satu baris pengaturan untuk seluruh aplikasi (dibuat otomatis jika belum ada). */
    public static function current(): self
    {
        return static::query()->first() ?? static::create([]);
    }

    /** @return array<int,int> */
    public function nominalCepat(): array
    {
        return collect(explode(',', (string) $this->nominal_cepat))
            ->map(fn ($n) => (int) trim($n))
            ->filter(fn ($n) => $n > 0)
            ->unique()
            ->values()
            ->all();
    }
}
