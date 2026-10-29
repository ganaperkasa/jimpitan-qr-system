<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class JimpitanLog extends Model
{
    protected $fillable = ['jimpitan_id', 'user_id', 'aksi', 'alasan', 'nominal_lama'];

    public function jimpitan(): BelongsTo
    {
        return $this->belongsTo(Jimpitan::class);
    }

    public function pengguna(): BelongsTo
    {
        return $this->belongsTo(User::class, 'user_id');
    }
}
