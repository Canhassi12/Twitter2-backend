<?php

namespace Tests\Feature\Controllers;

use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\Storage;
use Laravel\Sanctum\Sanctum;
use Symfony\Component\HttpFoundation\Response;
use Tests\TestCase;

class UserControllerTest extends TestCase
{
    public function test_store_new_user()
    {
        $user = User::factory()->make();

        $response = $this->post(route('user.store'), [
            'name'      => $user->name,
            'email'     => $user->email,
            'nick_name' => $user->nick_name,
            'password'  => $user->password
        ]);

        $response->assertStatus(Response::HTTP_CREATED);
        $response->assertCreated();
        $this->assertDatabaseHas('users', [
            'name'      => $user->name,
            'email'     => $user->email,
            'nick_name' => $user->nick_name,
        ]);
    }

    public function test_destroy_a_user()
    {
        $user = User::factory()->create();

        Sanctum::actingAs(
            $user, 
            ['*']
        );

        $response = $this->delete(route('user.destroy',$user->id));
        
        $response->assertNoContent();
        $this->assertDatabaseEmpty('users');
    }

    public function test_destroy_a_user_and_delete_your_images_from_public()
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

        auth()->user()->posts()->create($inputs); 
        auth()->user()->posts()->create($inputs); 
        auth()->user()->posts()->create($inputs); 

        $response = $this->delete(route('user.destroy', $user->id));

        Storage::disk('images')->assertMissing($inputs['image']);
        $response->assertNoContent();
        $this->assertDatabaseEmpty('posts');
        $this->assertDatabaseEmpty('users');
    }
}
