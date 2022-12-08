<?php

namespace Tests\Feature\Contr;

use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Support\Facades\Hash;
use Tests\TestCase;

class AuthControllerTest extends TestCase
{
    public function test_login_a_user_with_successful() 
    {
        $password = 'aiiii';

        $user = User::factory(['password' => Hash::make($password)])->create();

        $response = $this->post(route('login'), [
            'email' => $user->email,
            'password' => $password,
        ]);

        $response->assertOk();
    }

    public function test_logout_with_authenticated_user(): void
    {
        $password = 'aiiii';

        $user = User::factory(['password' => Hash::make($password)])->create();

        $this->post('/api/auth/login', [
            'email' => $user->email, 
            'password' => $password,
        ]);

        $this->post('/api/auth/logout')
        ->assertNoContent();
    }
}
