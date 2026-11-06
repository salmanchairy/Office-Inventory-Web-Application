@extends('layouts.app')

@section('title', 'Detail Asset')

@section('page-title', 'Detail Asset')

@section('content')

<div class="container-fluid px-0">

    {{-- Header --}}
    <div class="d-flex justify-content-between align-items-center mb-4">

        <div>
            <h4 class="mb-1">
                Detail Asset
            </h4>

            <p class="text-muted mb-0">
                Informasi lengkap asset inventaris
            </p>
        </div>

        <div class="d-flex gap-2">

            <a
                href="{{ route('assets.edit', $asset) }}"
                class="btn btn-warning"
            >
                <i class="bi bi-pencil me-1"></i>
                Edit
            </a>

            <a
                href="{{ route('assets.index') }}"
                class="btn btn-outline-secondary"
            >
                <i class="bi bi-arrow-left me-1"></i>
                Kembali
            </a>

            <a href="{{ route('inspections.create', $asset) }}"
            class="btn btn-primary">
                <i class="bi bi-clipboard-check me-1"></i>
                Mulai Pemeriksaan
            </a>

            <a href="{{ route('assets.move.create', $asset) }}" class="btn btn-outline-primary">
                <i class="bi bi-arrow-left-right me-1"></i>Pindahkan
            </a>

        </div>

    </div>


    <div class="row g-4">

        {{-- INFORMASI UTAMA --}}
        <div class="col-lg-8">

            <div class="card border-0 shadow-sm mb-4">

                <div class="card-header bg-white py-3">

                    <h6 class="mb-0 fw-semibold">

                        <i class="bi bi-box-seam me-2"></i>

                        Informasi Asset

                    </h6>

                </div>


                <div class="card-body">

                    <div class="row g-4">

                        {{-- Asset Code --}}
                        <div class="col-md-6">

                            <small class="text-muted">
                                ID Inventaris
                            </small>

                            <div class="mt-1">

                                <span class="badge text-bg-dark fs-6">

                                    {{ $asset->asset_code }}

                                </span>

                            </div>

                        </div>


                        {{-- Kategori --}}
                        <div class="col-md-6">

                            <small class="text-muted">
                                Kategori
                            </small>

                            <div class="fw-semibold mt-1">

                                {{ $asset->category->name ?? '-' }}

                            </div>

                        </div>


                        {{-- Brand --}}
                        <div class="col-md-6">

                            <small class="text-muted">
                                Brand / Merek
                            </small>

                            <div class="fw-semibold mt-1">

                                {{ $asset->brand }}

                            </div>

                        </div>


                        {{-- Model --}}
                        <div class="col-md-6">

                            <small class="text-muted">
                                Model
                            </small>

                            <div class="fw-semibold mt-1">

                                {{ $asset->model ?: '-' }}

                            </div>

                        </div>


                        {{-- Serial Number --}}
                        <div class="col-md-6">

                            <small class="text-muted">
                                Serial Number
                            </small>

                            <div class="mt-1">

                                <code class="fs-6">

                                    {{ $asset->serial_number }}

                                </code>

                            </div>

                        </div>


                        {{-- Lokasi --}}
                        <div class="col-md-6">

                            <small class="text-muted">
                                Lokasi
                            </small>

                            <div class="fw-semibold mt-1">

                                @if($asset->location)

                                    {{ $asset->location->regional }}

                                    <br>

                                    <small class="text-muted">

                                        {{ $asset->location->site }}
                                        -
                                        {{ $asset->location->building }}
                                        -
                                        {{ $asset->location->room }}

                                    </small>

                                @else

                                    -

                                @endif

                            </div>

                        </div>


                        {{-- Kondisi --}}
                        <div class="col-md-6">

                            <small class="text-muted">
                                Kondisi
                            </small>

                            <div class="mt-1">

                                @if($asset->condition === 'Baik')

                                    <span class="badge text-bg-success">
                                        Baik
                                    </span>

                                @elseif($asset->condition === 'Rusak Ringan')

                                    <span class="badge text-bg-warning">
                                        Rusak Ringan
                                    </span>

                                @else

                                    <span class="badge text-bg-danger">
                                        Rusak Berat
                                    </span>

                                @endif

                            </div>

                        </div>


                        {{-- Status --}}
                        <div class="col-md-6">

                            <small class="text-muted">
                                Status
                            </small>

                            <div class="mt-1">

                                @if($asset->status === 'Aktif')

                                    <span class="badge text-bg-success">
                                        Aktif
                                    </span>

                                @elseif($asset->status === 'Tidak Aktif')

                                    <span class="badge text-bg-secondary">
                                        Tidak Aktif
                                    </span>

                                @elseif($asset->status === 'Diperbaiki')

                                    <span class="badge text-bg-warning">
                                        Diperbaiki
                                    </span>

                                @else

                                    <span class="badge text-bg-info">
                                        {{ $asset->status }}
                                    </span>

                                @endif

                            </div>

                        </div>


                        {{-- Tahun --}}
                        <div class="col-md-6">

                            <small class="text-muted">
                                Tahun Perolehan
                            </small>

                            <div class="fw-semibold mt-1">

                                {{ $asset->acquisition_year ?: '-' }}

                            </div>

                        </div>


                        {{-- Tanggal --}}
                        <div class="col-md-6">

                            <small class="text-muted">
                                Tanggal Pembelian
                            </small>

                            <div class="fw-semibold mt-1">

                                {{ $asset->purchase_date
                                    ? $asset->purchase_date->format('d-m-Y')
                                    : '-'
                                }}

                            </div>

                        </div>


                        {{-- Deskripsi --}}
                        <div class="col-12">

                            <small class="text-muted">
                                Deskripsi / Keterangan
                            </small>

                            <div class="mt-1">

                                {{ $asset->description ?: 'Tidak ada keterangan.' }}

                            </div>

                        </div>

                    </div>

                </div>

            </div>


            {{-- RIWAYAT PEMERIKSAAN --}}
            <div class="card border-0 shadow-sm">

                <div class="card-header bg-white py-3">

                    <div class="d-flex justify-content-between">

                        <h6 class="mb-0 fw-semibold">

                            <i class="bi bi-clipboard-check me-2"></i>

                            Riwayat Pemeriksaan

                        </h6>

                        <span class="badge text-bg-secondary">

                            {{ $asset->inspections->count() }}

                            pemeriksaan

                        </span>

                    </div>

                </div>


                <div class="card-body p-0">

                    @forelse($asset->inspections as $inspection)

                        <div class="p-3 border-bottom">

                            <div class="d-flex justify-content-between">

                                <div>

                                    <div class="fw-semibold">

                                        Pemeriksaan
                                        #{{ $inspection->id }}

                                    </div>

                                    <small class="text-muted">

                                        {{ $inspection->inspection_date
                                            ? $inspection->inspection_date->format('d-m-Y H:i')
                                            : '-'
                                        }}

                                    </small>

                                </div>


                                <div>

                                    @if($inspection->condition === 'Baik')

                                        <span class="badge text-bg-success">
                                            Baik
                                        </span>

                                    @elseif($inspection->condition === 'Rusak Ringan')

                                        <span class="badge text-bg-warning">
                                            Rusak Ringan
                                        </span>

                                    @else

                                        <span class="badge text-bg-danger">
                                            Rusak Berat
                                        </span>

                                    @endif

                                </div>

                            </div>


                            <div class="mt-2">

                                <small class="text-muted">
                                    Diperiksa oleh:
                                </small>

                                <strong>
                                    {{ $inspection->user->name ?? '-' }}
                                </strong>

                            </div>


                            <div class="mt-1">

                                <small class="text-muted">
                                    Serial Number:
                                </small>

                                <code>
                                    {{ $inspection->serial_number_checked ?: '-' }}
                                </code>

                            </div>


                            <div class="mt-1">

                                <small class="text-muted">
                                    Pemeriksaan fisik:
                                </small>

                                @if($inspection->physical_check === 'Sesuai')

                                    <span class="text-success fw-semibold">
                                        Sesuai
                                    </span>

                                @else

                                    <span class="text-danger fw-semibold">
                                        Tidak Sesuai
                                    </span>

                                @endif

                            </div>

                            {{-- Keterangan Pemeriksaan --}}
                            <div class="mt-3">
                                <div class="small text-muted">
                                    Keterangan Pemeriksaan:
                                </div>

                                <div class="mt-1">
                                    {{ $inspection->description ?: 'Tidak ada keterangan.' }}
                                </div>
                            </div>

                            {{-- Rekomendasi Perbaikan --}}
                            <div class="mt-2">
                                <div class="small text-muted">
                                    Rekomendasi Perbaikan:
                                </div>

                                <div class="mt-1">
                                    {{ $inspection->recommendation ?: 'Tidak ada rekomendasi.' }}
                                </div>
                            </div>

                            {{-- Foto Bukti Pemeriksaan --}}
                            @if($inspection->photos->isNotEmpty())
                                <div class="mt-3">
                                    <div class="small text-muted mb-2">
                                        Foto Bukti Pemeriksaan:
                                    </div>

                                    <div class="d-flex flex-wrap gap-3">
                                        @foreach($inspection->photos as $photo)
                                            <a
                                                href="{{ asset('storage/' . $photo->file_path) }}"
                                                target="_blank"
                                                rel="noopener noreferrer"
                                            >
                                                <img
                                                    src="{{ asset('storage/' . $photo->file_path) }}"
                                                    alt="Foto pemeriksaan aset"
                                                    class="img-thumbnail"
                                                    style="width: 150px; height: 120px; object-fit: cover;"
                                                >
                                            </a>
                                        @endforeach
                                    </div>
                                </div>
                            @endif


                        </div>

                    @empty

                        <div class="text-center py-5">

                            <i
                                class="bi bi-clipboard-x"
                                style="font-size: 40px; color: #adb5bd;"
                            ></i>

                            <p class="text-muted mt-2 mb-0">

                                Belum ada riwayat pemeriksaan.

                            </p>

                        </div>

                    @endforelse

                </div>

            </div>

        </div>


        {{-- SIDEBAR DETAIL --}}
        <div class="col-lg-4">


            {{-- QR CODE --}}
            <div class="card border-0 shadow-sm mb-4">

                <div class="card-header bg-white py-3">

                    <h6 class="mb-0 fw-semibold">

                        <i class="bi bi-qr-code me-2"></i>

                        QR Code Asset

                    </h6>

                </div>


                <div class="card-body text-center">

                    <div
                        class="border rounded p-4 mb-3"
                        style="background: #f8f9fa;"
                    >

                        <div class="py-3 text-center">
                            <img
                                src="/assets/{{ $asset->getRouteKey() }}/qr"
                                alt="QR Code {{ $asset->asset_code }}"
                                class="img-fluid"
                                style="max-width: 250px;"
                            >
                        </div>

                    </div>


                    <div class="fw-bold fs-5">

                        {{ $asset->asset_code }}

                    </div>

                    <small class="text-muted">

                        QR Code akan digunakan untuk
                        pemeriksaan asset.

                    </small>

                    <div class="d-flex justify-content-center gap-2 mt-3">
                        <button type="button" class="btn btn-sm btn-outline-primary" data-download-qr data-qr-url="{{ route('assets.qr', $asset) }}" data-code="{{ $asset->asset_code }}" data-name="{{ trim($asset->brand . ' ' . $asset->model) }}" data-serial="{{ $asset->serial_number }}"><i class="bi bi-download me-1"></i>Unduh PNG</button>
                        <a href="{{ route('assets.qr.print', $asset) }}" target="_blank" rel="noopener" class="btn btn-sm btn-outline-dark"><i class="bi bi-printer me-1"></i>Cetak</a>
                    </div>

                </div>

            </div>


            {{-- INFORMASI LOKASI --}}
            <div class="card border-0 shadow-sm mb-4">

                <div class="card-header bg-white py-3">

                    <h6 class="mb-0 fw-semibold">

                        <i class="bi bi-geo-alt me-2"></i>

                        Lokasi Asset

                    </h6>

                </div>


                <div class="card-body">

                    @if($asset->location)

                        <div class="mb-2">

                            <small class="text-muted">
                                Regional
                            </small>

                            <div class="fw-semibold">
                                {{ $asset->location->regional }}
                            </div>

                        </div>


                        <div class="mb-2">

                            <small class="text-muted">
                                Site
                            </small>

                            <div class="fw-semibold">
                                {{ $asset->location->site }}
                            </div>

                        </div>


                        <div class="mb-2">

                            <small class="text-muted">
                                Gedung
                            </small>

                            <div class="fw-semibold">
                                {{ $asset->location->building }}
                            </div>

                        </div>


                        <div>

                            <small class="text-muted">
                                Ruangan
                            </small>

                            <div class="fw-semibold">
                                {{ $asset->location->room }}
                            </div>

                        </div>

                    @else

                        <div class="text-muted">
                            Lokasi belum ditentukan.
                        </div>

                    @endif

                </div>

            </div>


            {{-- INFORMASI SISTEM --}}
            <div class="card border-0 shadow-sm">

                <div class="card-header bg-white py-3">

                    <h6 class="mb-0 fw-semibold">

                        <i class="bi bi-info-circle me-2"></i>

                        Informasi Sistem

                    </h6>

                </div>


                <div class="card-body">

                    <div class="mb-3">

                        <small class="text-muted">
                            Dibuat oleh
                        </small>

                        <div class="fw-semibold">

                            {{ $asset->creator->name ?? '-' }}

                        </div>

                    </div>


                    <div class="mb-3">

                        <small class="text-muted">
                            Dibuat pada
                        </small>

                        <div class="fw-semibold">

                            {{ $asset->created_at
                                ? $asset->created_at->format('d-m-Y H:i')
                                : '-'
                            }}

                        </div>

                    </div>


                    <div>

                        <small class="text-muted">
                            Terakhir diperbarui
                        </small>

                        <div class="fw-semibold">

                            {{ $asset->updated_at
                                ? $asset->updated_at->format('d-m-Y H:i')
                                : '-'
                            }}

                        </div>

                    </div>

                </div>

            </div>

        </div>

    </div>

</div>

@endsection

@push('scripts')
<script>
document.querySelectorAll('[data-download-qr]').forEach((button) => button.addEventListener('click', async () => { const svg = await (await fetch(button.dataset.qrUrl)).text(), image = new Image(); image.src = 'data:image/svg+xml;base64,' + btoa(svg); await new Promise((resolve, reject) => { image.onload = resolve; image.onerror = reject; }); const canvas = document.createElement('canvas'), context = canvas.getContext('2d'); canvas.width = 720; canvas.height = 820; context.fillStyle = '#fff'; context.fillRect(0, 0, 720, 820); context.strokeStyle = '#6d9fc8'; context.lineWidth = 3; context.roundRect(18, 18, 684, 784, 18); context.stroke(); context.textAlign = 'center'; context.fillStyle = '#07569b'; context.font = 'bold 28px Arial'; context.fillText('Pelindo Inventory', 360, 70); context.fillStyle = '#173b5d'; context.font = 'bold 27px Arial'; context.fillText(button.dataset.code, 360, 115); context.drawImage(image, 160, 135, 400, 400); context.font = 'bold 23px Arial'; context.fillText(button.dataset.name || '-', 360, 585); context.fillStyle = '#456987'; context.font = '18px Arial'; context.fillText('Nomor seri: ' + (button.dataset.serial || '-'), 360, 625); const link = document.createElement('a'); link.download = button.dataset.code + '-label-qr.png'; link.href = canvas.toDataURL('image/png'); link.click(); }));
</script>
@endpush
