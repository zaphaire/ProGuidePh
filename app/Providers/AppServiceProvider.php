<?php

namespace App\Providers;

use App\Events\PostPublished;
use App\Listeners\NotifySubscribersOfNewPost;
use Illuminate\Support\Facades\Event;
use Illuminate\Support\ServiceProvider;

class AppServiceProvider extends ServiceProvider
{
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
        view()->composer('*', function ($view) {
            $view->with('announcement', \App\Models\Announcement::active()->latest()->first());
        });

        Event::listen(PostPublished::class, NotifySubscribersOfNewPost::class);
    }
}
