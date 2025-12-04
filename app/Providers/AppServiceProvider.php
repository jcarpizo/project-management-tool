<?php declare(strict_types=1);

namespace App\Providers;

use App\Models\Project;
use App\Models\Task;
use App\Observers\ProjectObserver;
use App\Observers\TaskObserver;
use App\Services\AuditLog\AuditLogService;
use App\Services\AuditLog\AuditLogServiceInterface;
use App\Services\Project\ProjectService;
use App\Services\Project\ProjectServiceInterface;
use App\Services\Task\TaskService;
use App\Services\Task\TaskServiceInterface;
use App\Services\User\UserService;
use App\Services\User\UserServiceInterface;
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
        $this->app->bind(UserServiceInterface::class, UserService::class);
        $this->app->bind(AuditLogServiceInterface::class, AuditLogService::class);
    }

    /**
     * Bootstrap any application services.
     */
    public function boot(): void
    {
        Project::observe(ProjectObserver::class);
        Task::observe(TaskObserver::class);
    }
}
