<?php

namespace Tests\Feature;

use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class RememberLoginTest extends TestCase
{
    use RefreshDatabase;

    public function test_user_can_choose_to_be_remembered_when_logging_in(): void
    {
        $this->seed();

        $response = $this->post(route('login.process'), [
            'username' => 'admin',
            'password' => 'admin123',
            'remember' => '1',
        ]);

        $response->assertRedirect(route('dashboard'));
        $this->assertAuthenticatedAs(User::where('username', 'admin')->first());
        $this->assertNotEmpty(User::where('username', 'admin')->value('remember_token'));
    }
}
