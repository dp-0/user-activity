<?php

namespace Dp0\UserActivity;

use Dp0\UserActivity\Console\UserActivityInstall;
use Dp0\UserActivity\Controllers\UserActivity;
use Illuminate\Support\ServiceProvider;
use Dp0\UserActivity\EventServiceProvider;
use Livewire;
class UserActivityServiceProvider extends ServiceProvider
{
    const CONFIG_PATH = __DIR__ . '/config/user-activity.php';
    const VIEW_PATH = __DIR__ . '/views';
    const ASSET_PATH = __DIR__ . '/assets';
    const MIGRATION_PATH = __DIR__ . '/migrations';
    const CSS_PATH = __DIR__.'/resources/css/app.css';

    /**
     * Register services.
     */
    public function register(): void
    {
        $this->mergeConfigFrom(
            self::CONFIG_PATH,
            'user-activity'
        );
        $this->app->register(EventServiceProvider::class);
        $this->commands([UserActivityInstall::class]);
    }

    /**
     * Bootstrap services.
     */
    public function boot(): void
    {
        $this->publish();
        $this->loadViewsFrom(self::VIEW_PATH, 'UserActivity');
        Livewire::component('d-user-activity', UserActivity::class);
    }

    private function publish()
    {
        $this->publishes([
            self::CONFIG_PATH => config_path('user-activity.php')
        ], 'config');

        $this->publishes([
            self::MIGRATION_PATH => database_path('migrations')
        ], 'migrations');

        $this->publishes([
            self::CSS_PATH => resource_path('css/user-activity.css')
        ], 'css');
    }
}
