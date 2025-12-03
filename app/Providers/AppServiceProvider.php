<?php

namespace App\Providers;

use App\Http\Services\Project\ProjectService;
use App\Http\Services\Project\ProjectServiceInterface;
use App\Http\Services\Task\TaskService;
use App\Http\Services\Task\TaskServiceInterface;
use Illuminate\Support\ServiceProvider;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     */
    public function register(): void
    {
        $this->app->bind(ProjectServiceInterface::class, ProjectService::class);
        $this->app->bind(TaskServiceInterface::class, TaskService::class);
    }

    /**
     * Bootstrap any application services.
     */
    public function boot(): void
    {
        //
    }
}
