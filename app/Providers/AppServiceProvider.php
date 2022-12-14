<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     *
     * @return void
     */
    public function register()
    {
        //
    }

    /**
     * Bootstrap any application services.
     *
     * @return void
     */
    public function boot()
    {
        $this->app->bind(
            'App\Repositories\Users\UsersRepositoryInterface',
            'App\Repositories\Users\UsersRepository'
        );

        $this->app->bind(
            'App\Repositories\Posts\PostsRepositoryInterface',
            'App\Repositories\Posts\PostsRepository'
        );

        $this->app->bind(
            'App\Repositories\Comments\CommentsRepositoryInterface',
            'App\Repositories\Comments\CommentsRepository'
        );
        
    }
}
