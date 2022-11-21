<?php

namespace Tests\Feature\Controller;

use App\Models\Post;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Support\Facades\Hash;
use Laravel\Sanctum\Sanctum;
use Tests\TestCase;

class PostControllerTest extends TestCase
{
    /**
     *
     * @return void
     * @test
     */
    public function store_a_post_with_authenticated_user() 
    {
        $user = User::factory()->create();

        Sanctum::actingAs(
            $user,
            ['*']
        );

        $response = $this->post(route('post.store'), [
            'text' => 'Lorem ipsum dolor sit amet, consectet vvvvvvvvvvvvvvvvvvvvvvvvvvvvvvvvvvvvv',
        ]);

        $response->assertCreated();
    }

    /**
     *
     * @return void
     * @test
     */
    public function delete_a_post() 
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
            'text' => $post->text,

        ]);

        $response->assertNoContent();
    }
}
