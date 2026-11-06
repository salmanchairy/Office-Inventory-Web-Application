@extends('layouts.app')

@section('title', 'Kategori Aset')
@section('page-title', 'Kategori Aset')

@section('content')
<div class="container-fluid px-0">
    <div class="d-flex flex-wrap justify-content-between align-items-center gap-2 mb-4">
        <div><h4 class="mb-1">Kategori Aset</h4><p class="text-muted mb-0">Kelola pengelompokan inventaris.</p></div>
        <button class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#createCategory"><i class="bi bi-plus-lg me-1"></i>Tambah Kategori</button>
    </div>
    @include('partials.flash')
    <div class="card"><div class="table-responsive"><table class="table table-hover align-middle mb-0">
        <thead class="table-light"><tr><th>Nama</th><th>Deskripsi</th><th>Jumlah Aset</th><th class="text-end">Aksi</th></tr></thead>
        <tbody>@forelse($categories as $category)<tr>
            <td class="fw-semibold">{{ $category->name }}</td><td>{{ $category->description ?: '-' }}</td><td><span class="badge text-bg-primary">{{ $category->assets_count }} aset</span></td>
            <td class="text-end"><button class="btn btn-sm btn-outline-primary" data-bs-toggle="modal" data-bs-target="#editCategory{{ $category->id }}"><i class="bi bi-pencil"></i></button>
                <form class="d-inline" method="POST" action="{{ route('categories.destroy', $category) }}" onsubmit="return confirm('Hapus kategori ini?')">@csrf @method('DELETE')<button class="btn btn-sm btn-outline-danger" {{ $category->assets_count ? 'disabled' : '' }}><i class="bi bi-trash"></i></button></form></td>
        </tr>
        <div class="modal fade" id="editCategory{{ $category->id }}" tabindex="-1"><div class="modal-dialog"><form method="POST" action="{{ route('categories.update', $category) }}" class="modal-content">@csrf @method('PUT')
            <div class="modal-header"><h5 class="modal-title">Edit Kategori</h5><button type="button" class="btn-close" data-bs-dismiss="modal"></button></div>
            <div class="modal-body"><label class="form-label">Nama</label><input name="name" class="form-control mb-3" value="{{ $category->name }}" required><label class="form-label">Deskripsi</label><textarea name="description" class="form-control" rows="3">{{ $category->description }}</textarea></div>
            <div class="modal-footer"><button class="btn btn-primary">Simpan</button></div></form></div></div>
        @empty<tr><td colspan="4" class="text-center text-muted py-5">Belum ada kategori aset.</td></tr>@endforelse</tbody>
    </table></div><div class="p-3">{{ $categories->links() }}</div></div>
</div>
<div class="modal fade" id="createCategory" tabindex="-1"><div class="modal-dialog"><form method="POST" action="{{ route('categories.store') }}" class="modal-content">@csrf
    <div class="modal-header"><h5 class="modal-title">Tambah Kategori</h5><button type="button" class="btn-close" data-bs-dismiss="modal"></button></div>
    <div class="modal-body"><label class="form-label">Nama <span class="text-danger">*</span></label><input name="name" class="form-control mb-3" required><label class="form-label">Deskripsi</label><textarea name="description" class="form-control" rows="3"></textarea></div>
    <div class="modal-footer"><button class="btn btn-primary">Simpan</button></div></form></div></div>
@endsection
