<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;


class AppServiceProvider extends ServiceProvider
{
    
    //added policies
    protected $policies = [
        \App\Models\Show::class => \App\Policies\ShowPolicy::class,
        \App\Models\Comment::class => \App\Policies\CommentPolicy::class,
    ];

    
    
    /**
     * Register any application services.
     */
    public function register(): void
    {
        //
    }

    /**
     * Bootstrap any application services.
     */
    public function boot(): void
    {
        //
    }
}
