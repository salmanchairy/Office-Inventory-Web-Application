<?php

namespace App\Http\Controllers;

use App\Models\Category;
use Illuminate\Http\Request;

class CategoryController extends Controller
{
    private function ensureAdmin(): void
    {
        abort_unless(auth()->user()?->role?->name === 'admin', 403);
    }

    public function index()
    {
        $this->ensureAdmin();
        $categories = Category::withCount('assets')->orderBy('name')->paginate(10);

        return view('categories.index', compact('categories'));
    }

    public function store(Request $request)
    {
        $this->ensureAdmin();
        Category::create($request->validate([
            'name' => ['required', 'string', 'max:100', 'unique:categories,name'],
            'description' => ['nullable', 'string'],
        ]));

        return back()->with('success', 'Kategori aset berhasil ditambahkan.');
    }

    public function update(Request $request, Category $category)
    {
        $this->ensureAdmin();
        $category->update($request->validate([
            'name' => ['required', 'string', 'max:100', 'unique:categories,name,' . $category->id],
            'description' => ['nullable', 'string'],
        ]));

        return back()->with('success', 'Kategori aset berhasil diperbarui.');
    }

    public function destroy(Category $category)
    {
        $this->ensureAdmin();
        if ($category->assets()->exists()) {
            return back()->with('error', 'Kategori tidak dapat dihapus karena masih dipakai oleh aset.');
        }

        $category->delete();
        return back()->with('success', 'Kategori aset berhasil dihapus.');
    }
}
