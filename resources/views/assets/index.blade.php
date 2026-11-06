@extends('layouts.app')

@section('title', 'Data Asset')

@section('page-title', 'Data Asset')

@section('content')

<div class="container-fluid px-0">

    {{-- Header --}}
    <div class="d-flex justify-content-between align-items-center mb-4">

        <div>
            <h4 class="mb-1">
                Data Asset
            </h4>

            <p class="text-muted mb-0">
                Daftar seluruh inventaris IT Server Room Pelindo Regional 1
            </p>
        </div>

        <a href="{{ route('assets.create') }}" class="btn btn-warning">
            <i class="bi bi-plus-lg me-1"></i>
            Tambah Asset
        </a>

    </div>


    
    {{-- Notifikasi hasil proses --}}
    @foreach (['success', 'warning', 'error'] as $type)

        @if(session($type))

            <div class="alert alert-{{ $type === 'error' ? 'danger' : $type }} alert-dismissible fade show"
                role="alert">

                @if($type === 'success')
                    <i class="bi bi-check-circle me-2"></i>
                @elseif($type === 'warning')
                    <i class="bi bi-exclamation-triangle me-2"></i>
                @else
                    <i class="bi bi-x-circle me-2"></i>
                @endif

                {{ session($type) }}

                <button
                    type="button"
                    class="btn-close"
                    data-bs-dismiss="alert"
                    aria-label="Tutup"
                ></button>

            </div>

        @endif

    @endforeach


    {{-- Card tabel --}}
    <div class="card border-0 shadow-sm">

        <div class="card-body">


            {{-- Toolbar --}}
            <div class="row mb-3">

                <div class="col-md-6">

                    <form method="GET" class="input-group">

                        <span class="input-group-text bg-white">

                            <i class="bi bi-search"></i>

                        </span>

                        <input
                            type="text"
                            id="searchAsset"
                            name="search"
                            class="form-control"
                            placeholder="Cari asset, serial number, brand..."
                            value="{{ $search }}"
                        >
                        <button class="btn btn-outline-primary" type="submit">Cari</button>
                    </form>

                </div>

                <div class="col-md-6 text-md-end mt-2 mt-md-0">

                    <span class="text-muted">

                        Total:
                        <strong>{{ $assets->total() }}</strong>
                        asset

                    </span>

                </div>

            </div>


            {{-- Tabel --}}
            <div class="table-responsive">

                <table class="table table-hover align-middle" id="assetTable">

                    <thead class="table-light">

                        <tr>

                            <th width="50">
                                No
                            </th>

                            <th>
                                ID Inventaris
                            </th>

                            <th>
                                Perangkat
                            </th>

                            <th>
                                Serial Number
                            </th>

                            <th>
                                Lokasi
                            </th>

                            <th>
                                Kondisi
                            </th>

                            <th>
                                Status
                            </th>

                            <th width="130">
                                Aksi
                            </th>

                        </tr>

                    </thead>


                    <tbody>

                        @forelse($assets as $index => $asset)

                            <tr>

                                {{-- No --}}
                                <td>
                                    {{ $assets->firstItem() + $index }}
                                </td>


                                {{-- Asset Code --}}
                                <td>

                                    <span class="badge text-bg-dark">

                                        {{ $asset->asset_code }}

                                    </span>

                                </td>


                                {{-- Perangkat --}}
                                <td>

                                    <div class="fw-semibold">

                                        {{ $asset->brand }}

                                    </div>

                                    @if($asset->model)

                                        <small class="text-muted">

                                            {{ $asset->model }}

                                        </small>

                                    @endif

                                    <br>

                                    <small class="text-muted">

                                        {{ $asset->category->name ?? '-' }}

                                    </small>

                                </td>


                                {{-- Serial Number --}}
                                <td>

                                    <code>

                                        {{ $asset->serial_number }}

                                    </code>

                                </td>


                                {{-- Lokasi --}}
                                <td>

                                    @if($asset->location)

                                        <div>
                                            {{ $asset->location->regional }}
                                        </div>

                                        <small class="text-muted">

                                            {{ $asset->location->room }}

                                        </small>

                                    @else

                                        -

                                    @endif

                                </td>


                                {{-- Kondisi --}}
                                <td>

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

                                </td>


                                {{-- Status --}}
                                <td>

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

                                </td>


                                {{-- Aksi --}}
                                <td>

                                    <div class="d-flex gap-1">

                                        {{-- Detail --}}
                                        <a
                                            href="{{ route('assets.show', $asset) }}"
                                            class="btn btn-sm btn-outline-primary"
                                            title="Detail"
                                        >

                                            <i class="bi bi-eye"></i>

                                        </a>


                                        {{-- Edit --}}
                                        <a
                                            href="{{ route('assets.edit', $asset) }}"
                                            class="btn btn-sm btn-outline-warning"
                                            title="Edit"
                                        >

                                            <i class="bi bi-pencil"></i>

                                        </a>

                                {{-- Hapus: hanya untuk Administrator --}}
                                @if(auth()->user()?->role?->name === 'admin')

                                    <form
                                        action="{{ route('assets.destroy', $asset) }}"
                                        method="POST"
                                        onsubmit="return confirm(
                                            'PERINGATAN: HAPUS PERMANEN!\n\n' +
                                            'Kode Aset: {{ $asset->asset_code }}\n' +
                                            'Perangkat: {{ $asset->brand }}\n\n' +
                                            'Aset, riwayat pemeriksaan, foto pemeriksaan, dan riwayat perpindahan akan dihapus permanen.\n\n' +
                                            'Data tidak dapat dipulihkan melalui aplikasi.\n\n' +
                                            'Apakah Anda benar-benar ingin melanjutkan?'
                                        );"
                                    >
                                        @csrf
                                        @method('DELETE')

                                        <button
                                            type="submit"
                                            class="btn btn-sm btn-outline-danger"
                                            title="Hapus Permanen"
                                        >
                                            <i class="bi bi-trash"></i>
                                        </button>

                                    </form>

                                @endif


                                    </div>

                                </td>

                            </tr>

                        @empty

                            <tr>

                                <td colspan="8" class="text-center py-5">

                                    <div class="mb-3">

                                        <i
                                            class="bi bi-box-seam"
                                            style="font-size: 45px; color: #adb5bd;"
                                        ></i>

                                    </div>

                                    <h6>
                                        Belum ada data asset
                                    </h6>

                                    <p class="text-muted mb-3">

                                        Silakan tambahkan data asset pertama.

                                    </p>

                                    <a
                                        href="{{ route('assets.create') }}"
                                        class="btn btn-warning"
                                    >

                                        <i class="bi bi-plus-lg me-1"></i>

                                        Tambah Asset

                                    </a>

                                </td>

                            </tr>

                        @endforelse

                    </tbody>

                </table>

            </div>


            {{-- Pagination --}}
            @if($assets->hasPages())

                <div class="mt-3">

                    {{ $assets->links() }}

                </div>

            @endif

        </div>

    </div>

</div>

@endsection
