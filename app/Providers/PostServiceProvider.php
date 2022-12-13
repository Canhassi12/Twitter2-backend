<?php

namespace App\Providers;

use App\Repositories\Posts\PostsRepository;
use App\Repositories\Posts\PostsRepositoryInterface;
use App\Services\PostService;
use Illuminate\Support\ServiceProvider;
use PostServiceInterface;

class PostServiceProvider extends ServiceProvider
{
    /**
     * Register services.
     *
     * @return void
     */
    public function register()
    {
       
    }

    /**
     * Bootstrap services.
     *
     * @return void
     */
    public function boot()
    {
        $this->app->bind(
            'App\Repositories\Posts\PostsRepositoryInterface',
            'App\Repositories\Posts\PostsRepository'
        );
    }
}
