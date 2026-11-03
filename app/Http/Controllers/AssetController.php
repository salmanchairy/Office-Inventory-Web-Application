<?php

namespace App\Http\Controllers;

use App\Models\Asset;
use App\Models\Category;
use App\Models\Location;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Storage;

class AssetController extends Controller
{
    /**
     * Menampilkan semua asset
     */
    public function index()
    {
        $assets = Asset::with([
            'category',
            'location'
        ])
        ->latest()
        ->paginate(10);

        return view('assets.index', compact('assets'));
    }

    /**
     * Form tambah asset
     */
    public function create()
    {
        $categories = Category::orderBy('name')->get();

        $locations = Location::orderBy('regional')
            ->orderBy('site')
            ->get();

        return view('assets.create', compact(
            'categories',
            'locations'
        ));
    }

    /**
     * Menyimpan asset baru
     */
    public function store(Request $request)
    {
        $validated = $request->validate([
            'category_id' => ['required', 'exists:categories,id'],
            'location_id' => ['required', 'exists:locations,id'],
            'brand' => ['required', 'string', 'max:100'],
            'model' => ['nullable', 'string', 'max:100'],
            'serial_number' => ['required', 'string', 'max:100', 'unique:assets,serial_number'],
            'purchase_date' => ['nullable', 'date'],
            'acquisition_year' => ['nullable', 'integer', 'min:1900', 'max:2100'],
            'condition' => ['required', 'in:Baik,Rusak Ringan,Rusak Berat'],
            'status' => ['required', 'in:Aktif,Dipinjam,Dipindahkan,Diperbaiki,Tidak Aktif,Dihapus'],
            'description' => ['nullable', 'string'],
        ]);

        /*
        |--------------------------------------------------------------------------
        | Buat asset sementara
        |--------------------------------------------------------------------------
        */

        $validated['asset_code'] = 'TEMP-' . uniqid();

        $validated['created_by'] = auth()->id();

        $asset = Asset::create($validated);

        /*
        |--------------------------------------------------------------------------
        | Generate nomor inventaris
        |--------------------------------------------------------------------------
        */

        $asset->update([
            'asset_code' => 'INV-R1-' . str_pad(
                $asset->id,
                5,
                '0',
                STR_PAD_LEFT
            ),
        ]);

        return redirect()
            ->route('assets.index')
            ->with('success', 'Data asset berhasil ditambahkan.');
    }

    /**
     * Menampilkan detail asset
     */
    public function show(Asset $asset)
    {
        $asset->load([
            'category',
            'location',
            'creator',
            'inspections.user',
            'movements.fromLocation',
            'movements.toLocation',
        ]);

        return view('assets.show', compact('asset'));
    }

    /**
     * Form edit asset
     */
    public function edit(Asset $asset)
    {
        $categories = Category::orderBy('name')->get();

        $locations = Location::orderBy('regional')
            ->orderBy('site')
            ->get();

        return view('assets.edit', compact(
            'asset',
            'categories',
            'locations'
        ));
    }

    /**
     * Update asset
     */
    public function update(Request $request, Asset $asset)
    {
        $validated = $request->validate([
            'category_id' => ['required', 'exists:categories,id'],
            'location_id' => ['required', 'exists:locations,id'],
            'brand' => ['required', 'string', 'max:100'],
            'model' => ['nullable', 'string', 'max:100'],
            'serial_number' => [
                'required',
                'string',
                'max:100',
                'unique:assets,serial_number,' . $asset->id,
            ],
            'purchase_date' => ['nullable', 'date'],
            'acquisition_year' => ['nullable', 'integer', 'min:1900', 'max:2100'],
            'condition' => ['required', 'in:Baik,Rusak Ringan,Rusak Berat'],
            'status' => ['required', 'in:Aktif,Dipinjam,Dipindahkan,Diperbaiki,Tidak Aktif,Dihapus'],
            'description' => ['nullable', 'string'],
        ]);

        $asset->update($validated);

        return redirect()
            ->route('assets.index')
            ->with('success', 'Data asset berhasil diperbarui.');
    }

    /**
     * Hapus asset
     */
    
    /**
     * Menghapus aset secara permanen beserta data terkait.
     */
    public function destroy(Asset $asset)
    {
        // Hanya Administrator yang boleh menghapus aset.
        if (
            !auth()->user()?->role ||
            auth()->user()->role->name !== 'admin'
        ) {
            abort(403, 'Hanya Administrator yang dapat menghapus aset.');
        }

        // Kumpulkan seluruh path foto sebelum data dihapus.
        $asset->load('inspections.photos');

        $photoPaths = $asset->inspections
            ->flatMap(function ($inspection) {
                return $inspection->photos->pluck('file_path');
            })
            ->filter()
            ->unique()
            ->values()
            ->all();

        // Sertakan foto utama aset jika tersedia.
        if (!empty($asset->photo)) {
            $photoPaths[] = $asset->photo;
        }

        $photoPaths = array_values(array_unique($photoPaths));

        // Pastikan setiap file berada pada lokasi yang diizinkan.
        foreach ($photoPaths as $path) {
            if (
                !is_string($path) ||
                str_contains($path, '..') ||
                str_starts_with($path, '/') ||
                str_contains($path, '\\')
            ) {
                return redirect()
                    ->route('assets.index')
                    ->with(
                        'error',
                        'Penghapusan dibatalkan karena ditemukan path foto yang tidak valid.'
                    );
            }
        }

        try {
            // Hapus data aset di database secara permanen.
            // Relasi CASCADE akan menghapus pemeriksaan,
            // foto pemeriksaan, dan riwayat perpindahan.
            DB::transaction(function () use ($asset) {
                $asset->delete();
            });
        } catch (\Throwable $e) {
            report($e);

            return redirect()
                ->route('assets.index')
                ->with(
                    'error',
                    'Gagal menghapus aset. Data database tidak diubah.'
                );
        }

        // Setelah database berhasil dihapus, bersihkan file fisik.
        $failedFiles = [];

        foreach ($photoPaths as $path) {
            try {
                if (Storage::disk('public')->exists($path)) {
                    if (!Storage::disk('public')->delete($path)) {
                        $failedFiles[] = $path;
                    }
                }
            } catch (\Throwable $e) {
                report($e);
                $failedFiles[] = $path;
            }
        }

        if (!empty($failedFiles)) {
            report(new \RuntimeException(
                'Aset ' . $asset->asset_code .
                ' telah dihapus dari database, tetapi file berikut gagal dihapus: ' .
                implode(', ', $failedFiles)
            ));

            return redirect()
                ->route('assets.index')
                ->with(
                    'warning',
                    'Aset berhasil dihapus permanen dari database, tetapi sebagian file foto gagal dibersihkan. Periksa log Laravel.'
                );
        }

        return redirect()
            ->route('assets.index')
            ->with(
                'success',
                'Aset ' . $asset->asset_code .
                ' beserta riwayat terkait berhasil dihapus secara permanen.'
            );
    }
}