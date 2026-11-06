<?php

namespace Tests\Feature;

use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class AssetCreateFormTest extends TestCase
{
    use RefreshDatabase;

    public function test_authenticated_user_can_open_simplified_asset_create_form(): void
    {
        $this->seed();
        $user = User::where('username', 'admin')->firstOrFail();

        $this->actingAs($user)
            ->get(route('assets.create'))
            ->assertOk()
            ->assertSee('Informasi perangkat')
            ->assertSee('Kondisi & status', false)
            ->assertSee('ID inventaris dibuat otomatis');
    }
}
