<?php

namespace Tests\Feature\Controller;

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
    public function 
}
