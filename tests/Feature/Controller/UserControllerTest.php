<?php

namespace Tests\Feature\Controllers;

use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Support\Facades\Hash;
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
    }
}
