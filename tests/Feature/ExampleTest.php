<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class ExampleTest extends TestCase
{
    use RefreshDatabase;

    /**
     * A basic test example.
     */
    public function test_the_application_returns_a_successful_response(): void
    {
        $response = $this->get('/login');

        $response->assertStatus(200);
    }

    public function test_authenticated_user_can_access_dashboard(): void
    {
        $this->seed();
        $user = \App\Models\User::where('username', 'admin')->first();

        $response = $this->actingAs($user)->get('/');

        $response->assertStatus(200);
    }
}
