<?php

namespace App\Listeners;

use App\Support\AuditLogger;
use Illuminate\Auth\Events\Failed;
use Illuminate\Auth\Events\Login;
use Illuminate\Auth\Events\Logout;

class AuditAuthListener
{
    public function handleLogin(Login $event): void
    {
        AuditLogger::login($event->user->email, success: true);
    }

    public function handleLogout(Logout $event): void
    {
        AuditLogger::logout();
    }

    public function handleFailed(Failed $event): void
    {
        AuditLogger::login($event->credentials['email'] ?? 'unknown', success: false);
    }
}


/* ─────────────────────────────────────────────────────────
 * Daftarkan listener ini di App\Providers\EventServiceProvider
 * (atau di AppServiceProvider jika Laravel 11+)
 *
 * protected $listen = [
 *     \Illuminate\Auth\Events\Login::class  => [AuditAuthListener::class . '@handleLogin'],
 *     \Illuminate\Auth\Events\Logout::class => [AuditAuthListener::class . '@handleLogout'],
 *     \Illuminate\Auth\Events\Failed::class => [AuditAuthListener::class . '@handleFailed'],
 * ];
 *
 * ─── ATAU di AppServiceProvider Laravel 11 ───────────────
 *
 * use Illuminate\Support\Facades\Event;
 * use Illuminate\Auth\Events\{Login, Logout, Failed};
 *
 * Event::listen(Login::class,  [AuditAuthListener::class, 'handleLogin']);
 * Event::listen(Logout::class, [AuditAuthListener::class, 'handleLogout']);
 * Event::listen(Failed::class, [AuditAuthListener::class, 'handleFailed']);
 * ───────────────────────────────────────────────────────── */