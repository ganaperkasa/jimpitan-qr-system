<?php

namespace App\Support;

use Carbon\Carbon;

class Fmt
{
    public static function rp(int|float|string|null $angka): string
    {
        return 'Rp '.number_format((float) $angka, 0, ',', '.');
    }

    public static function tanggal(mixed $tanggal, string $format = 'j M Y'): string
    {
        return Carbon::parse($tanggal)->locale('id')->translatedFormat($format);
    }
}
