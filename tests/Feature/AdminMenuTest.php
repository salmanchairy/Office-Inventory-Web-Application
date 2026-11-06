<?php

namespace Tests\Feature;

use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class AdminMenuTest extends TestCase
{
    use RefreshDatabase;

    public function test_admin_can_open_previously_empty_menu_pages(): void
    {
        $this->seed();
        $admin = User::where('username', 'admin')->firstOrFail();

        $this->actingAs($admin)->get(route('reports.assets'))->assertOk();
        $this->actingAs($admin)->get(route('categories.index'))->assertOk();
        $this->actingAs($admin)->get(route('locations.index'))->assertOk();
        $this->actingAs($admin)->get(route('users.index'))->assertOk();
    }

    public function test_petugas_cannot_open_administration_pages(): void
    {
        $this->seed();
        $petugas = User::where('username', 'petugas')->firstOrFail();

        $this->actingAs($petugas)->get(route('categories.index'))->assertForbidden();
        $this->actingAs($petugas)->get(route('locations.index'))->assertForbidden();
        $this->actingAs($petugas)->get(route('users.index'))->assertForbidden();
    }

    public function test_authenticated_user_can_export_asset_recap_as_pdf(): void
    {
        $this->seed();
        $user = User::where('username', 'petugas')->firstOrFail();

        $this->actingAs($user)
            ->get(route('reports.assets.export'))
            ->assertOk()
            ->assertHeader('content-type', 'application/pdf');
    }
}
