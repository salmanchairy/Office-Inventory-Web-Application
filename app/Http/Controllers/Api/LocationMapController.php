<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Location;
use Illuminate\Http\Request;

class LocationMapController extends Controller
{
    public function index(Request $request)
    {
        $filters = $request->validate([
            'search' => ['nullable', 'string', 'max:100'],
            'condition' => ['nullable', 'in:Baik,Rusak Ringan,Rusak Berat'],
        ]);

        $locations = Location::query()
            ->whereNotNull('latitude')
            ->whereNotNull('longitude')
            ->when($filters['search'] ?? null, function ($query, string $search) {
                $query->where(function ($locationQuery) use ($search) {
                    $locationQuery
                        ->where('regional', 'like', "%{$search}%")
                        ->orWhere('site', 'like', "%{$search}%")
                        ->orWhere('building', 'like', "%{$search}%")
                        ->orWhere('room', 'like', "%{$search}%");
                });
            })
            ->when($filters['condition'] ?? null, function ($query, string $condition) {
                $query->whereHas('assets', fn ($assetQuery) => $assetQuery->where('condition', $condition));
            })
            ->with(['assets:id,location_id,category_id,asset_code,brand,model,serial_number,condition,status', 'assets.category:id,name'])
            ->orderBy('regional')
            ->orderBy('site')
            ->get();

        return response()->json([
            'data' => $locations->map(function (Location $location) {
                $assets = $location->assets;

                return [
                    'id' => $location->id,
                    'name' => $location->site ?: $location->regional,
                    'regional' => $location->regional,
                    'address' => collect([$location->site, $location->building, $location->room])
                        ->filter()
                        ->unique()
                        ->implode(', '),
                    'latitude' => $location->latitude,
                    'longitude' => $location->longitude,
                    'asset_summary' => [
                        'total' => $assets->count(),
                        'baik' => $assets->where('condition', 'Baik')->count(),
                        'rusak_ringan' => $assets->where('condition', 'Rusak Ringan')->count(),
                        'rusak_berat' => $assets->where('condition', 'Rusak Berat')->count(),
                    ],
                    'assets' => $assets->map(fn ($asset) => [
                        'asset_code' => $asset->asset_code,
                        'brand' => $asset->brand,
                        'model' => $asset->model,
                        'serial_number' => $asset->serial_number,
                        'category' => $asset->category?->name,
                        'condition' => $asset->condition,
                        'status' => $asset->status,
                    ])->values(),
                ];
            })->values(),
        ]);
    }
}
