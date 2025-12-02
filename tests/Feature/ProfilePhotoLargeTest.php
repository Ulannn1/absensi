<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\Storage;
use Tests\TestCase;
use App\Models\User;

class ProfilePhotoLargeTest extends TestCase
{
    use RefreshDatabase;

    public function test_user_can_upload_photo_larger_than_5mb()
    {
        Storage::fake('public');

        $user = User::factory()->create();
        $this->actingAs($user);

        // create a fake file ~6MB (6000 KB)
        $file = UploadedFile::fake()->create('big.jpg', 6000, 'image/jpeg');

        $resp = $this->post(route('profile.update'), [
            'name' => $user->name,
            'photo' => $file,
        ]);

        $resp->assertRedirect();

        Storage::disk('public')->assertExists('profiles/'.$file->hashName());
        $this->assertDatabaseHas('users', ['id' => $user->id, 'photo' => 'profiles/'.$file->hashName()]);
    }
}
