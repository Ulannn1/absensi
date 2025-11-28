<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;
use App\Models\User;

class AttendanceTest extends TestCase
{
    use RefreshDatabase;

    public function test_user_can_checkin_and_checkout()
    {
        $user = User::factory()->create(['email'=>'intern@test.com']);
        $this->actingAs($user);

        $resp = $this->post('/attendances/checkin');
        $resp->assertStatus(302);

        $resp2 = $this->post('/attendances/checkout', ['checkout_report' => 'Done tasks']);
        $resp2->assertStatus(302);

        $this->assertDatabaseHas('attendances', ['user_id' => $user->id]);
    }
}
