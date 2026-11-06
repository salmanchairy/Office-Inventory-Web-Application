<?php

namespace App\Http\Controllers;

use App\Models\Asset;
use App\Models\Category;
use App\Models\Location;
use Barryvdh\DomPDF\Facade\Pdf;
use Illuminate\Http\Request;

class ReportController extends Controller
{
    public function index(Request $request)
    {
        $filters = $this->filters($request);
        $query = $this->filteredAssets($filters);

        $assets = $query->orderBy('asset_code')->paginate(15)->withQueryString();
        $summary = [
            'total' => (clone $query)->count(),
            'good' => (clone $query)->where('condition', 'Baik')->count(),
            'minor' => (clone $query)->where('condition', 'Rusak Ringan')->count(),
            'major' => (clone $query)->where('condition', 'Rusak Berat')->count(),
        ];

        return view('reports.index', [
            'assets' => $assets,
            'summary' => $summary,
            'categories' => Category::orderBy('name')->get(),
            'locations' => Location::orderBy('regional')->orderBy('site')->get(),
        ]);
    }

    public function export(Request $request)
    {
        $filters = $this->filters($request);
        $assets = $this->filteredAssets($filters)
            ->orderBy('asset_code')
            ->get();

        $summary = [
            'total' => $assets->count(),
            'good' => $assets->where('condition', 'Baik')->count(),
            'minor' => $assets->where('condition', 'Rusak Ringan')->count(),
            'major' => $assets->where('condition', 'Rusak Berat')->count(),
        ];

        $filterLabels = array_filter([
            'Kategori' => isset($filters['category_id']) ? Category::find($filters['category_id'])?->name : null,
            'Lokasi' => isset($filters['location_id']) ? Location::find($filters['location_id'])?->regional : null,
            'Kondisi' => $filters['condition'] ?? null,
            'Status' => $filters['status'] ?? null,
        ]);

        return Pdf::loadView('reports.pdf', compact('assets', 'filters', 'summary', 'filterLabels'))
            ->setPaper('a4', 'landscape')
            ->download('rekap-aset-' . now()->format('Y-m-d-His') . '.pdf');
    }

    private function filters(Request $request): array
    {
        return $request->validate([
            'category_id' => ['nullable', 'exists:categories,id'],
            'location_id' => ['nullable', 'exists:locations,id'],
            'condition' => ['nullable', 'in:Baik,Rusak Ringan,Rusak Berat'],
            'status' => ['nullable', 'in:Aktif,Dipinjam,Dipindahkan,Diperbaiki,Tidak Aktif,Dihapus'],
        ]);
    }

    private function filteredAssets(array $filters)
    {
        $query = Asset::with(['category', 'location']);

        foreach (['category_id', 'location_id', 'condition', 'status'] as $field) {
            if (!empty($filters[$field])) {
                $query->where($field, $filters[$field]);
            }
        }

        return $query;
    }
}
