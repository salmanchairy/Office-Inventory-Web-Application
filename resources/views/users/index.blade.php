@extends('layouts.app')

@section('title', 'Kelola User')
@section('page-title', 'Kelola User')

@section('content')
<div class="container-fluid px-0">
    <div class="d-flex flex-wrap justify-content-between align-items-center gap-2 mb-4"><div><h4 class="mb-1">Kelola User</h4><p class="text-muted mb-0">Atur akun pengguna dan perannya.</p></div><button class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#createUser"><i class="bi bi-person-plus me-1"></i>Tambah User</button></div>
    @include('partials.flash')
    <div class="card"><div class="table-responsive"><table class="table table-hover align-middle mb-0"><thead class="table-light"><tr><th>Nama</th><th>Username</th><th>Role</th><th>Status</th><th class="text-end">Aksi</th></tr></thead><tbody>
        @forelse($users as $user)<tr><td><div class="fw-semibold">{{ $user->name }}</div><small class="text-muted">{{ $user->email ?: '-' }}</small></td><td>{{ $user->username }}</td><td><span class="badge text-bg-info">{{ ucfirst($user->role?->name ?? '-') }}</span></td><td><span class="badge text-bg-{{ $user->status === 'aktif' ? 'success' : 'secondary' }}">{{ ucfirst($user->status) }}</span></td><td class="text-end"><button class="btn btn-sm btn-outline-primary" data-bs-toggle="modal" data-bs-target="#editUser{{ $user->id }}"><i class="bi bi-pencil"></i></button><form class="d-inline" method="POST" action="{{ route('users.destroy', $user) }}" onsubmit="return confirm('Hapus akun ini?')">@csrf @method('DELETE')<button class="btn btn-sm btn-outline-danger" {{ $user->is(auth()->user()) ? 'disabled' : '' }}><i class="bi bi-trash"></i></button></form></td></tr>
        <div class="modal fade" id="editUser{{ $user->id }}" tabindex="-1"><div class="modal-dialog"><form method="POST" action="{{ route('users.update', $user) }}" class="modal-content">@csrf @method('PUT')<div class="modal-header"><h5 class="modal-title">Edit User</h5><button type="button" class="btn-close" data-bs-dismiss="modal"></button></div><div class="modal-body">@include('users.fields', ['user' => $user, 'roles' => $roles, 'editing' => true])</div><div class="modal-footer"><button class="btn btn-primary">Simpan</button></div></form></div></div>
        @empty<tr><td colspan="5" class="text-center text-muted py-5">Belum ada pengguna.</td></tr>@endforelse
    </tbody></table></div><div class="p-3">{{ $users->links() }}</div></div>
</div>
<div class="modal fade" id="createUser" tabindex="-1"><div class="modal-dialog"><form method="POST" action="{{ route('users.store') }}" class="modal-content">@csrf<div class="modal-header"><h5 class="modal-title">Tambah User</h5><button type="button" class="btn-close" data-bs-dismiss="modal"></button></div><div class="modal-body">@include('users.fields', ['user' => null, 'roles' => $roles, 'editing' => false])</div><div class="modal-footer"><button class="btn btn-primary">Simpan</button></div></form></div></div>
@endsection
