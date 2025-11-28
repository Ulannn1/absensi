<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;
use App\Models\User;

class AttendanceHistoryTest extends TestCase
{
    use RefreshDatabase;

    public function test_checkin_appears_in_history()
    {
        $user = User::factory()->create(['email' => 'hist@test.com']);
        $this->actingAs($user);

        // perform checkin
        $this->post('/attendances/checkin')->assertStatus(302);

        // visit the history page
        $resp = $this->get('/attendances');
        $resp->assertStatus(200);

        // The table should contain today's date (history row)
        $today = now()->toDateString();
        $resp->assertSee($today);
    }
}
