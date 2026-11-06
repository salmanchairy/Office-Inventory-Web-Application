<?php

namespace Tests\Feature;

use App\Models\Asset;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class QrCodeTest extends TestCase
{
    use RefreshDatabase;

    public function test_authenticated_user_can_load_an_asset_qr_code(): void
    {
        $this->seed();

        $this->actingAs(User::where('username', 'admin')->firstOrFail())
            ->get(route('assets.qr', Asset::firstOrFail()))
            ->assertOk()
            ->assertHeader('content-type', 'image/svg+xml');
    }

    public function test_asset_detail_uses_a_relative_qr_url(): void
    {
        $this->seed();
        $asset = Asset::firstOrFail();

        $this->actingAs(User::where('username', 'admin')->firstOrFail())
            ->get(route('assets.show', $asset))
            ->assertOk()
            ->assertSee('src="/assets/' . $asset->id . '/qr"', false);
    }

    public function test_authenticated_user_can_download_and_print_an_asset_qr_code(): void
    {
        $this->seed();
        $user = User::where('username', 'admin')->firstOrFail();
        $asset = Asset::firstOrFail();

        $this->actingAs($user)
        $this->actingAs($user)
            ->get(route('assets.qr.print', $asset))
            ->assertOk()
            ->assertSee('Cetak QR');
    }
}
