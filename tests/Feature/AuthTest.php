<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;
use App\Models\User;

class AuthTest extends TestCase
{
    use RefreshDatabase;

    public function test_login_page_shows()
    {
        $response = $this->get('/login');
        $response->assertStatus(200);
    }

    public function test_user_can_login()
    {
        $user = User::factory()->create(['email'=>'user@test.com']);

        $response = $this->post('/login', ['email' => 'user@test.com', 'password' => 'password']);

        $response->assertRedirect('/dashboard');
        $this->assertAuthenticated();
    }
}
