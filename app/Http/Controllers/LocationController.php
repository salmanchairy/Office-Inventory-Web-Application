<?php

namespace App\Http\Controllers;

use App\Models\Location;
use Illuminate\Http\Request;

class LocationController extends Controller
{
    private function ensureAdmin(): void
    {
        abort_unless(auth()->user()?->role?->name === 'admin', 403);
    }

    public function index()
    {
        $this->ensureAdmin();
        $locations = Location::withCount('assets')->orderBy('regional')->orderBy('site')->paginate(10);

        return view('locations.index', compact('locations'));
    }

    public function store(Request $request)
    {
        $this->ensureAdmin();
        Location::create($this->validated($request));
        return back()->with('success', 'Lokasi berhasil ditambahkan.');
    }

    public function update(Request $request, Location $location)
    {
        $this->ensureAdmin();
        $location->update($this->validated($request));
        return back()->with('success', 'Lokasi berhasil diperbarui.');
    }

    public function destroy(Location $location)
    {
        $this->ensureAdmin();
        if ($location->assets()->exists()) {
            return back()->with('error', 'Lokasi tidak dapat dihapus karena masih dipakai oleh aset.');
        }

        $location->delete();
        return back()->with('success', 'Lokasi berhasil dihapus.');
    }

    /**
     * Endpoint API untuk Peta Persebaran (Leaflet Map)
     */
    public function apiLocations(Request $request)
    {
        $this->ensureAdmin();
        $query = Location::with(['assets.category']);

        // Filter pencarian (regional, site, building, atau room)
        if ($request->filled('search')) {
            $search = $request->search;
            $query->where(function ($q) use ($search) {
                $q->where('regional', 'like', "%{$search}%")
                  ->orWhere('site', 'like', "%{$search}%")
                  ->orWhere('building', 'like', "%{$search}%")
                  ->orWhere('room', 'like', "%{$search}%");
            });
        }

        // Filter berdasarkan kondisi aset
        if ($request->filled('condition')) {
            $condition = $request->condition;
            $query->whereHas('assets', function ($q) use ($condition) {
                $q->where('condition', $condition);
            });
        }

        $locations = $query->get()->map(function ($location) {
            $lat = (float) $location->latitude;
            $lng = (float) $location->longitude;

            // Safeguard: Auto-swap jika Latitude dan Longitude tertukar di DB
            // Wilayah Indonesia/Sumut: Latitude kisaran -11 s/d 6, Longitude kisaran 95 s/d 141
            if ($lat > 20 && $lng < 15) {
                $temp = $lat;
                $lat = $lng;
                $lng = $temp;
            }

            return [
                'id' => $location->id,
                'name' => trim(($location->building ?? '-') . ' - ' . ($location->room ?? '-')),
                'regional' => $location->regional,
                'address' => collect([$location->site, $location->building, $location->room])->filter()->implode(' • '),
                'latitude' => $lat,
                'longitude' => $lng,
                'asset_summary' => [
                    'total' => $location->assets->count(),
                    'baik' => $location->assets->where('condition', 'Baik')->count(),
                    'rusak_ringan' => $location->assets->where('condition', 'Rusak Ringan')->count(),
                    'rusak_berat' => $location->assets->where('condition', 'Rusak Berat')->count(),
                ],
                'assets' => $location->assets->map(function ($asset) {
                    return [
                        'asset_code' => $asset->asset_code,
                        'brand' => $asset->brand,
                        'model' => $asset->model,
                        'category' => $asset->category->name ?? null,
                        'serial_number' => $asset->serial_number,
                        'status' => $asset->status,
                        'condition' => $asset->condition,
                    ];
                })->values(),
            ];
        })->filter(function ($location) {
            // Abaikan lokasi yang koordinatnya 0, null, atau kosong
            return !empty($location['latitude']) && !empty($location['longitude']) && $location['latitude'] != 0;
        })->values();

        return response()->json(['data' => $locations]);
    }

    private function validated(Request $request): array
    {
        return $request->validate([
            'regional' => ['required', 'string', 'max:100'],
            'site' => ['nullable', 'string', 'max:100'],
            'building' => ['nullable', 'string', 'max:100'],
            'room' => ['nullable', 'string', 'max:100'],
            'description' => ['nullable', 'string'],
            'latitude' => ['nullable', 'numeric', 'between:-90,90'],
            'longitude' => ['nullable', 'numeric', 'between:-180,180'],
        ]);
    }
}
