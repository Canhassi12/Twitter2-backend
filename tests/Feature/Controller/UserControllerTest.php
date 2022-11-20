<?php

namespace Tests\Feature\Controllers;

use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Support\Facades\Hash;
use Tests\TestCase;

class UserControllerTest extends TestCase
{
    /**
     * @return void
     * @test
     */
    public function Store_new_user()
    {
        $user = User::factory()->make();

        $response = $this->post('/api/auth/register', [
            'name'      => $user->name,
            'email'     => $user->email,
            'nick_name' => $user->nick_name,
            'password'  => $user->password
        ]);

        $response->assertStatus(201);
        $response->assertCreated();
    }

    /**
     * @return void
     * @test
     */
    public function Login_a_user_with_successful() 
    {
        $password = 'aiiii';

        $user = User::factory(['password' => Hash::make($password)])->create();

        $response = $this->post('/api/auth/login', [
            'email' => $user->email,
            'password' => $password,
        ]);

        $response->assertOk();
    }

    /**
     * @return void
     * @test
     */
    public function logout_with_authenticated_user(): void
    {
        $password = 'aiiii';

        $user = User::factory(['password' => Hash::make($password)])->create();

        $this->post('/api/auth/login', [
            'email' => $user->email, 
            'password' => $password,
        ]);

        $this->post('/api/auth/logout')
        ->assertStatus(204);
    }


}
