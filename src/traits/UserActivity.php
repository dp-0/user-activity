<?php

namespace Dp0\UserActivity\traits;

use Dp0\UserActivity\services\UserActivityService;

trait UserActivity
{
    public static function bootUserActivity()
    {
        $userId = auth()->user()?->id;
        if (config('user-activity.events.on_create', false)) {
            static::created(function ($model) use ($userId) {
                if($model->exceptCreate) return;
                if($model->getTable() == 'users') $userId = $model->id;
                (new UserActivityService())->userActivity('create', $model->getTable(), $userId, NULL, json_encode($model->toArray(),JSON_PRETTY_PRINT));
            });
        }
        if (config('user-activity.events.on_update', false)) {
            static::updated(function ($model) use ($userId) {
                if($model->exceptUpdate) return;
                (new UserActivityService())->userActivity('update', $model->getTable(), $userId, self::convertToJson($model), json_encode($model->toArray(),JSON_PRETTY_PRINT));
            });
        }

        if (config('user-activity.events.on_delete', false)) {
            static::deleted(function ($model) use ($userId) {
                if($model->exceptDelete) return;
                (new UserActivityService())->userActivity('delete', $model->getTable(), $userId, self::convertToJson($model), null);
            });
        }
    }

    private function removeHiddenFields($model)
    {
        $modelArray = $model->getOriginal();
        foreach ($model->hidden as $hiddenField) {
            unset($modelArray[$hiddenField]);
        }
        return $modelArray;
    }

    public static function convertToJson($model)
    {
        $hiddenFieldRemovedData = $model->removeHiddenFields($model);
        return json_encode($hiddenFieldRemovedData, JSON_PRETTY_PRINT);
    }
}
