<?php

namespace App\Support;

use BaconQrCode\Renderer\Image\SvgImageBackEnd;
use BaconQrCode\Renderer\ImageRenderer;
use BaconQrCode\Renderer\RendererStyle\RendererStyle;
use BaconQrCode\Writer;
use Illuminate\Support\HtmlString;

/**
 * QR Code berformat SVG (tanpa GD/Imagick) memakai bacon/bacon-qr-code.
 * Isi QR hanya kode internal warga, bukan data pribadi.
 */
class QrSvg
{
    public static function make(string $teks, int $ukuran = 200): HtmlString
    {
        $renderer = new ImageRenderer(new RendererStyle($ukuran, 1), new SvgImageBackEnd());
        $svg = (new Writer($renderer))->writeString($teks);

        // Buang deklarasi XML agar aman disisipkan langsung ke HTML.
        return new HtmlString(preg_replace('/^<\?xml[^>]*\?>\s*/', '', $svg));
    }
}
