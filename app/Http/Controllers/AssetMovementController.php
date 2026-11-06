<?php

namespace App\Http\Controllers;

use App\Models\Asset;
use App\Models\Location;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class AssetMovementController extends Controller
{
    public function create(Asset $asset)
    {
        return view('assets.move', [
            'asset' => $asset->load('location'),
            'locations' => Location::orderBy('regional')->orderBy('site')->orderBy('room')->get(),
        ]);
    }

    public function store(Request $request, Asset $asset)
    {
        $data = $request->validate([
            'to_location_id' => ['required', 'exists:locations,id'],
            'movement_date' => ['required', 'date'],
            'reason' => ['required', 'string', 'max:1000'],
        ]);
        if ((int) $data['to_location_id'] === (int) $asset->location_id) {
            return back()->withErrors(['to_location_id' => 'Pilih lokasi tujuan yang berbeda.'])->withInput();
        }

        DB::transaction(function () use ($asset, $data) {
            $asset->movements()->create([
                'from_location_id' => $asset->location_id,
                'to_location_id' => $data['to_location_id'],
                'moved_by' => auth()->id(),
                'movement_date' => $data['movement_date'],
                'reason' => $data['reason'],
            ]);
            $asset->update(['location_id' => $data['to_location_id'], 'status' => 'Dipindahkan']);
        });

        return redirect()->route('assets.show', $asset)->with('success', 'Perpindahan aset berhasil dicatat.');
    }
}
