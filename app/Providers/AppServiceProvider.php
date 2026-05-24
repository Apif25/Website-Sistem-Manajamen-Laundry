<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use Illuminate\Support\Facades\Event;

use Illuminate\Auth\Events\Login;
use Illuminate\Auth\Events\Logout;
use Illuminate\Auth\Events\Failed;

use App\Listeners\AuditAuthListener;

use App\Repositories\Contracts\ProsesRepositoryInterface;
use App\Repositories\ProsesRepository;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     */
    public function register(): void
    {
        $this->app->bind(
            ProsesRepositoryInterface::class,
            ProsesRepository::class
        );
    }

    /**
     * Bootstrap any application services.
     */
    public function boot(): void
    {
        Event::listen(
            Login::class,
            [AuditAuthListener::class, 'handleLogin']
        );

        Event::listen(
            Logout::class,
            [AuditAuthListener::class, 'handleLogout']
        );

        Event::listen(
            Failed::class,
            [AuditAuthListener::class, 'handleFailed']
        );
    }
}
