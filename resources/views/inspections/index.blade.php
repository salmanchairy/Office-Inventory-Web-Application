
@extends('layouts.app')

@section('title', 'Pemeriksaan Aset')

@section('page-title', 'Pemeriksaan Aset')

@section('content')

<style>
    .inspection-heading {
        color: #073B78;
        font-size: 24px;
        font-weight: 700;
    }

    .inspection-subtitle {
        color: #7186A2;
        font-size: 14px;
    }

    .inspection-card {
        border: 1px solid #E1EAF5;
        border-radius: 12px;
        background: #FFFFFF;
        box-shadow: 0 4px 14px rgba(31, 82, 130, 0.05);
        overflow: hidden;
    }

    .inspection-card-header {
        padding: 20px 24px;
        border-bottom: 1px solid #E7EEF6;
    }

    .inspection-card-header h5 {
        color: #073B78;
        font-size: 16px;
        font-weight: 700;
        margin: 0;
    }

    .inspection-table {
        width: 100%;
        margin-bottom: 0;
        min-width: 780px;
    }

    .inspection-table thead th {
        padding: 14px 16px;
        background: #F2F7FC;
        color: #617A99;
        font-size: 12px;
        font-weight: 700;
        white-space: nowrap;
        border-bottom: 1px solid #E1EAF5;
    }

    .inspection-table tbody td {
        padding: 15px 16px;
        color: #244363;
        font-size: 13px;
        vertical-align: middle;
        border-bottom: 1px solid #E8EFF7;
    }

    .inspection-table tbody tr:hover {
        background: #F7FAFE;
    }

    .inspection-asset-code {
        color: #0876B9;
        font-weight: 700;
        white-space: nowrap;
    }

    .inspection-badge {
        display: inline-block;
        padding: 6px 11px;
        border-radius: 20px;
        font-size: 12px;
        font-weight: 700;
        white-space: nowrap;
    }

    .condition-good {
        background: #E5F7EC;
        color: #18864A;
    }

    .condition-minor {
        background: #FFF3D7;
        color: #9B6900;
    }

    .condition-major {
        background: #FFE5E5;
        color: #C32C2C;
    }

    .condition-other {
        background: #EDF1F5;
        color: #607080;
    }

    .btn-inspection {
        display: inline-block;
        padding: 8px 15px;
        border-radius: 7px;
        background: #0876B9;
        color: #FFFFFF;
        font-size: 13px;
        font-weight: 600;
        text-decoration: none;
        white-space: nowrap;
    }

    .btn-inspection:hover {
        background: #075A91;
        color: #FFFFFF;
    }

    .inspection-footer {
        padding: 16px 24px;
        border-top: 1px solid #E8EFF7;
    }

    @media (max-width: 768px) {
        .inspection-heading {
            font-size: 21px;
        }

        .inspection-card-header,
        .inspection-footer {
            padding: 16px;
        }
    }
</style>

<div class="d-flex justify-content-between align-items-center flex-wrap gap-3 mb-4">

    <div>
        <h3 class="inspection-heading mb-1">
            <i class="bi bi-clipboard-check me-2"></i>
            Pemeriksaan Aset
        </h3>

        <p class="inspection-subtitle mb-0">
            Pilih perangkat yang ingin diperiksa.
        </p>
    </div>

    <a href="{{ route('dashboard') }}"
       class="btn btn-outline-primary btn-sm">
        <i class="bi bi-arrow-left me-1"></i>
        Kembali ke Dashboard
    </a>

</div>

<form method="GET" class="card border-0 shadow-sm mb-4">
    <div class="card-body row g-3 align-items-end">
        <div class="col-md-5"><label class="form-label" for="search">Cari aset atau lokasi</label><input class="form-control" id="search" name="search" value="{{ $filters['search'] ?? '' }}" placeholder="Kode, merek, nomor seri, atau lokasi"></div>
        <div class="col-md-3"><label class="form-label" for="condition">Kondisi</label><select class="form-select" id="condition" name="condition"><option value="">Semua kondisi</option>@foreach(['Baik', 'Rusak Ringan', 'Rusak Berat'] as $condition)<option value="{{ $condition }}" @selected(($filters['condition'] ?? '') === $condition)>{{ $condition }}</option>@endforeach</select></div>
        <div class="col-md-2"><label class="form-label" for="not_inspected_since">Belum diperiksa sejak</label><input class="form-control" id="not_inspected_since" name="not_inspected_since" type="date" value="{{ $filters['not_inspected_since'] ?? '' }}"></div>
        <div class="col-md-2 d-flex gap-2"><button class="btn btn-primary flex-grow-1"><i class="bi bi-funnel me-1"></i>Filter</button><a class="btn btn-outline-secondary" href="{{ route('inspections.index') }}">Reset</a></div>
    </div>
</form>

<div class="inspection-card">

    <div class="inspection-card-header">
        <h5>
            <i class="bi bi-box-seam me-2 text-primary"></i>
            Daftar Inventaris ({{ $assets->total() }} Aset)
        </h5>
    </div>

    <div class="table-responsive">

        <table class="table inspection-table">

            <thead>
                <tr>
                    <th>No.</th>
                    <th>Kode Aset</th>
                    <th>Nama / Merek</th>
                    <th>Kategori</th>
                    <th>Lokasi</th>
                    <th>Kondisi</th>
                    <th>Aksi</th>
                </tr>
            </thead>

            <tbody>

                @forelse ($assets as $asset)

                    <tr>
                        <td>
                            {{ $assets->firstItem() + $loop->index }}
                        </td>

                        <td>
                            <span class="inspection-asset-code">
                                {{ $asset->asset_code }}
                            </span>
                        </td>

                        <td>
                            <div class="fw-semibold">
                                {{ $asset->brand ?: '-' }}
                            </div>
                        </td>

                        <td>
                            {{ $asset->category?->name ?? '-' }}
                        </td>

                        <td>
                            {{ $asset->location?->room ?? '-' }}
                        </td>

                        <td>
                            @php
                                $conditionClass = match ($asset->condition) {
                                    'Baik' => 'condition-good',
                                    'Rusak Ringan' => 'condition-minor',
                                    'Rusak Berat' => 'condition-major',
                                    default => 'condition-other',
                                };
                            @endphp

                            <span class="inspection-badge {{ $conditionClass }}">
                                {{ $asset->condition ?? '-' }}
                            </span>
                        </td>

                        <td>
                            <a href="{{ route('inspections.create', $asset) }}"
                               class="btn-inspection">
                                <i class="bi bi-clipboard-check me-1"></i>
                                Periksa
                            </a>
                        </td>
                    </tr>

                @empty

                    <tr>
                        <td colspan="7" class="text-center py-5 text-muted">
                            <i class="bi bi-inbox fs-2 d-block mb-2"></i>
                            Belum ada aset yang terdaftar.
                        </td>
                    </tr>

                @endforelse

            </tbody>

        </table>

    </div>

    @if ($assets->hasPages())

        <div class="inspection-footer d-flex justify-content-between align-items-center flex-wrap gap-3">

            <small class="text-muted">
                Menampilkan {{ $assets->firstItem() }}
                sampai {{ $assets->lastItem() }}
                dari {{ $assets->total() }} aset
            </small>

            <div class="d-flex gap-2">

                @if ($assets->onFirstPage())
                    <span class="btn btn-outline-secondary btn-sm disabled">
                        Sebelumnya
                    </span>
                @else
                    <a href="{{ $assets->previousPageUrl() }}"
                       class="btn btn-outline-primary btn-sm">
                        Sebelumnya
                    </a>
                @endif

                @if ($assets->hasMorePages())
                    <a href="{{ $assets->nextPageUrl() }}"
                       class="btn btn-outline-primary btn-sm">
                        Berikutnya
                    </a>
                @else
                    <span class="btn btn-outline-secondary btn-sm disabled">
                        Berikutnya
                    </span>
                @endif

            </div>

        </div>

    @endif

</div>

@endsection
