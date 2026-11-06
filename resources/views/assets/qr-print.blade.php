<!doctype html>
<html lang="id">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Cetak QR {{ $asset->asset_code }}</title>
    <style>
        body { margin: 0; color: #173b5d; font-family: Arial, sans-serif; }
        .toolbar { padding: 16px; text-align: center; background: #f4f8fd; }
        button { padding: 9px 16px; color: white; background: #07569b; border: 0; border-radius: 6px; cursor: pointer; }
        .label { width: 76mm; margin: 18mm auto; padding: 7mm; text-align: center; border: 1px solid #9bbbd7; border-radius: 4mm; }
        img { display: block; width: 48mm; height: 48mm; margin: 4mm auto; }
        h1 { margin: 0; font-size: 16pt; }
        p { margin: 2mm 0; font-size: 10pt; }
        .code { font-weight: 700; font-size: 13pt; }
        @media print { .toolbar { display: none; } .label { margin: 0 auto; border-color: #333; } }
    </style>
</head>
<body>
    <div class="toolbar"><button type="button" onclick="window.print()">Cetak QR</button></div>
    <main class="label">
        <h1>Pelindo Inventory</h1>
        <p class="code">{{ $asset->asset_code }}</p>
        <img src="{{ route('assets.qr', $asset) }}" alt="QR {{ $asset->asset_code }}">
        <p>{{ trim($asset->brand . ' ' . $asset->model) }}</p>
        <p>{{ $asset->serial_number }}</p>
    </main>
</body>
</html>
