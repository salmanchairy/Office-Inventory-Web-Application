<?php

namespace Tests\Feature;

use App\Models\Location;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class DistributionMapTest extends TestCase
{
    use RefreshDatabase;

    public function test_authenticated_user_can_open_map_and_read_location_asset_data(): void
    {
        $this->seed();
        $user = User::where('username', 'petugas')->firstOrFail();
        $location = Location::firstOrFail();
        $location->update([
            'latitude' => 3.5951960,
            'longitude' => 98.6722260,
        ]);

        $this->actingAs($user)
            ->get(route('maps.index'))
            ->assertOk()
            ->assertSee('const endpoint = "\\/api\\/map\\/locations";', false);

        $this->actingAs($user)
            ->getJson(route('api.map.locations'))
            ->assertOk()
            ->assertJsonCount(1, 'data')
            ->assertJsonPath('data.0.id', $location->id)
            ->assertJsonPath('data.0.asset_summary.total', 5)
            ->assertJsonPath('data.0.latitude', 3.595196)
            ->assertJsonPath('data.0.assets.0.asset_code', 'INV-R1-00057');
    }

    public function test_api_only_returns_locations_that_have_coordinates(): void
    {
        $this->seed();
        $user = User::where('username', 'admin')->firstOrFail();

        $this->actingAs($user)
            ->getJson(route('api.map.locations'))
            ->assertOk()
            ->assertJsonCount(0, 'data');
    }
}
