<!doctype html>
<html lang="id">
<head>
    <meta charset="utf-8">
    <style>
        @page { margin: 20px 24px 28px; }
        body { color: #1f354d; font-family: DejaVu Sans, sans-serif; font-size: 9px; }
        h1 { margin: 0; color: #07569b; font-size: 19px; }
        .subtitle { margin: 4px 0 16px; color: #627a95; font-size: 10px; }
        .summary { width: 100%; margin: 0 0 14px; border-collapse: separate; border-spacing: 6px 0; }
        .summary td { width: 25%; padding: 9px; border: 1px solid #dbe8f3; background: #f7fbff; }
        .summary strong { display: block; margin-top: 4px; color: #07569b; font-size: 16px; }
        table { width: 100%; border-collapse: collapse; }
        th { padding: 8px 6px; color: #3d5e7d; font-size: 8px; text-align: left; background: #edf5fb; border: 1px solid #d8e5ef; }
        td { padding: 7px 6px; vertical-align: top; border: 1px solid #e1eaf1; }
        .muted { color: #617991; }
        .footer { position: fixed; right: 0; bottom: -16px; left: 0; color: #7186a0; font-size: 8px; text-align: right; }
        .pagenum:before { content: counter(page); }
        .filters { margin: 0 0 12px; color: #516d88; font-size: 8px; }
    </style>
</head>
<body>
    <h1>Rekap Aset</h1>
    <p class="subtitle">Pelindo Inventory - dibuat pada {{ now()->format('d-m-Y H:i') }}</p>
    @if(!empty($filterLabels))<p class="filters"><strong>Filter:</strong> {{ collect($filterLabels)->map(fn ($value, $label) => $label . ': ' . $value)->implode(' | ') }}</p>@endif

    <table class="summary">
        <tr>
            <td>Total Aset<strong>{{ $summary['total'] }}</strong></td>
            <td>Baik<strong>{{ $summary['good'] }}</strong></td>
            <td>Rusak Ringan<strong>{{ $summary['minor'] }}</strong></td>
            <td>Rusak Berat<strong>{{ $summary['major'] }}</strong></td>
        </tr>
    </table>

    <table>
        <thead><tr><th>Kode</th><th>Perangkat</th><th>Kategori</th><th>Lokasi</th><th>Kondisi</th><th>Status</th><th>Nomor Seri</th></tr></thead>
        <tbody>
            @forelse($assets as $asset)
                <tr>
                    <td>{{ $asset->asset_code }}</td>
                    <td>{{ trim($asset->brand . ' ' . $asset->model) ?: '-' }}</td>
                    <td>{{ $asset->category?->name ?? '-' }}</td>
                    <td>{{ collect([$asset->location?->regional, $asset->location?->site, $asset->location?->room])->filter()->implode(' - ') ?: '-' }}</td>
                    <td>{{ $asset->condition }}</td>
                    <td>{{ $asset->status }}</td>
                    <td>{{ $asset->serial_number }}</td>
                </tr>
            @empty
                <tr><td colspan="7" class="muted">Tidak ada aset yang sesuai dengan filter.</td></tr>
            @endforelse
        </tbody>
    </table>
    <div class="footer">Pelindo Inventory - Halaman <span class="pagenum"></span></div>
</body>
</html>
