<?php

namespace Dp0\UserActivity\Console;

use Illuminate\Console\Command;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\Schema;

class UserActivityInstall extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'user-activity:install';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Publishing config and running migration for user-activity';

    /**
     * Create a new command instance.
     *
     * @return void
     */
    public function __construct()
    {
        parent::__construct();
    }

    /**
     * Execute the console command.
     *
     * @return mixed
     */
    public function handle()
    {
        $migrationFile = "2023_07_13_022852_create_user_activities_table.php";
        //config
        if (File::exists(config_path('user-activity.php'))) {
            $confirm = $this->confirm("user-activity.php config file already exist. Do you want to overwrite?");
            if ($confirm) {
                $this->publishConfig();
                $this->info("config overwrite finished");
            } else {
                $this->info("skipped config publish");
            }
        } else {
            $this->publishConfig();
            $this->info("config published");
        }
        $this->line('--------------------------------------------');

        if (File::exists(database_path("migrations/$migrationFile"))) {
            $confirm = $this->confirm("migration file already exist. Do you want to overwrite?");
            if ($confirm) {
                $this->publishMigration();
                $this->info("migration overwrite finished");
            } else {
                $this->info("skipped migration publish");
            }
        } else {
            $this->publishMigration();
            $this->info("migration published");
        }
        $this->line('-----------------------------');

        if (File::exists(resource_path('css/user-activity.css'))) {
            $confirm = $this->confirm("user-activity.css CSS file already exist. Do you want to overwrite?");
            if ($confirm) {
                $this->publishCSS();
                $this->info("CSS overwrite finished");
                $this->addImportStatement();
            } else {
                $this->info("Skipped CSS publish");
            }
        } else {
            $this->publishCSS();
            $this->addImportStatement();
            $this->info("CSS published");
        }
        $this->line('--------------------------------------------');
    }

    private function publishConfig()
    {
        $this->call('vendor:publish', [
            '--provider' => "Dp0\UserActivity\UserActivityServiceProvider",
            '--tag'      => 'config',
            '--force'    => true
        ]);
    }

    private function publishMigration()
    {
        $this->call('vendor:publish', [
            '--provider' => "Dp0\UserActivity\UserActivityServiceProvider",
            '--tag'      => 'migrations',
            '--force'    => true
        ]);
    }

    private function publishCSS()
    {
        $this->call('vendor:publish', [
            '--provider' => "Dp0\UserActivity\UserActivityServiceProvider",
            '--tag'      => 'css',
            '--force'    => true
        ]);
    }

    private function addImportStatement()
    {
        $cssFilePath = resource_path('css/user-activity.css');
        $appCssFilePath = resource_path('css/app.css');

        if (File::exists($cssFilePath)) {
            if (File::exists($appCssFilePath)) {
                $importStatement = "@import url('user-activity.css');\n";
                $existingContent = File::get($appCssFilePath);
                $newContent = $importStatement . $existingContent;
                File::put($appCssFilePath, $newContent);
                $this->info("Import statement added to app.css");
            } else {
                $this->error("app.css file not found");
            }
        } else {
            $this->error("CSS file not found");
        }
    }
}
