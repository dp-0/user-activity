<?php

namespace Dp0\UserActivity\Listeners;

use App\Models\User;
use Dp0\UserActivity\services\UserActivityService;
use Illuminate\Auth\Events\Lockout;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Queue\InteractsWithQueue;

class LockoutListener
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
    public function handle(Lockout $event): void
    {

        if (!config('user-activity.events.on_lockout', false) || !config('user-activity.activated', true)) return;
        if (!$event->request->has('email')) return;
        $user = User::where('email', $event->request->input('email'))->first();
        if (!$user) return;
        (new UserActivityService())->userActivity('Lockout', 'users', $user->id);
    }
}
