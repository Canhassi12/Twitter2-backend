<?php

namespace Tests\Feature\Controller;

use App\Models\Post;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\Storage;
use Laravel\Sanctum\Sanctum;
use Tests\TestCase;

class PostControllerTest extends TestCase
{
    public function test_store_a_post()
    {
        $user = User::factory()->create();

        Sanctum::actingAs(
            $user,
            ['*']
        );

        $response = $this->post(route('post.store'), [
            'text' => 'Lorem ipsum dolor sit amet, consectet vvvvvvvvvvvvvvvvvvvvvvvvvvvvvvvvvvvvv'
        ]);

        $this->assertDatabaseHas('posts', [
            'text' => 'Lorem ipsum dolor sit amet, consectet vvvvvvvvvvvvvvvvvvvvvvvvvvvvvvvvvvvvv',
            'image' => null
        ]);

        $response->assertCreated();
    }

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

    public function test_delete_a_post() 
    {   
        $user = User::factory()->create();

        Sanctum::actingAs(
            $user, 
            ['*']
        );

        $inputs = [
            'text' => 'test',
            'id' => 2,
        ];

        $post = auth()->user()->posts()->create($inputs);

        $response = $this->delete(route('post.destroy', $post->id), [
            'id' => $post->id,
        ]);

        $this->assertDatabaseEmpty('posts');
        $response->assertNoContent();
    }

    public function test_get_posts_to_paginate() 
    {
        $user = User::factory()->create();

        Sanctum::actingAs(
            $user, 
            ['*']
        );

        $inputs = [
            'text' => 'test',
            'id' => 2,
        ];

        for ($i = -1; $i < 20; $i++) {
            auth()->user()->posts()->create($inputs);
        }

        $response = $this->get(route('post.index'));
        $response->assertOk();
        $response->assertJsonStructure([
            "posts" => [
                [
                    "id",
                    "text",
                    "image",
                    "user_id",
                    "created_at",
                    "updated_at"
                ]
            ]
        ]);
        $response->assertJsonCount(20, 'posts');    
    }
}
