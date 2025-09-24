<?php

namespace App\Providers;

use App\Events\Group\UpdatedRequestGroup;
use App\Listeners\Group\AddMemberGroup;
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
        Event::listen(
            UpdatedRequestGroup::class,
            AddMemberGroup::class,
        );
    }
}
