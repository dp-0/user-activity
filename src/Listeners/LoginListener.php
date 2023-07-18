<?php

namespace Dp0\UserActivity\Listeners;

use Dp0\UserActivity\services\UserActivityService;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Queue\InteractsWithQueue;

class LoginListener
{
    /**
     * Create the event listener.
     */
    public function __construct()
    {
    }

    /**
     * Handle the event.
     */
    public function handle(object $event): void
    {
        if (!config('user-activity.events.on_login', false) || !config('user-activity.activated', true)) return;
        (new UserActivityService())->userActivity('Login','users',$event->user->id);
    }
}
