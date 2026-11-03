@extends('layouts.app')

@section('title', 'Dashboard - Pelindo Inventory')

@section('content')

    <style>
        /* Judul dashboard */
        .dashboard-heading {
            color: #073B78;
            font-size: 28px;
            font-weight: 700;
        }

        .dashboard-subtitle {
            color: #7186A2;
            font-size: 14px;
        }

        /* Kartu statistik */
        .stat-card {
            position: relative;
            height: 100%;
            min-width: 0;
            padding: 22px !important;
            border: 1px solid #E1EAF5;
            border-radius: 12px;
            background: #FFFFFF;
            box-shadow: 0 4px 14px rgba(31, 82, 130, 0.05);
            transition: transform 0.2s ease, box-shadow 0.2s ease;
        }

        .stat-card:hover {
            transform: translateY(-3px);
            box-shadow: 0 8px 20px rgba(31, 82, 130, 0.09);
        }

        .stat-card p {
            color: #617A99 !important;
            font-size: 14px;
        }

        .stat-card h2 {
            color: #1769B0;
            font-size: 30px;
        }

        .stat-icon {
            display: flex;
            width: 50px;
            height: 50px;
            align-items: center;
            justify-content: center;
            border-radius: 15px;
            font-size: 25px;
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
            border-radius: 12px !important;
            background: #FFFFFF;
            box-shadow: 0 4px 14px rgba(31, 82, 130, 0.05);
        }

        .dashboard-panel .card-header {
            padding: 18px 20px;
            border-bottom: 1px solid #E7EEF6;
            border-radius: 12px 12px 0 0;
            background: #FFFFFF;
        }

        .dashboard-panel .card-header h5,
        .dashboard-panel h5 {
            color: #073B78;
            font-size: 16px;
            font-weight: 700;
        }

        /* Menu cepat */
        .quick-action {
            display: flex;
            min-height: 125px;
            flex-direction: column;
            align-items: center;
            justify-content: center;
            gap: 10px;
            padding: 18px 10px;
            border: 1px solid #D8E7F8;
            border-radius: 9px;
            background: #FFFFFF;
            text-align: center;
            transition: 0.2s ease;
        }

        .quick-action:hover {
            background: #F0F7FF;
            border-color: #83BDF4;
            transform: translateY(-2px);
        }

        .quick-action-icon {
            display: flex;
            width: 48px;
            height: 48px;
            align-items: center;
            justify-content: center;
            border-radius: 50%;
            background: #E3F1FF;
            color: #0878D1;
            font-size: 23px;
        }

        .quick-action-label {
            color: #073B78;
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

        /* Grafik */
        .chart-container {
            position: relative;
            width: 100%;
            max-width: 430px;
            margin: 0 auto;
        }

        /* Hindari elemen dashboard melebar keluar layar */
        .content,
        .content > *,
        .content .row,
        .content .card {
            min-width: 0;
            max-width: 100%;
        }

        @media (max-width: 768px) {
            .dashboard-heading {
                font-size: 24px;
            }

            .stat-card {
                padding: 16px !important;
            }

            .stat-card h2 {
                font-size: 25px;
            }

            .stat-icon {
                width: 42px;
                height: 42px;
                font-size: 21px;
            }

            .quick-action {
                min-height: 105px;
            }
        }
    </style>

<div class="d-flex justify-content-between align-items-center mb-4">

    <div>
        <h3 class="fw-bold mb-1">
            Dashboard
        </h3>

        <p class="text-muted mb-0">
            Sistem Inventaris IT Server Room Pelindo Regional 1
        </p>
    </div>

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

                <div class="col-md-4">
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

                <div class="col-md-4">
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

                
                <div class="col-md-4">
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

            <div class="d-flex justify-content-between align-items-center py-3 border-bottom">
                <span class="text-muted small">Sistem</span>
                <span class="fw-semibold small">Pelindo Inventory</span>
            </div>

            <div class="d-flex justify-content-between align-items-center py-3 border-bottom">
                <span class="text-muted small">Regional</span>
                <span class="fw-semibold small">Regional 1</span>
            </div>

            <div class="d-flex justify-content-between align-items-center py-3">
                <span class="text-muted small">Lokasi</span>
                <span class="fw-semibold small">IT Server Room</span>
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
<div class="card border-0 shadow-sm mt-4">
    <div class="card-header bg-white py-3">
        <h5 class="fw-bold mb-0">
            <i class="bi bi-pie-chart me-2 text-primary"></i>
            Grafik Kondisi Aset
        </h5>
    </div>

    <div class="card-body">
        <div style="max-width: 500px; margin: 0 auto;">
            <canvas id="assetConditionChart"></canvas>
        </div>
    </div>
</div>

<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>

<script>
document.addEventListener('DOMContentLoaded', function () {
    const canvas = document.getElementById('assetConditionChart');

    if (!canvas) return;

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
                borderWidth: 1
            }]
        },
        options: {
            responsive: true,
            maintainAspectRatio: true,
            plugins: {
                legend: {
                    position: 'bottom'
                }
            }
        }
    });
});
</script>

@endsection