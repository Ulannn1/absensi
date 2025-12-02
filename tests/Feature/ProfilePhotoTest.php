<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\Storage;
use Tests\TestCase;
use App\Models\User;

class ProfilePhotoTest extends TestCase
{
    use RefreshDatabase;

    public function test_user_can_upload_profile_photo()
    {
        Storage::fake('public');

        $user = User::factory()->create();
        $this->actingAs($user);

        // Use create() instead of image() which requires GD/Imagick in some test environments
        $file = UploadedFile::fake()->create('avatar.jpg', 120, 'image/jpeg');

        $resp = $this->post(route('profile.update'), [
            'name' => $user->name,
            'photo' => $file,
        ]);

        $resp->assertRedirect();

        // Assert the file was stored
        Storage::disk('public')->assertExists('profiles/'.$file->hashName());

        $this->assertDatabaseHas('users', ['id' => $user->id, 'photo' => 'profiles/'.$file->hashName()]);
    }
}
