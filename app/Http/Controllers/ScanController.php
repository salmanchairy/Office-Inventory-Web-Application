<?php

namespace App\Http\Controllers;

use App\Models\Asset;

class ScanController extends Controller
{
    public function index()
    {
        return view('scan.index');
    }

    public function findAsset($asset_code)
    {
        // Bersihkan hasil scan
        $assetCode = trim($asset_code);

        // Cari asset berdasarkan ID inventaris
        $asset = Asset::where('asset_code', $assetCode)->first();

        if (!$asset) {
            return response()->json([
                'success' => false,
                'message' => 'Asset dengan ID "' . $assetCode . '" tidak ditemukan.',
            ], 404);
        }

        return response()->json([
            'success' => true,
            'message' => 'Asset berhasil ditemukan.',
            'asset' => [
                'id' => $asset->id,
                'asset_code' => $asset->asset_code,
                'url' => route('assets.show', $asset, false),
            ],
        ]);
    }
}
