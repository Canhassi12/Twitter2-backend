<?php

namespace Tests\Feature\Controller;

use App\Exceptions\UserException;
use App\Models\Follower;
use App\Models\User;
use Faker\Factory;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Laravel\Sanctum\Sanctum;
use Mockery\MockInterface;
use Tests\TestCase;

class FollowerControllerTest extends TestCase
{
   public function test_show_followers_of_a_account()
   {
      //seguir o user2 com user;
      $user = User::factory()->create();
      $user2 = User::factory()->create();
      $user3 = User::factory()->create();


      Sanctum::actingAs(
         $user,
         ['*']
      );

      Follower::factory(['user_id' => $user2->id,'id_followed' => $user->id])->create();
      Follower::factory(['user_id' => $user3->id,'id_followed' => $user->id])->create();
  
      $response = $this->get(route('follow.show', $user2->id));

      $response->assertJsonStructure([
         [
            "id",
			   "nick_name",
			   "name",
			   "email",
			   "profile_pic",
			   "backgroud_pic",
			   "email_verified_at",
         ]
      ]);
      $response->assertOk();
   }

   public function test_exception_get_followers_from_an_account_with_no_followers()
   {
      $user = User::factory()->create();
    
      Sanctum::actingAs(
         $user,
         ['*']
      );

      $response = $this->get(route('follow.show', $user->id));

      $exception = UserException::noUsers();
      $response->assertStatus($exception->getCode());
      $response->assertSee($exception->getMessage());
   }

   public function test_exception_follow_a_nonexistent_user() 
   {
      $user = User::factory()->create();
      
      Sanctum::actingAs(
         $user,
         ['*']
      );

      $response = $this->post(route('follow.user', 777));

      $exception = UserException::invalidUserId(777);
      
      $response->assertStatus($exception->getCode());
      $response->assertSee($exception->getMessage());
   }

   public function test_follow_a_user() 
   {
      $user = User::factory()->create();
      $user2 = User::factory()->create();
      
      Sanctum::actingAs(
         $user,
         ['*']
      );

      $response = $this->post(route('follow.user', $user2->id));

      $response->assertOk();
      $this->assertDatabaseCount('followers', 1);
   }

   public function test_exception_follow_a_user_already_followed() 
   {
      //seguir o user2 com user;
      $user = User::factory()->create();
      $user2 = User::factory()->create();
   
      Sanctum::actingAs(
         $user,
         ['*']
      );

      Follower::factory(['user_id' => $user2->id,'id_followed' => $user->id])->create();
     

      $response = $this->post(route('follow.user', $user2->id));

      $exception = UserException::userAlreadyFollowed($user2->id);
      $response->assertStatus($exception->getCode());
      $response->assertSee($exception->getMessage());
   }
}
