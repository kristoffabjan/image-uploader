<?php

namespace Tests\Feature;

use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\Storage;
use Tests\TestCase;

class MediaUploadTest extends TestCase
{
    /**
     * A basic feature test example.
     */
    public function test_example(): void
    {
        $response = $this->get('/');

        $response->assertStatus(200);
    }

    /**
     * Test media upload with empty data body
     */
    public function test_empty_request_body(): void
    {
        $user = User::factory()->create();

        $response = $this->actingAs($user)
            ->postJson('/api/media-upload', []);

        $response->assertStatus(422);
    }

    /**
     * Test media upload with missing media
     */
    public function test_missing_media(): void
    {
        $user = User::factory()->create();

        $response = $this->actingAs($user)
            ->postJson('/api/media-upload', [
                'title' => 'Test media upload',
                'description' => 'Test media upload description'
            ]);

        $response->assertStatus(422);
    }

    /**
     * Test media upload with invalid media(image) type
     */
    public function test_invalid_image_type_upload(): void
    {
        Storage::fake('media');
        $file = UploadedFile::fake()->image('image.webp');
 
        $user = User::factory()->create();
        
        $response = $this->actingAs($user)
        ->postJson('/api/media-upload', [
            'title' => 'Test media upload',
            'description' => 'Test media upload description',
            'media' => $file
        ]);

        $response->assertStatus(422);
    }

    /**
     * Test media upload with invalid media(video) type
     */
    public function test_invalid_video_type_upload(): void
    {
        Storage::fake('media');
        $file = UploadedFile::fake()->image('video.mov');
 
        $user = User::factory()->create();
        
        $response = $this->actingAs($user)
        ->postJson('/api/media-upload', [
            'title' => 'Test video media upload',
            'description' => 'Test video media upload description',
            'media' => $file
        ]);

        $response->assertStatus(422);
    }

    /**
     * Test media upload with valid data
     */
    public function test_valid_media_upload(): void
    {
        Storage::fake('media');
        $file = UploadedFile::fake()->image('image.jpg');
 
        $user = User::factory()->create();
        
        $response = $this->actingAs($user)
        ->postJson('/api/media-upload', [
            'title' => 'Test media upload',
            'description' => 'Test media upload description',
            'media' => $file
        ]);

        $response->assertStatus(201);
    }

    /**
     * Test unauthorized media upload
     */
    public function test_unauthorized_media_upload(): void
    {
        Storage::fake('media');
        
        $file = UploadedFile::fake()->image('image.jpg');
        
        $response = $this
        ->postJson('/api/media-upload', [
            'title' => 'Test media upload',
            'description' => 'Test media upload description',
            'media' => $file
        ]);

        $response->assertStatus(401);
    }
}
