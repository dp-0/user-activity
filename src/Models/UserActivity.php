<?php

namespace Dp0\UserActivity\Models;

use App\Models\User;
use Dp0\UserActivity\traits\UserActivity as TraitsUserActivity;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class UserActivity extends Model
{
    use HasFactory, TraitsUserActivity;
    protected $fillable = [
        'table',
        'event',
        'user_id',
        'old_data',
        'new_data',
        'ip_address',
        'user_agent'
    ];
}
