<?php

namespace App\Http\Controllers;

use App\Models\Asset;
use App\Models\Inspection;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class InspectionController extends Controller
{
    /*
    |--------------------------------------------------------------------------
    | Daftar Aset untuk Pemeriksaan
    |--------------------------------------------------------------------------
    */
    public function index()
    {
        $assets = Asset::with(['category', 'location'])
            ->orderBy('asset_code', 'asc')
            ->paginate(10);

        return view('inspections.index', compact('assets'));
    }

    /*
    |--------------------------------------------------------------------------
    | Riwayat Seluruh Pemeriksaan
    |--------------------------------------------------------------------------
    */
    public function history(Request $request)
    {
        $search = trim((string) $request->query('search', ''));

        $inspections = Inspection::with([
                'asset',
                'user',
                'photos',
            ])
            ->when($search !== '', function ($query) use ($search) {
                $query->whereHas('asset', function ($assetQuery) use ($search) {
                    $assetQuery
                        ->where('asset_code', 'like', '%' . $search . '%')
                        ->orWhere('brand', 'like', '%' . $search . '%')
                        ->orWhere('model', 'like', '%' . $search . '%')
                        ->orWhere('serial_number', 'like', '%' . $search . '%');
                });
            })
            ->orderByDesc('inspection_date')
            ->orderByDesc('id')
            ->paginate(10)
            ->withQueryString();

        return view('inspections.history', compact(
            'inspections',
            'search'
        ));
    }

    /*
    |--------------------------------------------------------------------------
    | Detail Satu Pemeriksaan
    |--------------------------------------------------------------------------
    */
    public function show(Inspection $inspection)
    {
        $inspection->load([
            'asset.category',
            'asset.location',
            'user',
            'photos',
        ]);

        return view('inspections.show', compact('inspection'));
    }

    /*
    |--------------------------------------------------------------------------
    | Form Pemeriksaan Aset
    |--------------------------------------------------------------------------
    */
    public function create(Asset $asset)
    {
        $asset->load(['category', 'location']);

        return view('inspections.create', compact('asset'));
    }

    /*
    |--------------------------------------------------------------------------
    | Simpan Hasil Pemeriksaan dan Foto
    |--------------------------------------------------------------------------
    */
    public function store(Request $request, Asset $asset)
    {
        $validated = $request->validate([
            'inspection_date' => ['required', 'date'],
            'condition' => [
                'required',
                'in:Baik,Rusak Ringan,Rusak Berat',
            ],
            'serial_number_checked' => [
                'nullable',
                'string',
                'max:100',
            ],
            'physical_check' => [
                'required',
                'in:Sesuai,Tidak Sesuai',
            ],
            'description' => ['nullable', 'string'],
            'recommendation' => ['nullable', 'string'],
            'photos' => ['nullable', 'array', 'max:5'],
            'photos.*' => [
                'image',
                'mimes:jpg,jpeg,png,webp',
                'max:5120',
            ],
        ]);

        $inspectionData = collect($validated)
            ->except(['photos'])
            ->all();

        $inspectionData['user_id'] = auth()->id();

        DB::transaction(function () use (
            $asset,
            $inspectionData,
            $request
        ) {
            $inspection = $asset->inspections()
                ->create($inspectionData);

            foreach ($request->file('photos', []) as $photo) {
                $path = $photo->store(
                    'inspection-photos',
                    'public'
                );

                $inspection->photos()->create([
                    'file_path' => $path,
                    'description' => null,
                ]);
            }

            $asset->update([
                'condition' => $inspectionData['condition'],
            ]);
        });

        return redirect()
            ->route('assets.show', $asset)
            ->with(
                'success',
                'Hasil pemeriksaan dan foto berhasil disimpan. Kondisi aset telah diperbarui.'
            );
    }
}
