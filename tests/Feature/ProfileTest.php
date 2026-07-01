<?php

namespace Tests\Feature;

use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\Storage;
use Tests\TestCase;

class ProfileTest extends TestCase
{
    use RefreshDatabase;

    public function test_user_can_upload_profile_picture(): void
    {
        Storage::fake('public');

        $user = User::factory()->create();

        $file = UploadedFile::fake()->image('avatar.jpg');

        $response = $this->actingAs($user)
            ->put(route('profile.photo-upload'), [
                'profile_picture_path' => $file,
            ]);

        $response->assertRedirect(route('admin.profile.settings'));

        $user->refresh();

        $this->assertNotNull($user->profile_picture_path);
        Storage::disk('public')->assertExists($user->profile_picture_path);
    }

    public function test_user_can_delete_profile_picture(): void
    {
        Storage::fake('public');

        $user = User::factory()->create([
            'profile_picture_path' => 'avatars/avatar.jpg',
        ]);

        Storage::disk('public')->put('avatars/avatar.jpg', 'fake content');

        $response = $this->actingAs($user)
            ->post(route('profile.delete-photo'));

        $response->assertRedirect(route('admin.profile.settings'));

        $user->refresh();

        $this->assertNull($user->profile_picture_path);
        Storage::disk('public')->assertMissing('avatars/avatar.jpg');
    }
}
