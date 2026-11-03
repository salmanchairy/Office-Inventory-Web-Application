
@extends('layouts.app')

@section('content')
<div class="container-fluid">

    {{-- Judul Halaman --}}
    <div class="d-flex flex-wrap justify-content-between align-items-center gap-3 mb-4">
        <div>
            <h2 class="fw-bold mb-1">Riwayat Pemeriksaan Aset</h2>
            <p class="text-muted mb-0">
                Daftar seluruh hasil pemeriksaan perangkat IT Server Room Pelindo Regional 1.
            </p>
        </div>

        <a href="{{ route('inspections.index') }}"
           class="btn btn-primary">
            <i class="bi bi-clipboard-check me-1"></i>
            Pemeriksaan Aset
        </a>
    </div>

    {{-- Pencarian --}}
    <div class="card border-0 shadow-sm mb-4">
        <div class="card-body">
            <form action="{{ route('inspections.history') }}"
                  method="GET"
                  class="row g-3 align-items-end">

                <div class="col-md-9">
                    <label for="search" class="form-label fw-semibold">
                        Cari Riwayat Pemeriksaan
                    </label>

                    <input
                        type="text"
                        name="search"
                        id="search"
                        class="form-control"
                        value="{{ $search }}"
                        placeholder="Kode inventaris, merek, model, atau serial number"
                    >
                </div>

                <div class="col-md-3">
                    <div class="d-flex gap-2">
                        <button type="submit"
                                class="btn btn-primary flex-fill">
                            <i class="bi bi-search me-1"></i>
                            Cari
                        </button>

                        <a href="{{ route('inspections.history') }}"
                           class="btn btn-outline-secondary">
                            Reset
                        </a>
                    </div>
                </div>

            </form>
        </div>
    </div>

    {{-- Tabel Riwayat --}}
    <div class="card border-0 shadow-sm">
        <div class="card-header bg-white py-3">
            <div class="d-flex justify-content-between align-items-center">
                <h5 class="fw-semibold mb-0">
                    <i class="bi bi-clock-history me-2"></i>
                    Data Riwayat Pemeriksaan
                </h5>

                <span class="badge bg-primary">
                    {{ $inspections->total() }} Pemeriksaan
                </span>
            </div>
        </div>

        <div class="card-body">

            <div class="table-responsive">
                <table class="table table-hover table-bordered align-middle">
                    <thead class="table-light">
                        <tr>
                            <th width="60">No.</th>
                            <th>Tanggal</th>
                            <th>Kode Inventaris</th>
                            <th>Perangkat</th>
                            <th>Kondisi</th>
                            <th>Petugas</th>
                            <th class="text-center">Foto</th>
                            <th class="text-center">Aksi</th>
                        </tr>
                    </thead>

                    <tbody>
                        @forelse ($inspections as $inspection)
                            <tr>
                                <td>
                                    {{ $inspections->firstItem() + $loop->index }}
                                </td>

                                <td>
                                    {{ \Carbon\Carbon::parse($inspection->inspection_date)->format('d/m/Y H:i') }}
                                </td>

                                <td>
                                    <span class="fw-semibold">
                                        {{ $inspection->asset?->asset_code ?? '-' }}
                                    </span>
                                </td>

                                <td>
                                    <div class="fw-semibold">
                                        {{ $inspection->asset?->brand ?? '-' }}
                                    </div>

                                    <small class="text-muted">
                                        {{ $inspection->asset?->model ?: '-' }}
                                    </small>
                                </td>

                                <td>
                                    @if ($inspection->condition === 'Baik')
                                        <span class="badge bg-success">
                                            Baik
                                        </span>
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
                                            {{ $inspection->condition }}
                                        </span>
                                    @endif
                                </td>

                                <td>
                                    {{ $inspection->user?->name ?? '-' }}
                                </td>

                                <td class="text-center">
                                    <span class="badge bg-secondary">
                                        {{ $inspection->photos->count() }} Foto
                                    </span>
                                </td>

                                <td class="text-center">
                                    <div class="d-flex flex-wrap justify-content-center gap-2">

                                        {{-- Detail hasil pemeriksaan --}}
                                        <a href="{{ route('inspections.show', $inspection) }}"
                                        class="btn btn-sm btn-primary">
                                            <i class="bi bi-clipboard-check me-1"></i>
                                            Detail Pemeriksaan
                                        </a>

                                        {{-- Detail aset terkait --}}
                                        @if ($inspection->asset)
                                            <a href="{{ route('assets.show', $inspection->asset) }}"
                                            class="btn btn-sm btn-outline-primary">
                                                <i class="bi bi-box-seam me-1"></i>
                                                Detail Aset
                                            </a>
                                        @endif

                                    </div>
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="8"
                                    class="text-center text-muted py-5">
                                    <i class="bi bi-inbox fs-1 d-block mb-2"></i>

                                    @if ($search !== '')
                                        Tidak ada riwayat pemeriksaan yang cocok
                                        dengan pencarian Anda.
                                    @else
                                        Belum ada riwayat pemeriksaan aset.
                                    @endif
                                </td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>

            {{-- Pagination --}}
            @if ($inspections->hasPages())
                <div class="mt-3">
                    {{ $inspections->links() }}
                </div>
            @endif

        </div>
    </div>

</div>
@endsection
