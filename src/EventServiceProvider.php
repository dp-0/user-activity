<?php

namespace Dp0\UserActivity;

use Dp0\UserActivity\Listeners\LockoutListener;
use Dp0\UserActivity\Listeners\LoginListener;
use Dp0\UserActivity\Listeners\LogoutListener;
use Illuminate\Auth\Events\Lockout;
use Illuminate\Auth\Events\Login;
use Illuminate\Auth\Events\Logout;
use Illuminate\Foundation\Support\Providers\EventServiceProvider as ProvidersEventServiceProvider;

class EventServiceProvider extends ProvidersEventServiceProvider
{
    protected $listen = [
        Login::class   => [
            LoginListener::class
        ],
        Logout::class => [
            LogoutListener::class
        ],
        Lockout::class => [
            LockoutListener::class
        ],
    ];

    public function boot()
    {
        parent::boot();
    }
}