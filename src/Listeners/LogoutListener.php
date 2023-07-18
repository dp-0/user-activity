<?php

namespace Dp0\UserActivity\Listeners;


use Dp0\UserActivity\services\UserActivityService;
use Illuminate\Auth\Events\Logout;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Support\Facades\Log;

class LogoutListener
{
    // private $request;
    /**
     * Create the event listener.
     */
    public function __construct()
    {
    }

    /**
     * Handle the event.
     */
    public function handle(Logout $event): void
    {
        if (!config('user-activity.events.on_logout', false) || !config('user-activity.activated', true)) return;
        (new UserActivityService())->userActivity('Logout','users',$event->user->id);
    }
}
