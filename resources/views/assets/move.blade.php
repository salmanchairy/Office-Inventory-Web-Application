@extends('layouts.app')

@section('title', 'Pindahkan Aset')
@section('page-title', 'Pindahkan Aset')

@section('content')
<div class="container-fluid px-0" style="max-width:760px">
    <div class="d-flex justify-content-between align-items-center mb-4"><div><h4 class="mb-1">Pindahkan Aset</h4><p class="text-muted mb-0">Perpindahan akan tercatat sebagai riwayat aset.</p></div><a class="btn btn-outline-secondary" href="{{ route('assets.show', $asset) }}">Kembali</a></div>
    <form method="POST" action="{{ route('assets.move.store', $asset) }}" class="card card-body">@csrf
        <div class="mb-3"><label class="form-label">Aset</label><input class="form-control" value="{{ $asset->asset_code }} - {{ $asset->brand }} {{ $asset->model }}" readonly></div>
        <div class="mb-3"><label class="form-label">Lokasi saat ini</label><input class="form-control" value="{{ collect([$asset->location?->regional, $asset->location?->site, $asset->location?->room])->filter()->implode(' - ') }}" readonly></div>
        <div class="mb-3"><label class="form-label" for="to_location_id">Lokasi tujuan</label><select class="form-select @error('to_location_id') is-invalid @enderror" id="to_location_id" name="to_location_id" required><option value="">Pilih lokasi tujuan</option>@foreach($locations as $location)<option value="{{ $location->id }}" @selected(old('to_location_id') == $location->id)>{{ collect([$location->regional, $location->site, $location->room])->filter()->implode(' - ') }}</option>@endforeach</select>@error('to_location_id')<div class="invalid-feedback">{{ $message }}</div>@enderror</div>
        <div class="mb-3"><label class="form-label" for="movement_date">Tanggal dan waktu perpindahan</label><input class="form-control" id="movement_date" name="movement_date" type="datetime-local" value="{{ old('movement_date', now()->format('Y-m-d\\TH:i')) }}" required></div>
        <div class="mb-4"><label class="form-label" for="reason">Alasan perpindahan</label><textarea class="form-control" id="reason" name="reason" rows="3" required>{{ old('reason') }}</textarea></div>
        <div class="d-flex justify-content-end gap-2"><a class="btn btn-outline-secondary" href="{{ route('assets.show', $asset) }}">Batal</a><button class="btn btn-primary"><i class="bi bi-check-lg me-1"></i>Simpan Perpindahan</button></div>
    </form>
</div>
@endsection
