<?php

namespace Tests\Feature;

use App\Models\Asset;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class ScanAssetTest extends TestCase
{
    use RefreshDatabase;

    public function test_scan_page_and_lookup_return_a_relative_asset_url(): void
    {
        $this->seed();
        $user = User::where('username', 'petugas')->firstOrFail();
        $asset = Asset::firstOrFail();

        $this->actingAs($user)
            ->get(route('scan.index'))
            ->assertOk()
            ->assertSee('Aktifkan Kamera')
            ->assertSee('Unggah Gambar QR')
            ->assertDontSee('Cari dengan kode inventaris');

        $this->actingAs($user)
            ->getJson(route('scan.find-asset', $asset->asset_code))
            ->assertOk()
            ->assertJsonPath('asset.asset_code', $asset->asset_code)
            ->assertJsonPath('asset.url', '/assets/' . $asset->id);
    }

    public function test_scan_lookup_reports_unknown_asset(): void
    {
        $this->seed();

        $this->actingAs(User::where('username', 'petugas')->firstOrFail())
            ->getJson(route('scan.find-asset', 'UNKNOWN'))
            ->assertNotFound()
            ->assertJsonPath('success', false);
    }
}
