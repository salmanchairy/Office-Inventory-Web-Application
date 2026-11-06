<?php

namespace App\Http\Controllers;

use App\Models\Asset;
use Endroid\QrCode\Builder\Builder;
use Endroid\QrCode\Writer\SvgWriter;
use Illuminate\Http\Request;

class QrCodeController extends Controller
{
    public function generate(Request $request, Asset $asset)
    {
        if (ob_get_length()) {
            ob_clean();
        }

        $response = response($this->svg($asset), 200)
            ->header('Content-Type', 'image/svg+xml')
            ->header('Cache-Control', 'max-age=86400, public');

        if ($request->boolean('download')) {
            $response->header('Content-Disposition', 'attachment; filename="' . $asset->asset_code . '-qr.svg"');
        }

        return $response;
    }

    public function print(Asset $asset)
    {
        return view('assets.qr-print', compact('asset'));
    }

    private function svg(Asset $asset): string
    {
        return (new Builder(
            writer: new SvgWriter(),
            data: $asset->asset_code,
            size: 300,
            margin: 10,
        ))->build()->getString();
    }
}
