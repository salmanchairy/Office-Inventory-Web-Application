<?php

namespace App\Http\Controllers;

use App\Models\Asset;
use Endroid\QrCode\Builder\Builder;
use Endroid\QrCode\Writer\SvgWriter;

class QrCodeController extends Controller
{
    public function generate(Asset $asset)
    {
        $builder = new Builder(
            writer: new SvgWriter(),
            data: $asset->asset_code,
            size: 300,
            margin: 10,
        );

        $result = $builder->build();

        return response($result->getString())
            ->header('Content-Type', $result->getMimeType());
    }
}