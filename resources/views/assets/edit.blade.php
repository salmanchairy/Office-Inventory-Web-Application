@extends('layouts.app')

@section('title', 'Edit Aset')

@section('page-title', 'Edit Aset')

@section('content')

<style>
    .edit-heading {
        color: #073B78;
        font-size: 24px;
        font-weight: 700;
    }

    .edit-subtitle {
        color: #7186A2;
        font-size: 14px;
    }

    .edit-card {
        background: #FFFFFF;
        border: 1px solid #E1EAF5;
        border-radius: 12px;
        box-shadow: 0 4px 14px rgba(31, 82, 130, 0.05);
        overflow: hidden;
    }

    .edit-card-header {
        padding: 20px 24px;
        border-bottom: 1px solid #E7EEF6;
        background: #FFFFFF;
    }

    .edit-card-header h5 {
        color: #073B78;
        font-size: 17px;
        font-weight: 700;
        margin: 0;
    }

    .edit-card-body {
        padding: 24px;
    }

    .edit-label {
        color: #244363;
        font-size: 13px;
        font-weight: 600;
        margin-bottom: 7px;
    }

    .edit-card .form-control,
    .edit-card .form-select {
        padding: 11px 13px;
        font-size: 14px;
    }

    .required-mark {
        color: #DC3545;
    }

    .edit-actions {
        display: flex;
        gap: 10px;
        justify-content: flex-end;
        flex-wrap: wrap;
        padding-top: 20px;
        border-top: 1px solid #E7EEF6;
    }

    .btn-save {
        background: #0876B9;
        border-color: #0876B9;
        color: #FFFFFF;
        font-weight: 600;
    }

    .btn-save:hover {
        background: #075A91;
        border-color: #075A91;
        color: #FFFFFF;
    }

    @media (max-width: 768px) {
        .edit-card-header,
        .edit-card-body {
            padding: 16px;
        }

        .edit-heading {
            font-size: 21px;
        }
    }
</style>

<div class="d-flex justify-content-between align-items-center flex-wrap gap-3 mb-4">
    <div>
        <h3 class="edit-heading mb-1">
            <i class="bi bi-pencil-square me-2"></i>
            Edit Data Aset
        </h3>

        <p class="edit-subtitle mb-0">
            Perbarui informasi perangkat inventaris Pelindo Regional 1.
        </p>
    </div>

    <a href="{{ route('assets.show', $asset) }}"
       class="btn btn-outline-primary btn-sm">
        <i class="bi bi-arrow-left me-1"></i>
        Kembali ke Detail
    </a>
</div>

<div class="edit-card">

    <div class="edit-card-header">
        <h5>
            <i class="bi bi-box-seam me-2 text-primary"></i>
            Informasi Aset: {{ $asset->asset_code }}
        </h5>
    </div>

    <div class="edit-card-body">

        @if ($errors->any())
            <div class="alert alert-danger">
                <strong>Data belum berhasil disimpan.</strong>
                <ul class="mb-0 mt-2">
                    @foreach ($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
        @endif

        <form action="{{ route('assets.update', $asset) }}" method="POST">
            @csrf
            @method('PUT')

            <div class="row g-3">

                <!-- Kode Aset -->
                <div class="col-md-6">
                    <label class="edit-label">Kode Aset</label>
                    <input type="text"
                           class="form-control"
                           value="{{ $asset->asset_code }}"
                           readonly>

                    <small class="text-muted">
                        Kode inventaris tidak dapat diubah.
                    </small>
                </div>

                <!-- Kategori -->
                <div class="col-md-6">
                    <label for="category_id" class="edit-label">
                        Kategori <span class="required-mark">*</span>
                    </label>

                    <select name="category_id"
                            id="category_id"
                            class="form-select @error('category_id') is-invalid @enderror"
                            required>
                        <option value="">-- Pilih Kategori --</option>

                        @foreach ($categories as $category)
                            <option value="{{ $category->id }}"
                                @selected(old('category_id', $asset->category_id) == $category->id)>
                                {{ $category->name }}
                            </option>
                        @endforeach
                    </select>

                    @error('category_id')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>

                <!-- Lokasi -->
                <div class="col-md-6">
                    <label for="location_id" class="edit-label">
                        Lokasi <span class="required-mark">*</span>
                    </label>

                    <select name="location_id"
                            id="location_id"
                            class="form-select @error('location_id') is-invalid @enderror"
                            disabled>
                        <option value="">-- Pilih Lokasi --</option>

                        @foreach ($locations as $location)
                            <option value="{{ $location->id }}"
                                @selected(old('location_id', $asset->location_id) == $location->id)>
                                {{ $location->regional }}
                                - {{ $location->site }}
                                - {{ $location->room }}
                            </option>
                        @endforeach
                    </select>

                    @error('location_id')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                    <small class="text-muted">Gunakan menu Pindahkan Aset untuk mengubah lokasi dan mencatat riwayat.</small>
                </div>

                <!-- Merek -->
                <div class="col-md-6">
                    <label for="brand" class="edit-label">
                        Merek <span class="required-mark">*</span>
                    </label>

                    <input type="text"
                           name="brand"
                           id="brand"
                           class="form-control @error('brand') is-invalid @enderror"
                           value="{{ old('brand', $asset->brand) }}"
                           maxlength="100"
                           required>

                    @error('brand')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>

                <!-- Model -->
                <div class="col-md-6">
                    <label for="model" class="edit-label">Model / Tipe</label>

                    <input type="text"
                           name="model"
                           id="model"
                           class="form-control @error('model') is-invalid @enderror"
                           value="{{ old('model', $asset->model) }}"
                           maxlength="100">

                    @error('model')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>

                <!-- Serial Number -->
                <div class="col-md-6">
                    <label for="serial_number" class="edit-label">
                        Serial Number <span class="required-mark">*</span>
                    </label>

                    <input type="text"
                           name="serial_number"
                           id="serial_number"
                           class="form-control @error('serial_number') is-invalid @enderror"
                           value="{{ old('serial_number', $asset->serial_number) }}"
                           maxlength="100"
                           required>

                    @error('serial_number')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>

                <!-- Tanggal Pembelian -->
                <div class="col-md-6">
                    <label for="purchase_date" class="edit-label">
                        Tanggal Pembelian
                    </label>

                    <input type="date"
                           name="purchase_date"
                           id="purchase_date"
                           class="form-control @error('purchase_date') is-invalid @enderror"
                           value="{{ old('purchase_date', $asset->purchase_date ? \Illuminate\Support\Carbon::parse($asset->purchase_date)->format('Y-m-d') : '') }}">

                    @error('purchase_date')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>

                <!-- Tahun Perolehan -->
                <div class="col-md-6">
                    <label for="acquisition_year" class="edit-label">
                        Tahun Perolehan
                    </label>

                    <input type="number"
                           name="acquisition_year"
                           id="acquisition_year"
                           class="form-control @error('acquisition_year') is-invalid @enderror"
                           value="{{ old('acquisition_year', $asset->acquisition_year) }}"
                           min="1900"
                           max="2100">

                    @error('acquisition_year')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>

                <!-- Kondisi -->
                <div class="col-md-6">
                    <label for="condition" class="edit-label">
                        Kondisi <span class="required-mark">*</span>
                    </label>

                    <select name="condition"
                            id="condition"
                            class="form-select @error('condition') is-invalid @enderror"
                            disabled>
                        @foreach (['Baik', 'Rusak Ringan', 'Rusak Berat'] as $condition)
                            <option value="{{ $condition }}"
                                @selected(old('condition', $asset->condition) === $condition)>
                                {{ $condition }}
                            </option>
                        @endforeach
                    </select>

                    @error('condition')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                    <small class="text-muted">Kondisi diperbarui melalui pemeriksaan aset.</small>
                </div>

                <!-- Status -->
                <div class="col-md-6">
                    <label for="status" class="edit-label">
                        Status <span class="required-mark">*</span>
                    </label>

                    <select name="status"
                            id="status"
                            class="form-select @error('status') is-invalid @enderror"
                            disabled>
                        @foreach ([
                            'Aktif',
                            'Dipinjam',
                            'Dipindahkan',
                            'Diperbaiki',
                            'Tidak Aktif',
                            'Dihapus'
                        ] as $status)
                            <option value="{{ $status }}"
                                @selected(old('status', $asset->status) === $status)>
                                {{ $status }}
                            </option>
                        @endforeach
                    </select>

                    @error('status')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                    <small class="text-muted">Status berubah melalui proses pemeriksaan atau perpindahan.</small>
                </div>

                <!-- Deskripsi -->
                <div class="col-12">
                    <label for="description" class="edit-label">
                        Deskripsi / Keterangan
                    </label>

                    <textarea name="description"
                              id="description"
                              class="form-control @error('description') is-invalid @enderror"
                              rows="4">{{ old('description', $asset->description) }}</textarea>

                    @error('description')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>

            </div>

            <div class="edit-actions mt-4">

                <a href="{{ route('assets.show', $asset) }}"
                   class="btn btn-outline-secondary">
                    Batal
                </a>

                <button type="submit" class="btn btn-save">
                    <i class="bi bi-check-circle me-1"></i>
                    Simpan Perubahan
                </button>

            </div>

        </form>

    </div>

</div>

@endsection
