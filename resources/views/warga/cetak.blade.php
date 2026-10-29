<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Cetak QR Warga</title>
    <style>
        * { box-sizing: border-box; }
        body { margin: 0; padding: 16px; font-family: system-ui, sans-serif; color: #111; background: #fff; }
        .bar { display: flex; align-items: center; justify-content: space-between; gap: 12px; margin-bottom: 16px; }
        .bar button { padding: 10px 18px; border: 0; border-radius: 10px; background: #111; color: #fff; font-size: 15px; font-weight: 700; cursor: pointer; }
        .grid { display: grid; grid-template-columns: repeat(auto-fill, minmax(200px, 1fr)); gap: 12px; }
        .kartu { border: 1.5px dashed #777; border-radius: 12px; padding: 12px; text-align: center; break-inside: avoid; }
        .kartu svg { width: 150px; height: 150px; }
        .nama { font-weight: 700; font-size: 15px; margin-top: 6px; }
        .info { font-size: 12px; color: #444; }
        @media print { .bar { display: none; } body { padding: 0; } }
    </style>
</head>
<body>
    <div class="bar">
        <strong>{{ $daftar->count() }} kartu QR · gunting mengikuti garis putus-putus</strong>
        <button type="button" onclick="window.print()">Cetak</button>
    </div>

    <div class="grid">
        @forelse ($daftar as $w)
            <div class="kartu">
                {{ \App\Support\QrSvg::make($w->kode_warga, 150) }}
                <div class="nama">{{ $w->nama }}</div>
                <div class="info">Rumah {{ $w->no_rumah }} · {{ $w->kode_warga }}</div>
            </div>
        @empty
            <p>Tidak ada warga aktif untuk dicetak.</p>
        @endforelse
    </div>
</body>
</html>
