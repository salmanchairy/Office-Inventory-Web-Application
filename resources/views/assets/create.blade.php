@extends('layouts.app')

@section('title', 'Tambah Asset')
@section('page-title', 'Tambah Asset')

@push('styles')
<style>
    .asset-form-wrap { max-width: 1080px; margin: 0 auto; }
    .asset-form-header { display:flex; align-items:center; justify-content:space-between; gap:1rem; margin-bottom:1.5rem; }
    .asset-form-header h4 { margin:0 0 .25rem; color:#07569B; font-weight:700; }
    .asset-form-header p { margin:0; color:#7A8FA8; }
    .asset-form-card { overflow:visible; }
    .asset-form-card .card-body { padding:2rem; }
    .asset-form-section + .asset-form-section { margin-top:1.8rem; padding-top:1.6rem; border-top:1px solid #EAF0F6; }
    .asset-form-section-title { display:flex; align-items:center; gap:.55rem; margin-bottom:1.15rem; color:#244363; font-size:.93rem; font-weight:700; }
    .asset-form-section-title i { display:grid; width:30px; height:30px; place-items:center; color:#0788D8; border-radius:8px; background:#E8F4FF; }
    .asset-form-card .form-label { margin-bottom:.48rem; color:#35536f; font-size:.84rem; font-weight:600; }
    .asset-form-card .form-control, .asset-form-card .form-select { min-height:44px; }
    .asset-form-card textarea.form-control { min-height:96px; }
    .field-note { margin-top:.35rem; color:#7A8FA8; font-size:.75rem; }
    .asset-form-actions { display:flex; align-items:center; justify-content:space-between; gap:1rem; margin-top:1.5rem; padding:1.1rem 0 0; border-top:1px solid #EAF0F6; }
    .asset-form-hint { display:flex; align-items:center; gap:.55rem; color:#7186A0; font-size:.79rem; }
    .asset-form-hint i { color:#d29a00; }
    @media (max-width: 576px) { .asset-form-header { align-items:flex-start; flex-direction:column; }.asset-form-card .card-body { padding:1.25rem; }.asset-form-actions { align-items:stretch; flex-direction:column; }.asset-form-actions .btn { width:100%; }.asset-form-hint { order:2; } }
</style>
@endpush

@section('content')
<div class="container-fluid px-0">
    <div class="asset-form-wrap">
        <div class="asset-form-header">
            <div>
                <h4>Tambah Asset</h4>
                <p>Masukkan informasi perangkat untuk menambah inventaris baru.</p>
            </div>
            <a href="{{ route('assets.index') }}" class="btn btn-outline-secondary"><i class="bi bi-arrow-left me-1"></i>Kembali</a>
        </div>

        @if ($errors->any())
            <div class="alert alert-danger"><div class="fw-semibold mb-1"><i class="bi bi-exclamation-circle me-1"></i>Data belum dapat disimpan</div><ul class="mb-0 small">@foreach ($errors->all() as $error)<li>{{ $error }}</li>@endforeach</ul></div>
        @endif

        <form action="{{ route('assets.store') }}" method="POST">
            @csrf
            <div class="card asset-form-card">
                <div class="card-body">
                    <div class="asset-form-section mt-0 pt-0 border-0">
                        <div class="asset-form-section-title"><i class="bi bi-box-seam"></i>Informasi perangkat</div>
                        <div class="row g-3">
                            <div class="col-md-6"><label class="form-label">Kategori <span class="text-danger">*</span></label><select name="category_id" class="form-select" required><option value="">Pilih kategori</option>@foreach($categories as $category)<option value="{{ $category->id }}" @selected(old('category_id') == $category->id)>{{ $category->name }}</option>@endforeach</select></div>
                            <div class="col-md-6"><label class="form-label">Lokasi <span class="text-danger">*</span></label><select name="location_id" class="form-select" required><option value="">Pilih lokasi</option>@foreach($locations as $location)<option value="{{ $location->id }}" @selected(old('location_id') == $location->id)>{{ collect([$location->regional, $location->site, $location->room])->filter()->join(' — ') }}</option>@endforeach</select></div>
                            <div class="col-md-6"><label class="form-label">Brand / Merek <span class="text-danger">*</span></label><input type="text" name="brand" class="form-control" placeholder="Contoh: HP atau Lenovo" value="{{ old('brand') }}" required></div>
                            <div class="col-md-6"><label class="form-label">Model</label><input type="text" name="model" class="form-control" placeholder="Contoh: ThinkPad E14" value="{{ old('model') }}"></div>
                            <div class="col-md-6"><label class="form-label">Serial Number <span class="text-danger">*</span></label><input type="text" name="serial_number" class="form-control" placeholder="Masukkan serial number" value="{{ old('serial_number') }}" required><div class="field-note">Serial number harus unik.</div></div>
                            <div class="col-md-3"><label class="form-label">Tahun perolehan</label><input type="number" name="acquisition_year" class="form-control" min="1900" max="2100" placeholder="2025" value="{{ old('acquisition_year') }}"></div>
                            <div class="col-md-3"><label class="form-label">Tanggal pembelian</label><input type="date" name="purchase_date" class="form-control" value="{{ old('purchase_date') }}"></div>
                        </div>
                    </div>

                    <div class="asset-form-section">
                        <div class="asset-form-section-title"><i class="bi bi-clipboard-check"></i>Kondisi & status</div>
                        <div class="row g-3">
                            <div class="col-md-6"><label class="form-label">Kondisi <span class="text-danger">*</span></label><select name="condition" class="form-select" required><option value="">Pilih kondisi</option>@foreach(['Baik', 'Rusak Ringan', 'Rusak Berat'] as $condition)<option value="{{ $condition }}" @selected(old('condition') === $condition)>{{ $condition }}</option>@endforeach</select></div>
                            <div class="col-md-6"><label class="form-label">Status <span class="text-danger">*</span></label><select name="status" class="form-select" required><option value="">Pilih status</option>@foreach(['Aktif', 'Dipinjam', 'Dipindahkan', 'Diperbaiki', 'Tidak Aktif', 'Dihapus'] as $status)<option value="{{ $status }}" @selected(old('status') === $status)>{{ $status }}</option>@endforeach</select></div>
                        </div>
                    </div>

                    <div class="asset-form-section">
                        <div class="asset-form-section-title"><i class="bi bi-card-text"></i>Keterangan <span class="text-muted fw-normal small">(opsional)</span></div>
                        <textarea name="description" class="form-control" placeholder="Tambahkan catatan jika diperlukan…">{{ old('description') }}</textarea>
                    </div>

                    <div class="asset-form-actions">
                        <div class="asset-form-hint"><i class="bi bi-lightbulb"></i><span>ID inventaris dibuat otomatis setelah data disimpan.</span></div>
                        <div class="d-flex gap-2"><a href="{{ route('assets.index') }}" class="btn btn-outline-secondary">Batal</a><button type="submit" class="btn btn-warning px-4"><i class="bi bi-save me-1"></i>Simpan Asset</button></div>
                    </div>
                </div>
            </div>
        </form>
    </div>
</div>
@endsection
