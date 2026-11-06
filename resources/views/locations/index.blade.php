@extends('layouts.app')

@section('title', 'Lokasi Aset')
@section('page-title', 'Lokasi Aset')

@push('styles')
<style>
    .location-page-header { display:flex; align-items:flex-end; justify-content:space-between; gap:1rem; margin-bottom:1.25rem; }
    .location-page-header h4 { margin:0 0 .3rem; color:#173B63; font-size:1.45rem; font-weight:750; letter-spacing:-.02em; }
    .location-page-header p { margin:0; color:#71849A; font-size:.9rem; }
    .location-page-tabs { display:inline-flex; gap:.3rem; padding:.3rem; margin-bottom:1.25rem; border:1px solid #E1EAF4; border-radius:11px; background:#fff; box-shadow:0 4px 14px rgba(31,82,130,.04); }
    .location-page-tabs a { padding:.52rem .78rem; border-radius:8px; color:#6D8299; font-size:.82rem; font-weight:700; text-decoration:none; }
    .location-page-tabs a.active, .location-page-tabs a:hover { color:#07569B; background:#EAF5FF; }
    .location-table-card { overflow:hidden; border:1px solid #E1EAF4; border-radius:14px; box-shadow:0 7px 20px rgba(31,82,130,.045); }
    .location-table-card .table { min-width:720px; }
    .location-table-card thead th { padding:14px 18px; border-bottom:1px solid #E1EAF4; background:#F5F9FD; color:#668099; font-size:.72rem; font-weight:750; letter-spacing:.045em; text-transform:uppercase; }
    .location-table-card tbody td { padding:15px 18px; border-color:#EDF2F7; color:#466079; font-size:.86rem; }
    .location-table-card tbody tr:hover { background:#FAFCFE; }
    .location-name { color:#244363; font-weight:750; }
    .location-subtext { margin-top:.2rem; color:#7A8FA8; font-size:.78rem; }
    .location-coordinate { color:#607c98; font-family:ui-monospace, SFMono-Regular, Menlo, monospace; font-size:.76rem; }
    .location-coordinate-empty { color:#9aaabd; font-size:.78rem; }
    .location-table-actions { display:flex; justify-content:flex-end; gap:.4rem; }
    .location-table-actions .btn { width:34px; height:34px; padding:0; display:inline-grid; place-items:center; border-radius:9px; }
    .location-asset-count { min-width:30px; padding:.42rem .52rem; border-radius:8px; background:#EAF5FF; color:#0873BE; font-size:.75rem; font-weight:750; }
    .location-modal .modal-content { border:0; border-radius:16px; overflow:hidden; }
    .location-modal .modal-header { align-items:flex-start; padding:1.3rem 1.45rem 1.1rem; border-bottom:1px solid #EAF0F6; }
    .location-modal .modal-title { color:#244363; font-weight:700; }
    .location-modal .modal-body { padding:1.35rem 1.45rem; }
    .location-modal .modal-footer { padding:1rem 1.45rem; border-top:1px solid #EAF0F6; }
    .location-modal .form-label { margin-bottom:.4rem; color:#35536f; font-size:.82rem; font-weight:600; }
    .location-modal .form-control { min-height:42px; }
    .location-form-label { color:#07569B; font-size:.78rem; font-weight:700; letter-spacing:.02em; }
    .location-form-label span { color:#8aa0b6; font-size:.72rem; font-weight:500; }
    @media (max-width: 576px) { .location-page-header { align-items:flex-start; flex-direction:column; }.location-page-header .btn { width:100%; }.location-page-tabs { display:flex; width:100%; }.location-page-tabs a { flex:1; text-align:center; }.location-modal .modal-body { padding:1.1rem; }.location-modal .modal-header, .location-modal .modal-footer { padding-left:1.1rem; padding-right:1.1rem; } }
</style>
@endpush

@section('content')
<div class="container-fluid px-0">
    <div class="location-page-header">
        <div><h4>Lokasi & Peta Aset</h4><p>Kelola lokasi fisik dan koordinat persebaran aset dari satu area.</p></div>
        <button type="button" class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#tambahLokasiModal"><i class="bi bi-plus-lg me-1"></i>Tambah Lokasi</button>
    </div>

    <nav class="location-page-tabs" aria-label="Navigasi lokasi">
        <a href="{{ route('locations.index') }}" class="active"><i class="bi bi-list-ul me-1"></i>Daftar Lokasi</a>
        <a href="{{ route('maps.index') }}"><i class="bi bi-map me-1"></i>Peta Persebaran</a>
    </nav>

    @include('partials.flash')

    <div class="card location-table-card">
        <div class="table-responsive">
            <table class="table table-hover align-middle mb-0">
                <thead><tr><th>Lokasi</th><th>Gedung / ruang</th><th>Koordinat</th><th class="text-center">Aset</th><th class="text-end">Aksi</th></tr></thead>
                <tbody>
                    @forelse($locations as $location)
                        <tr>
                            <td><div class="location-name">{{ $location->site ?: $location->regional }}</div><div class="location-subtext">{{ $location->regional }}</div></td>
                            <td>{{ collect([$location->building, $location->room])->filter()->join(' / ') ?: '-' }}</td>
                            <td>@if($location->latitude !== null && $location->longitude !== null)<span class="location-coordinate">{{ $location->latitude }}, {{ $location->longitude }}</span>@else<span class="location-coordinate-empty"><i class="bi bi-exclamation-circle me-1"></i>Belum terpetakan</span>@endif</td>
                            <td class="text-center"><span class="location-asset-count">{{ $location->assets_count }}</span></td>
                            <td><div class="location-table-actions"><button type="button" class="btn btn-outline-primary" title="Edit lokasi" data-bs-toggle="modal" data-bs-target="#editLokasi{{ $location->id }}"><i class="bi bi-pencil"></i></button><form method="POST" action="{{ route('locations.destroy', $location) }}" onsubmit="return confirm('Hapus lokasi ini?')">@csrf @method('DELETE')<button class="btn btn-outline-danger" title="Hapus lokasi" {{ $location->assets_count ? 'disabled' : '' }}><i class="bi bi-trash"></i></button></form></div></td>
                        </tr>
                    @empty
                        <tr><td colspan="5" class="text-center text-muted py-5"><i class="bi bi-geo-alt d-block fs-2 mb-2"></i>Belum ada lokasi aset.</td></tr>
                    @endforelse
                </tbody>
            </table>
        </div>
        @if($locations->hasPages())<div class="p-3">{{ $locations->links() }}</div>@endif
    </div>
</div>

<div class="modal fade location-modal" id="tambahLokasiModal" tabindex="-1" aria-labelledby="tambahLokasiModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg modal-dialog-centered"><form method="POST" action="{{ route('locations.store') }}" class="modal-content">@csrf
        <div class="modal-header"><div><h5 class="modal-title" id="tambahLokasiModalLabel">Tambah Lokasi</h5><small class="text-muted">Masukkan kantor cabang atau wilayah kerja.</small></div><button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Tutup"></button></div>
        <div class="modal-body"><div class="row g-3">@include('locations.fields', ['location' => null])</div></div>
        <div class="modal-footer"><button type="button" class="btn btn-outline-secondary" data-bs-dismiss="modal">Batal</button><button class="btn btn-primary px-3"><i class="bi bi-check-lg me-1"></i>Simpan Lokasi</button></div>
    </form></div>
</div>

@foreach($locations as $location)
<div class="modal fade location-modal" id="editLokasi{{ $location->id }}" tabindex="-1" aria-labelledby="editLokasiModalLabel{{ $location->id }}" aria-hidden="true">
    <div class="modal-dialog modal-lg modal-dialog-centered"><form method="POST" action="{{ route('locations.update', $location) }}" class="modal-content">@csrf @method('PUT')
        <div class="modal-header"><div><h5 class="modal-title" id="editLokasiModalLabel{{ $location->id }}">Edit Lokasi</h5><small class="text-muted">Perbarui detail dan koordinat lokasi.</small></div><button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Tutup"></button></div>
        <div class="modal-body"><div class="row g-3">@include('locations.fields', ['location' => $location])</div></div>
        <div class="modal-footer"><button type="button" class="btn btn-outline-secondary" data-bs-dismiss="modal">Batal</button><button class="btn btn-primary px-3"><i class="bi bi-check-lg me-1"></i>Simpan Perubahan</button></div>
    </form></div>
</div>
@endforeach
@endsection
