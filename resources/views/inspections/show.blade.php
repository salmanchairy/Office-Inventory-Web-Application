
@extends('layouts.app')

@section('title', 'Detail Riwayat Pemeriksaan')
@section('page-title', 'Detail Pemeriksaan')

@section('content')

<div class="container-fluid">

    {{-- Judul dan Navigasi --}}
    <div class="d-flex flex-wrap justify-content-between align-items-center gap-3 mb-4">
        <div>
            <h2 class="fw-bold mb-1">Detail Riwayat Pemeriksaan</h2>
            <p class="text-muted mb-0">
                Informasi lengkap hasil pemeriksaan aset IT Server Room Pelindo Regional 1.
            </p>
        </div>

        <a href="{{ route('inspections.history') }}"
           class="btn btn-outline-secondary">
            <i class="bi bi-arrow-left me-1"></i>
            Kembali ke Riwayat
        </a>
    </div>

    {{-- Informasi Aset --}}
    <div class="card border-0 shadow-sm mb-4">
        <div class="card-header bg-white py-3">
            <h5 class="fw-semibold mb-0">
                <i class="bi bi-pc-display me-2"></i>
                Informasi Aset
            </h5>
        </div>

        <div class="card-body">
            <div class="row g-3">

                <div class="col-md-6">
                    <small class="text-muted">Kode Inventaris</small>
                    <div class="fw-semibold">
                        {{ $inspection->asset?->asset_code ?? '-' }}
                    </div>
                </div>

                <div class="col-md-6">
                    <small class="text-muted">Kategori</small>
                    <div>
                        {{ $inspection->asset?->category?->name ?? '-' }}
                    </div>
                </div>

                <div class="col-md-6">
                    <small class="text-muted">Merek</small>
                    <div>
                        {{ $inspection->asset?->brand ?? '-' }}
                    </div>
                </div>

                <div class="col-md-6">
                    <small class="text-muted">Model</small>
                    <div>
                        {{ $inspection->asset?->model ?: '-' }}
                    </div>
                </div>

                <div class="col-md-6">
                    <small class="text-muted">Serial Number Terdaftar</small>
                    <div>
                        {{ $inspection->asset?->serial_number ?? '-' }}
                    </div>
                </div>

                <div class="col-md-6">
                    <small class="text-muted">Lokasi</small>
                    <div>
                        {{ $inspection->asset?->location?->regional ?? '-' }}

                        @if ($inspection->asset?->location?->room)
                            - {{ $inspection->asset->location->room }}
                        @endif
                    </div>
                </div>

            </div>

            @if ($inspection->asset)
                <div class="mt-4">
                    <a href="{{ route('assets.show', $inspection->asset) }}"
                       class="btn btn-outline-primary btn-sm">
                        <i class="bi bi-box-seam me-1"></i>
                        Lihat Detail Aset
                    </a>
                </div>
            @endif
        </div>
    </div>

    {{-- Hasil Pemeriksaan --}}
    <div class="card border-0 shadow-sm mb-4">
        <div class="card-header bg-white py-3">
            <h5 class="fw-semibold mb-0">
                <i class="bi bi-clipboard-check me-2"></i>
                Hasil Pemeriksaan
            </h5>
        </div>

        <div class="card-body">
            <div class="row g-4">

                <div class="col-md-6">
                    <small class="text-muted">Tanggal Pemeriksaan</small>
                    <div class="fw-semibold">
                        {{ $inspection->inspection_date
                            ? \Carbon\Carbon::parse($inspection->inspection_date)->format('d/m/Y H:i')
                            : '-' }}
                    </div>
                </div>

                <div class="col-md-6">
                    <small class="text-muted">Petugas Pemeriksaan</small>
                    <div class="fw-semibold">
                        {{ $inspection->user?->name ?? '-' }}
                    </div>
                </div>

                <div class="col-md-6">
                    <small class="text-muted">Kondisi Saat Pemeriksaan</small>
                    <div class="mt-1">
                        @if ($inspection->condition === 'Baik')
                            <span class="badge bg-success">Baik</span>
                        @elseif ($inspection->condition === 'Rusak Ringan')
                            <span class="badge bg-warning text-dark">
                                Rusak Ringan
                            </span>
                        @elseif ($inspection->condition === 'Rusak Berat')
                            <span class="badge bg-danger">
                                Rusak Berat
                            </span>
                        @else
                            <span class="badge bg-secondary">
                                {{ $inspection->condition ?? '-' }}
                            </span>
                        @endif
                    </div>
                </div>

                <div class="col-md-6">
                    <small class="text-muted">Kecocokan Fisik</small>
                    <div class="mt-1">
                        @if ($inspection->physical_check === 'Sesuai')
                            <span class="badge bg-success">Sesuai</span>
                        @elseif ($inspection->physical_check === 'Tidak Sesuai')
                            <span class="badge bg-danger">
                                Tidak Sesuai
                            </span>
                        @else
                            <span class="badge bg-secondary">
                                {{ $inspection->physical_check ?? '-' }}
                            </span>
                        @endif
                    </div>
                </div>

                <div class="col-12">
                    <small class="text-muted">
                        Serial Number yang Ditemukan
                    </small>
                    <div class="fw-semibold">
                        {{ $inspection->serial_number_checked ?: '-' }}
                    </div>
                </div>

                <div class="col-12">
                    <small class="text-muted">Catatan Pemeriksaan</small>
                    <div class="mt-1">
                        {!! nl2br(e($inspection->description ?: '-')) !!}
                    </div>
                </div>

                <div class="col-12">
                    <small class="text-muted">Rekomendasi Tindakan</small>
                    <div class="mt-1">
                        {!! nl2br(e($inspection->recommendation ?: '-')) !!}
                    </div>
                </div>

            </div>
        </div>
    </div>

    {{-- Dokumentasi Foto --}}
    <div class="card border-0 shadow-sm mb-4">
        <div class="card-header bg-white py-3">
            <div class="d-flex flex-wrap justify-content-between align-items-center gap-2">
                <h5 class="fw-semibold mb-0">
                    <i class="bi bi-images me-2"></i>
                    Dokumentasi Foto Pemeriksaan
                </h5>

                <span class="badge bg-primary">
                    {{ $inspection->photos->count() }} Foto
                </span>
            </div>
        </div>

        <div class="card-body">

            @if ($inspection->photos->isNotEmpty())

                <div class="row g-3">
                    @foreach ($inspection->photos as $photo)
                        <div class="col-6 col-md-4 col-lg-3">
                            <a href="{{ asset('storage/' . $photo->file_path) }}"
                               target="_blank"
                               rel="noopener noreferrer"
                               class="text-decoration-none">

                                <img
                                    src="{{ asset('storage/' . $photo->file_path) }}"
                                    alt="Foto pemeriksaan aset"
                                    class="img-fluid rounded border w-100"
                                    style="height: 190px; object-fit: cover;"
                                    loading="lazy"
                                >

                                <small class="text-muted d-block mt-2">
                                    <i class="bi bi-zoom-in me-1"></i>
                                    Klik untuk memperbesar
                                </small>
                            </a>
                        </div>
                    @endforeach
                </div>

            @else

                <div class="text-center text-muted py-4">
                    <i class="bi bi-image fs-1 d-block mb-2"></i>
                    Tidak ada foto pada pemeriksaan ini.
                </div>

            @endif

        </div>
    </div>

    {{-- Tombol Navigasi --}}
    <div class="d-flex flex-wrap justify-content-end gap-2">

        <a href="{{ route('inspections.history') }}"
           class="btn btn-outline-secondary">
            <i class="bi bi-arrow-left me-1"></i>
            Kembali
        </a>

        @if ($inspection->asset)
            <a href="{{ route('assets.show', $inspection->asset) }}"
               class="btn btn-primary">
                <i class="bi bi-box-seam me-1"></i>
                Detail Aset
            </a>
        @endif

    </div>

</div>

@endsection
