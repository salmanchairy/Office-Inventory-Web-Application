<?php

namespace App\Http\Controllers;

use App\Models\Role;
use App\Models\User;
use Illuminate\Http\Request;

class UserController extends Controller
{
    private function ensureAdmin(): void
    {
        abort_unless(auth()->user()?->role?->name === 'admin', 403);
    }

    public function index()
    {
        $this->ensureAdmin();
        $users = User::with('role')->orderBy('name')->paginate(10);
        $roles = Role::orderBy('name')->get();

        return view('users.index', compact('users', 'roles'));
    }

    public function store(Request $request)
    {
        $this->ensureAdmin();
        User::create($this->validated($request));
        return back()->with('success', 'Pengguna berhasil ditambahkan.');
    }

    public function update(Request $request, User $user)
    {
        $this->ensureAdmin();
        $data = $this->validated($request, $user);
        $adminRoleId = Role::where('name', 'admin')->value('id');
        if ($user->role_id === $adminRoleId && (($data['role_id'] ?? $adminRoleId) !== $adminRoleId || ($data['status'] ?? 'aktif') !== 'aktif') && User::where('role_id', $adminRoleId)->where('status', 'aktif')->count() <= 1) {
            return back()->with('error', 'Sistem harus memiliki minimal satu Administrator aktif.');
        }
        if (blank($data['password'] ?? null)) {
            unset($data['password']);
        }
        $user->update($data);

        return back()->with('success', 'Data pengguna berhasil diperbarui.');
    }

    public function destroy(User $user)
    {
        $this->ensureAdmin();
        if ($user->is(auth()->user())) {
            return back()->with('error', 'Akun yang sedang digunakan tidak dapat dihapus.');
        }
        if ($user->role?->name === 'admin' && User::where('role_id', $user->role_id)->where('status', 'aktif')->count() <= 1) {
            return back()->with('error', 'Administrator aktif terakhir tidak dapat dihapus.');
        }
        if ($user->inspections()->exists() || $user->movements()->exists()) {
            return back()->with('error', 'Pengguna memiliki riwayat aktivitas dan tidak dapat dihapus. Nonaktifkan akun ini.');
        }

        $user->delete();
        return back()->with('success', 'Pengguna berhasil dihapus.');
    }

    private function validated(Request $request, ?User $user = null): array
    {
        $rules = [
            'role_id' => ['required', 'exists:roles,id'],
            'name' => ['required', 'string', 'max:100'],
            'username' => ['required', 'string', 'max:50', 'unique:users,username' . ($user ? ',' . $user->id : '')],
            'email' => ['nullable', 'email', 'max:100', 'unique:users,email' . ($user ? ',' . $user->id : '')],
            'status' => ['required', 'in:aktif,nonaktif'],
        ];
        $rules['password'] = $user
            ? ['nullable', 'string', 'min:8']
            : ['required', 'string', 'min:8'];

        return $request->validate($rules);
    }
}
