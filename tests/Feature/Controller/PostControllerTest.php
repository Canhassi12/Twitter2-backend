<?php

namespace Tests\Feature\Controller;

use App\Models\Post;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Http\Testing\File;
use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\Storage;
use Laravel\Sanctum\Sanctum;
use Tests\TestCase;

class PostControllerTest extends TestCase
{
    public function test_store_a_post_with_image() 
    {
        $user = User::factory()->create();

        Sanctum::actingAs(
            $user,
            ['*']
        );

        Storage::fake('local');

        $response = $this->post(route('post.store'), [
            'text' => 'Lorem ipsum dolor sit amet, consectet vvvvvvvvvvvvvvvvvvvvvvvvvvvvvvvvvvvvv',
            'image' => UploadedFile::fake()->image('photo1.jpg')
        ]);

        $post = Post::latest()->first();
        
        Storage::disk('local')->assertExists($post->image);

        $this->assertDatabaseHas('posts', [
            'text' => 'Lorem ipsum dolor sit amet, consectet vvvvvvvvvvvvvvvvvvvvvvvvvvvvvvvvvvvvv',
            'image' => $post->image,
        ]);

        $response->assertCreated();
    }   

    
    public function test_delete_a_post_with_image() 
    {   
        $user = User::factory()->create();

        Sanctum::actingAs(
            $user, 
            ['*']
        );

        Storage::fake('images');

        $inputs = [
            'text' => 'test',
            'id' => 2,
            'image' => UploadedFile::fake()->image('photo1.jpg')->hashName(),
        ];

        $post = auth()->user()->posts()->create($inputs);

        $response = $this->delete(route('post.destroy', $post->id), [
            'id' => $post->id,
        ]);

        $post = Post::latest()->first();

        Storage::disk('local')->assertDirectoryEmpty('stogare/images');

        $this->assertDatabaseEmpty('posts');

        $response->assertNoContent();
    }
}
