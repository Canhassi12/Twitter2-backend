<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Mockery;
use Mockery\MockInterface;
use Tests\TestCase;

class FollowerController extends TestCase
{
   public function test_show_followers_of_a_account()
   {
        $test = $this->createMock(
            ::class,
            Mockery::mock(FindIntegration::class, function (MockInterface $mock) {
                $mock->shouldReceive('handle')
                ->with('movida', 3)
                ->once()
                ->andReturn([]);
            })
        );
   }
}
