<?php

namespace Dp0\UserActivity\services;

use Dp0\UserActivity\Models\UserActivity;
use Exception;

class UserActivityService
{
    public function userActivity($event, $table, $user_id, $oldData = NULL, $newData = NULL)
    {
        UserActivity::insert([
            'table' => $table,
            'event' => $event,
            'user_id' => $user_id,
            'old_data' => json_encode($oldData),
            'new_data' => json_encode($newData),
            'ip_address' => request()->ip(),
            'user_agent' => request()->header('User-Agent'),
            'created_at' => now()
        ]);
    }
}
