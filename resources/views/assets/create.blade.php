@extends('layouts.app')

@section('title', 'Tambah Asset')

@section('page-title', 'Tambah Asset')

@section('content')

<div class="container-fluid px-0">

    {{-- Header --}}
    <div class="d-flex justify-content-between align-items-center mb-4">

        <div>
            <h4 class="mb-1">
                Tambah Asset
            </h4>

            <p class="text-muted mb-0">
                Tambahkan data perangkat baru ke inventaris
            </p>
        </div>

        <a
            href="{{ route('assets.index') }}"
            class="btn btn-outline-secondary"
        >
            <i class="bi bi-arrow-left me-1"></i>
            Kembali
        </a>

    </div>


    {{-- Error Validasi --}}
    @if ($errors->any())

        <div class="alert alert-danger">

            <div class="fw-semibold mb-2">

                <i class="bi bi-exclamation-triangle me-2"></i>

                Terdapat kesalahan pada data:

            </div>

            <ul class="mb-0">

                @foreach ($errors->all() as $error)

                    <li>{{ $error }}</li>

                @endforeach

            </ul>

        </div>

    @endif


    <form
        action="{{ route('assets.store') }}"
        method="POST"
    >

        @csrf


        <div class="row g-4">

            {{-- DATA UTAMA --}}
            <div class="col-lg-8">

                <div class="card border-0 shadow-sm">

                    <div class="card-header bg-white py-3">

                        <h6 class="mb-0 fw-semibold">

                            <i class="bi bi-box-seam me-2"></i>

                            Informasi Asset

                        </h6>

                    </div>


                    <div class="card-body">

                        <div class="row g-3">

                            {{-- Kategori --}}
                            <div class="col-md-6">

                                <label class="form-label">
                                    Kategori <span class="text-danger">*</span>
                                </label>

                                <select
                                    name="category_id"
                                    class="form-select"
                                    required
                                >

                                    <option value="">
                                        -- Pilih Kategori --
                                    </option>

                                    @foreach($categories as $category)

                                        <option
                                            value="{{ $category->id }}"
                                            {{ old('category_id') == $category->id ? 'selected' : '' }}
                                        >

                                            {{ $category->name }}

                                        </option>

                                    @endforeach

                                </select>

                            </div>


                            {{-- Lokasi --}}
                            <div class="col-md-6">

                                <label class="form-label">
                                    Lokasi <span class="text-danger">*</span>
                                </label>

                                <select
                                    name="location_id"
                                    class="form-select"
                                    required
                                >

                                    <option value="">
                                        -- Pilih Lokasi --
                                    </option>

                                    @foreach($locations as $location)

                                        <option
                                            value="{{ $location->id }}"
                                            {{ old('location_id') == $location->id ? 'selected' : '' }}
                                        >

                                            {{ $location->regional }}
                                            -
                                            {{ $location->site }}
                                            -
                                            {{ $location->room }}

                                        </option>

                                    @endforeach

                                </select>

                            </div>


                            {{-- Brand --}}
                            <div class="col-md-6">

                                <label class="form-label">
                                    Brand / Merek <span class="text-danger">*</span>
                                </label>

                                <input
                                    type="text"
                                    name="brand"
                                    class="form-control"
                                    placeholder="Contoh: HP, ACER, LENOVO"
                                    value="{{ old('brand') }}"
                                    required
                                >

                            </div>


                            {{-- Model --}}
                            <div class="col-md-6">

                                <label class="form-label">
                                    Model
                                </label>

                                <input
                                    type="text"
                                    name="model"
                                    class="form-control"
                                    placeholder="Contoh: LBP 3050, M4 SERIES"
                                    value="{{ old('model') }}"
                                >

                            </div>


                            {{-- Serial Number --}}
                            <div class="col-md-6">

                                <label class="form-label">
                                    Serial Number <span class="text-danger">*</span>
                                </label>

                                <input
                                    type="text"
                                    name="serial_number"
                                    class="form-control"
                                    placeholder="Masukkan serial number"
                                    value="{{ old('serial_number') }}"
                                    required
                                >

                                <small class="text-muted">
                                    Serial number harus unik.
                                </small>

                            </div>


                            {{-- Tahun Perolehan --}}
                            <div class="col-md-3">

                                <label class="form-label">
                                    Tahun Perolehan
                                </label>

                                <input
                                    type="number"
                                    name="acquisition_year"
                                    class="form-control"
                                    placeholder="2025"
                                    min="1900"
                                    max="2100"
                                    value="{{ old('acquisition_year') }}"
                                >

                            </div>


                            {{-- Tanggal Pembelian --}}
                            <div class="col-md-3">

                                <label class="form-label">
                                    Tanggal Pembelian
                                </label>

                                <input
                                    type="date"
                                    name="purchase_date"
                                    class="form-control"
                                    value="{{ old('purchase_date') }}"
                                >

                            </div>


                            {{-- Kondisi --}}
                            <div class="col-md-6">

                                <label class="form-label">
                                    Kondisi <span class="text-danger">*</span>
                                </label>

                                <select
                                    name="condition"
                                    class="form-select"
                                    required
                                >

                                    <option value="">
                                        -- Pilih Kondisi --
                                    </option>

                                    <option
                                        value="Baik"
                                        {{ old('condition') === 'Baik' ? 'selected' : '' }}
                                    >
                                        Baik
                                    </option>

                                    <option
                                        value="Rusak Ringan"
                                        {{ old('condition') === 'Rusak Ringan' ? 'selected' : '' }}
                                    >
                                        Rusak Ringan
                                    </option>

                                    <option
                                        value="Rusak Berat"
                                        {{ old('condition') === 'Rusak Berat' ? 'selected' : '' }}
                                    >
                                        Rusak Berat
                                    </option>

                                </select>

                            </div>


                            {{-- Status --}}
                            <div class="col-md-6">

                                <label class="form-label">
                                    Status <span class="text-danger">*</span>
                                </label>

                                <select
                                    name="status"
                                    class="form-select"
                                    required
                                >

                                    <option value="">
                                        -- Pilih Status --
                                    </option>

                                    <option
                                        value="Aktif"
                                        {{ old('status') === 'Aktif' ? 'selected' : '' }}
                                    >
                                        Aktif
                                    </option>

                                    <option
                                        value="Dipinjam"
                                        {{ old('status') === 'Dipinjam' ? 'selected' : '' }}
                                    >
                                        Dipinjam
                                    </option>

                                    <option
                                        value="Dipindahkan"
                                        {{ old('status') === 'Dipindahkan' ? 'selected' : '' }}
                                    >
                                        Dipindahkan
                                    </option>

                                    <option
                                        value="Diperbaiki"
                                        {{ old('status') === 'Diperbaiki' ? 'selected' : '' }}
                                    >
                                        Diperbaiki
                                    </option>

                                    <option
                                        value="Tidak Aktif"
                                        {{ old('status') === 'Tidak Aktif' ? 'selected' : '' }}
                                    >
                                        Tidak Aktif
                                    </option>

                                    <option
                                        value="Dihapus"
                                        {{ old('status') === 'Dihapus' ? 'selected' : '' }}
                                    >
                                        Dihapus
                                    </option>

                                </select>

                            </div>


                            {{-- Deskripsi --}}
                            <div class="col-12">

                                <label class="form-label">
                                    Deskripsi / Keterangan
                                </label>

                                <textarea
                                    name="description"
                                    class="form-control"
                                    rows="4"
                                    placeholder="Masukkan keterangan tambahan jika diperlukan..."
                                >{{ old('description') }}</textarea>

                            </div>

                        </div>

                    </div>

                </div>

            </div>


            {{-- INFORMASI SISTEM --}}
            <div class="col-lg-4">

                <div class="card border-0 shadow-sm">

                    <div class="card-header bg-white py-3">

                        <h6 class="mb-0 fw-semibold">

                            <i class="bi bi-info-circle me-2"></i>

                            Informasi Sistem

                        </h6>

                    </div>


                    <div class="card-body">

                        <div class="alert alert-light border">

                            <div class="d-flex">

                                <i class="bi bi-qr-code fs-3 me-3"></i>

                                <div>

                                    <div class="fw-semibold">
                                        ID Inventaris
                                    </div>

                                    <small class="text-muted">

                                        ID inventaris akan dibuat
                                        otomatis oleh sistem setelah
                                        data disimpan.

                                    </small>

                                </div>

                            </div>

                        </div>


                        <div class="alert alert-light border">

                            <div class="d-flex">

                                <i class="bi bi-person-check fs-3 me-3"></i>

                                <div>

                                    <div class="fw-semibold">
                                        Dibuat Oleh
                                    </div>

                                    <small class="text-muted">

                                        {{ auth()->user()->name }}

                                    </small>

                                </div>

                            </div>

                        </div>


                        <div class="alert alert-warning">

                            <i class="bi bi-lightbulb me-2"></i>

                            <small>

                                Pastikan serial number sesuai dengan
                                perangkat fisik sebelum menyimpan.

                            </small>

                        </div>

                    </div>

                </div>


                {{-- Tombol --}}
                <div class="card border-0 shadow-sm mt-4">

                    <div class="card-body">

                        <button
                            type="submit"
                            class="btn btn-warning w-100 mb-2"
                        >

                            <i class="bi bi-save me-1"></i>

                            Simpan Asset

                        </button>


                        <a
                            href="{{ route('assets.index') }}"
                            class="btn btn-outline-secondary w-100"
                        >

                            Batal

                        </a>

                    </div>

                </div>

            </div>

        </div>

    </form>

</div>

@endsection