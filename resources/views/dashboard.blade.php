@extends('layouts.app')

@section('title', 'Dashboard - Pelindo Inventory')

@section('content')

    <style>
        /* Header */
        .dashboard-hero {
            display: flex;
            align-items: end;
            justify-content: space-between;
            gap: 24px;
            margin-bottom: 28px;
        }

        .dashboard-heading {
            color: #173B63;
            font-size: clamp(25px, 3vw, 31px);
            font-weight: 750;
            letter-spacing: -.65px;
        }

        .dashboard-subtitle {
            color: #70839A;
            font-size: 14px;
        }

        .dashboard-date {
            display: inline-flex;
            align-items: center;
            gap: 8px;
            padding: 9px 13px;
            border: 1px solid #DCE8F3;
            border-radius: 9px;
            background: #FFF;
            color: #607890;
            font-size: 12px;
            font-weight: 600;
        }

        /* Kartu statistik */
        .stat-card {
            position: relative;
            height: 100%;
            min-width: 0;
            overflow: hidden;
            padding: 20px !important;
            border: 1px solid #E1EAF5;
            border-radius: 14px;
            background: #FFFFFF;
            box-shadow: 0 5px 16px rgba(31, 82, 130, 0.045);
            transition: transform 0.2s ease, box-shadow 0.2s ease;
        }

        .stat-card:hover {
            transform: translateY(-2px);
            box-shadow: 0 10px 24px rgba(31, 82, 130, 0.09);
        }

        .stat-card p {
            color: #71849A !important;
            font-size: 13px;
            font-weight: 500;
        }

        .stat-card h2 {
            color: #173B63;
            font-size: 29px;
            line-height: 1;
        }

        .stat-icon {
            display: flex;
            width: 50px;
            height: 50px;
            align-items: center;
            justify-content: center;
            border-radius: 12px;
            font-size: 22px;
        }

        .stat-icon-blue {
            background: #E2F0FF;
            color: #1876D2;
        }

        .stat-icon-green {
            background: #DDF7EF;
            color: #079875;
        }

        .stat-icon-orange {
            background: #FFF0D5;
            color: #F29B16;
        }

        .stat-icon-red {
            background: #FFE3E5;
            color: #E83C4B;
        }

        /* Panel dashboard */
        .dashboard-panel {
            min-width: 0;
            border: 1px solid #E1EAF5 !important;
            border-radius: 14px !important;
            background: #FFFFFF;
            box-shadow: 0 5px 16px rgba(31, 82, 130, 0.045);
        }

        .dashboard-panel .card-header {
            padding: 17px 20px;
            border-bottom: 1px solid #E7EEF6;
            border-radius: 12px 12px 0 0;
            background: #FFFFFF;
        }

        .dashboard-panel .card-header h5,
        .dashboard-panel h5 {
            color: #173B63;
            font-size: 16px;
            font-weight: 700;
        }

        /* Menu cepat */
        .quick-action {
            display: flex;
            min-height: 118px;
            flex-direction: column;
            align-items: center;
            justify-content: center;
            gap: 9px;
            padding: 17px 10px;
            border: 1px solid #D8E7F8;
            border-radius: 12px;
            background: #FAFCFE;
            text-align: center;
            transition: 0.2s ease;
        }

        .quick-action:hover {
            background: #F1F8FF;
            border-color: #8BC2F2;
            transform: translateY(-2px);
        }

        .quick-action-icon {
            display: flex;
            width: 48px;
            height: 48px;
            align-items: center;
            justify-content: center;
            border-radius: 12px;
            background: #E3F1FF;
            color: #0878D1;
            font-size: 21px;
        }

        .quick-action-label {
            color: #264766;
            font-size: 13px;
            font-weight: 700;
        }

        /* Tabel aset */
        .asset-table {
            width: 100%;
            margin-bottom: 0;
        }

        .asset-table thead th {
            padding: 13px 16px;
            background: #F2F7FC;
            color: #617A99;
            font-size: 12px;
            font-weight: 700;
            white-space: nowrap;
            border-bottom: 1px solid #E1EAF5;
        }

        .asset-table tbody td {
            padding: 14px 16px;
            color: #244363;
            font-size: 13px;
            border-color: #E8EFF7;
        }

        .asset-table tbody tr:hover {
            background: #F7FAFE;
        }

        .asset-code {
            color: #073B78;
            font-weight: 700;
            white-space: nowrap;
        }

        .asset-detail-btn {
            min-width: 75px;
            border-radius: 7px;
            font-weight: 600;
        }

        .alert-card {
            display: flex;
            align-items: center;
            gap: 14px;
            min-height: 96px;
            padding: 18px 20px;
            border: 1px solid #E1EAF5;
            border-radius: 14px;
            background: #FFF;
            box-shadow: 0 5px 16px rgba(31, 82, 130, .035);
            transition: transform .2s ease, box-shadow .2s ease;
        }

        .alert-card:hover { transform: translateY(-2px); box-shadow: 0 9px 20px rgba(31, 82, 130, .08); }
        .alert-card-icon { display: grid; width: 44px; height: 44px; flex: 0 0 44px; place-items: center; border-radius: 12px; font-size: 20px; }
        .alert-card-warning .alert-card-icon { background: #FFF5DF; color: #D99418; }
        .alert-card-danger .alert-card-icon { background: #FFF0F1; color: #D95061; }
        .alert-card-label { color: #71849A; font-size: 12px; font-weight: 600; }
        .alert-card-number { margin: 2px 0; color: #173B63; font-size: 24px; font-weight: 750; line-height: 1; }
        .alert-card-copy { color: #8293A7; font-size: 12px; }

        .system-row + .system-row { border-top: 1px solid #EDF2F7; }
        .system-row { padding: 13px 0; }
        .system-row .system-label { color: #74879E; font-size: 12px; }
        .system-row .system-value { color: #294967; font-size: 12px; font-weight: 700; text-align: right; }

        /* Grafik */
        .chart-panel { overflow: hidden; }
        .chart-panel .card-body { padding: 20px; }
        .chart-container {
            position: relative;
            width: 100%;
            max-width: 290px;
            margin: 0 auto;
        }

        .condition-legend { display: grid; gap: 11px; }
        .condition-legend-item { display: flex; align-items: center; justify-content: space-between; gap: 12px; padding: 11px 12px; border-radius: 9px; background: #F8FAFC; }
        .condition-legend-name { display: flex; align-items: center; gap: 8px; color: #4C657E; font-size: 13px; font-weight: 600; }
        .condition-legend-value { color: #173B63; font-size: 14px; font-weight: 750; }
        .legend-dot { width: 9px; height: 9px; border-radius: 50%; }
        .legend-good { background: #19A878; } .legend-minor { background: #F2AD34; } .legend-major { background: #E35D6A; }

        /* Hindari elemen dashboard melebar keluar layar */
        .content,
        .content > *,
        .content .row,
        .content .card {
            min-width: 0;
            max-width: 100%;
        }

        @media (max-width: 767.98px) {
            .dashboard-hero { align-items: flex-start; flex-direction: column; gap: 12px; margin-bottom: 0; }
            .dashboard-heading {
                font-size: 24px;
                line-height: 1.18;
            }

            .dashboard-subtitle { font-size: 13px; line-height: 1.55; }
            .dashboard-date { padding: 7px 10px; font-size: 11px; }

            .stat-card {
                min-height: 102px;
                padding: 15px !important;
            }

            .stat-card h2 {
                font-size: 24px;
            }

            .stat-card p { max-width: 82px; margin-bottom: 10px !important; font-size: 12px; line-height: 1.35; }
            .stat-icon {
                width: 38px;
                height: 38px;
                flex: 0 0 38px;
                border-radius: 10px;
                font-size: 18px;
            }

            .quick-action {
                min-height: 104px;
                gap: 7px;
                padding: 12px 5px;
            }

            .quick-action-icon { width: 40px; height: 40px; border-radius: 10px; font-size: 18px; }
            .quick-action-label { font-size: 11px; line-height: 1.25; }
            .dashboard-panel .card-header { padding: 15px 16px; }
            .dashboard-panel .card-header h5, .dashboard-panel h5 { font-size: 15px; }
            .dashboard-panel.h-100.p-4 { padding: 16px !important; }

            .alert-card { min-height: 82px; gap: 11px; padding: 14px 15px; }
            .alert-card-icon { width: 38px; height: 38px; flex-basis: 38px; border-radius: 10px; font-size: 17px; }
            .alert-card-number { font-size: 21px; }
            .alert-card-copy { font-size: 11px; }

            .asset-table thead th, .asset-table tbody td { padding: 12px 14px; }
            .asset-detail-btn { min-width: 68px; padding-right: 9px; padding-left: 9px; }
            .chart-panel .card-body { padding: 16px; }
            .chart-container { max-width: 240px; }
            .condition-legend { gap: 8px; }
            .condition-legend-item { padding: 10px 11px; }
        }

        @media (max-width: 359.98px) {
            .stat-card { padding: 12px !important; }
            .stat-card p { max-width: 66px; font-size: 11px; }
            .stat-icon { width: 34px; height: 34px; flex-basis: 34px; font-size: 16px; }
            .quick-action-label { font-size: 10px; }
            .alert-card-copy { display: none; }
        }
    </style>

<div class="dashboard-hero w-100">
    <div>
        <h1 class="dashboard-heading mb-1">Ringkasan Inventaris</h1>
        <p class="dashboard-subtitle mb-0">Pantau aset IT Server Room Pelindo Regional 1 dalam satu tampilan.</p>
    </div>
    <div class="dashboard-date"><i class="bi bi-calendar3"></i>{{ now()->translatedFormat('d F Y') }}</div>
</div>


<!-- STATISTIK -->

<div class="row g-3 g-xl-4 mb-4">

    <!-- Total Aset -->
    <div class="col-6 col-xl-3">
        <div class="card stat-card">
            <div class="d-flex justify-content-between align-items-center gap-2">
                <div>
                    <p class="mb-2">Total Aset</p>
                    <h2 class="fw-bold mb-0">
                        {{ $totalAssets ?? 0 }}
                    </h2>
                </div>

                <div class="stat-icon stat-icon-blue">
                    <i class="bi bi-box-seam"></i>
                </div>
            </div>
        </div>
    </div>

    <!-- Kondisi Baik -->
    <div class="col-6 col-xl-3">
        <div class="card stat-card">
            <div class="d-flex justify-content-between align-items-center gap-2">
                <div>
                    <p class="mb-2">Kondisi Baik</p>
                    <h2 class="fw-bold mb-0" style="color: #079875;">
                        {{ $goodAssets ?? 0 }}
                    </h2>
                </div>

                <div class="stat-icon stat-icon-green">
                    <i class="bi bi-check-circle-fill"></i>
                </div>
            </div>
        </div>
    </div>

    <!-- Rusak Ringan -->
    <div class="col-6 col-xl-3">
        <div class="card stat-card">
            <div class="d-flex justify-content-between align-items-center gap-2">
                <div>
                    <p class="mb-2">Rusak Ringan</p>
                    <h2 class="fw-bold mb-0" style="color: #F29B16;">
                        {{ $minorDamage ?? 0 }}
                    </h2>
                </div>

                <div class="stat-icon stat-icon-orange">
                    <i class="bi bi-exclamation-circle-fill"></i>
                </div>
            </div>
        </div>
    </div>

    <!-- Rusak Berat -->
    <div class="col-6 col-xl-3">
        <div class="card stat-card">
            <div class="d-flex justify-content-between align-items-center gap-2">
                <div>
                    <p class="mb-2">Rusak Berat</p>
                    <h2 class="fw-bold mb-0" style="color: #E83C4B;">
                        {{ $majorDamage ?? 0 }}
                    </h2>
                </div>

                <div class="stat-icon stat-icon-red">
                    <i class="bi bi-x-circle-fill"></i>
                </div>
            </div>
        </div>
    </div>

</div>

<div class="row g-3 mb-4">
    <div class="col-md-6"><a class="alert-card alert-card-warning text-decoration-none h-100" href="{{ route('inspections.index', ['not_inspected_since' => now()->subDays(90)->toDateString()]) }}"><span class="alert-card-icon"><i class="bi bi-clock-history"></i></span><span><span class="alert-card-label d-block">Belum diperiksa dalam 90 hari</span><span class="alert-card-number d-block">{{ $overdueInspections }}</span><span class="alert-card-copy">Tindak lanjuti pemeriksaan aset</span></span><i class="bi bi-arrow-right ms-auto text-muted small"></i></a></div>
    <div class="col-md-6"><a class="alert-card alert-card-danger text-decoration-none h-100" href="{{ route('inspections.index', ['condition' => 'Rusak Berat']) }}"><span class="alert-card-icon"><i class="bi bi-exclamation-triangle"></i></span><span><span class="alert-card-label d-block">Aset rusak berat</span><span class="alert-card-number d-block">{{ $criticalAssets }}</span><span class="alert-card-copy">Prioritas untuk penanganan segera</span></span><i class="bi bi-arrow-right ms-auto text-muted small"></i></a></div>
</div>

<!-- MENU CEPAT DAN INFORMASI SISTEM -->
<div class="row g-4 mb-4">

    <div class="col-lg-8">
        <div class="card dashboard-panel h-100 p-4">

            <h5 class="mb-3">
                <i class="bi bi-lightning-charge-fill me-2"
                   style="color: #1685D8;"></i>
                Menu Cepat
            </h5>

            <div class="row g-3">

                <div class="col-4 col-md-4">
                    <a href="{{ route('assets.create') }}"
                       class="text-decoration-none d-block h-100">
                        <div class="quick-action">
                            <div class="quick-action-icon">
                                <i class="bi bi-plus-lg"></i>
                            </div>
                            <div class="quick-action-label">
                                Tambah Inventaris
                            </div>
                        </div>
                    </a>
                </div>

                <div class="col-4 col-md-4">
                    <a href="{{ route('scan.index') }}"
                       class="text-decoration-none d-block h-100">
                        <div class="quick-action">
                            <div class="quick-action-icon">
                                <i class="bi bi-qr-code"></i>
                            </div>
                            <div class="quick-action-label">
                                Scan QR
                            </div>
                        </div>
                    </a>
                </div>

                
                <div class="col-4 col-md-4">
                    <a href="{{ route('inspections.index') }}"
                    class="text-decoration-none d-block h-100">
                        <div class="quick-action">
                            <div class="quick-action-icon">
                                <i class="bi bi-clipboard-check"></i>
                            </div>
                            <div class="quick-action-label">
                                Pemeriksaan Aset
                            </div>
                        </div>
                    </a>
                </div>


            </div>
        </div>
    </div>

    <div class="col-lg-4">
        <div class="card dashboard-panel h-100 p-4">

            <h5 class="mb-3">
                <i class="bi bi-info-circle-fill me-2"
                   style="color: #1685D8;"></i>
                Informasi Sistem
            </h5>

            <div class="system-row d-flex justify-content-between align-items-center">
                <span class="system-label">Sistem</span>
                <span class="system-value">Pelindo Inventory</span>
            </div>

            <div class="system-row d-flex justify-content-between align-items-center">
                <span class="system-label">Regional</span>
                <span class="system-value">Regional 1</span>
            </div>

            <div class="system-row d-flex justify-content-between align-items-center">
                <span class="system-label">Lokasi</span>
                <span class="system-value">IT Server Room</span>
            </div>

        </div>
    </div>

</div>

{{-- ASET YANG PERLU DIPERBAIKI --}}
<div class="card dashboard-panel mt-4">

    <div class="card-header">
        <h5 class="mb-0">
            <i class="bi bi-tools me-2" style="color: #F5A623;"></i>
            Aset yang Perlu Diperbaiki
        </h5>
    </div>

    <div class="card-body p-0">

        @if(isset($assetsNeedRepair) && $assetsNeedRepair->isNotEmpty())

            <div class="table-responsive">
                <table class="table table-hover align-middle asset-table">

                    <thead>
                        <tr>
                            <th>Kode Aset</th>
                            <th>Nama / Merek</th>
                            <th>Lokasi</th>
                            <th>Kondisi</th>
                            <th class="text-center">Aksi</th>
                        </tr>
                    </thead>

                    <tbody>
                        @foreach($assetsNeedRepair as $asset)
                            <tr>
                                <td>
                                    <span class="asset-code">
                                        {{ $asset->asset_code }}
                                    </span>
                                </td>

                                <td>
                                    <div class="fw-semibold">
                                        {{ $asset->brand ?: '-' }}
                                    </div>
                                    <div class="small text-muted">
                                        {{ $asset->category->name ?? '-' }}
                                    </div>
                                </td>

                                <td>
                                    {{ $asset->location->room ?? '-' }}
                                </td>

                                <td>
                                    @if($asset->condition === 'Rusak Ringan')
                                        <span class="badge rounded-pill text-bg-warning">
                                            Rusak Ringan
                                        </span>
                                    @else
                                        <span class="badge rounded-pill text-bg-danger">
                                            Rusak Berat
                                        </span>
                                    @endif
                                </td>

                                <td class="text-center">
                                    <a
                                        href="{{ route('assets.show', $asset) }}"
                                        class="btn btn-sm btn-outline-primary asset-detail-btn"
                                    >
                                        Detail
                                    </a>
                                </td>
                            </tr>
                        @endforeach
                    </tbody>

                </table>
            </div>

        @else

            <div class="text-center py-5">
                <i class="bi bi-check-circle-fill text-success fs-2"></i>
                <p class="text-muted mt-3 mb-0">
                    Tidak ada aset rusak. Semua kondisi aset tercatat baik.
                </p>
            </div>

        @endif

    </div>
</div>

{{-- GRAFIK KONDISI ASET --}}
<div class="card dashboard-panel chart-panel mt-4">
    <div class="card-header">
        <h5 class="fw-bold mb-0">
            <i class="bi bi-pie-chart me-2 text-primary"></i>
            Grafik Kondisi Aset
        </h5>
    </div>

    <div class="card-body">
        <div class="row align-items-center g-4">
            <div class="col-md-6">
                <div class="chart-container"><canvas id="assetConditionChart"></canvas></div>
            </div>
            <div class="col-md-6">
                <p class="text-muted small mb-3">Distribusi kondisi seluruh aset yang tercatat saat ini.</p>
                <div class="condition-legend">
                    <div class="condition-legend-item"><span class="condition-legend-name"><span class="legend-dot legend-good"></span>Baik</span><span class="condition-legend-value">{{ $goodAssets ?? 0 }}</span></div>
                    <div class="condition-legend-item"><span class="condition-legend-name"><span class="legend-dot legend-minor"></span>Rusak Ringan</span><span class="condition-legend-value">{{ $minorDamage ?? 0 }}</span></div>
                    <div class="condition-legend-item"><span class="condition-legend-name"><span class="legend-dot legend-major"></span>Rusak Berat</span><span class="condition-legend-value">{{ $majorDamage ?? 0 }}</span></div>
                </div>
            </div>
        </div>
    </div>
</div>

<script>
document.addEventListener('DOMContentLoaded', function () {
    const canvas = document.getElementById('assetConditionChart');

    if (!canvas) return;

    const totalAssets = {{ $totalAssets ?? 0 }};
    const centerText = {
        id: 'centerText',
        afterDraw(chart) {
            const { ctx, chartArea: { left, right, top, bottom } } = chart;
            const x = (left + right) / 2;
            const y = (top + bottom) / 2;
            ctx.save();
            ctx.textAlign = 'center';
            ctx.fillStyle = '#173B63';
            ctx.font = '700 25px Segoe UI, sans-serif';
            ctx.fillText(totalAssets, x, y - 3);
            ctx.fillStyle = '#8192A5';
            ctx.font = '600 11px Segoe UI, sans-serif';
            ctx.fillText('TOTAL ASET', x, y + 17);
            ctx.restore();
        }
    };

    new Chart(canvas, {
        type: 'doughnut',
        data: {
            labels: [
                'Baik',
                'Rusak Ringan',
                'Rusak Berat'
            ],
            datasets: [{
                data: [
                    {{ $goodAssets ?? 0 }},
                    {{ $minorDamage ?? 0 }},
                    {{ $majorDamage ?? 0 }}
                ],
                backgroundColor: [
                    '#198754',
                    '#ffc107',
                    '#dc3545'
                ],
                borderColor: '#FFFFFF',
                borderWidth: 5,
                borderRadius: 5,
                hoverOffset: 5
            }]
        },
        options: {
            responsive: true,
            maintainAspectRatio: true,
            cutout: '72%',
            plugins: {
                legend: {
                    display: false
                },
                tooltip: {
                    backgroundColor: '#173B63',
                    padding: 11,
                    displayColors: true,
                    callbacks: { label: (context) => ` ${context.label}: ${context.parsed} aset` }
                }
            }
        },
        plugins: [centerText]
    });
});
</script>

@endsection
