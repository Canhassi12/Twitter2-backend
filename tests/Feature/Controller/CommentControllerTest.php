<?php

namespace Tests\Feature\Controller;

use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Laravel\Sanctum\Sanctum;
use Tests\TestCase;

class CommentControllerTest extends TestCase
{
    public function test_store_a_comment_in_a_post()
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

        $response = $this->post(route('comment.store'), [
            'post_id' => $post->id,
            'comment' => "Lorem ipsum dolor sit amet consectetur adipisicing elit. Autem nesciunt facilis nulla necessitatibus molestias impedit et vitae, ipsum nemo optio non explicabo velit delectus dignissimos quaerat? Enim labore eaque maxime?"
        ]);

        $this->assertDatabaseHas('comments', [
            'user_id' => $user->id,
            'post_id' => $post->id,
            'comment' => "Lorem ipsum dolor sit amet consectetur adipisicing elit. Autem nesciunt facilis nulla necessitatibus molestias impedit et vitae, ipsum nemo optio non explicabo velit delectus dignissimos quaerat? Enim labore eaque maxime?"
        ]);
        $response->assertCreated();
    }

    public function test_delete_a_comment_of_post() 
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

        $response = $this->delete(route('comment.destroy', $post->id));

        $this->assertDatabaseMissing('comments', [
            'user_id' => $user->id,
            'post_id' => $post->id,
            'comment' => "Lorem ipsum dolor sit amet consectetur adipisicing elit. Autem nesciunt facilis nulla necessitatibus molestias impedit et vitae, ipsum nemo optio non explicabo velit delectus dignissimos quaerat? Enim labore eaque maxime?"
        ]);

        $response->assertNoContent();
    }
}
