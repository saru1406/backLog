<?php

namespace App\Providers;

use App\Repositories\ProjectRepository;
use App\Repositories\ProjectRepositoryInterface;
use App\Repositories\TaskRepository;
use App\Repositories\TaskRepositoryInterface;
use App\Repositories\UserRepository;
use App\Repositories\UserRepositoryInterface;
use App\Services\ProjectService;
use App\Services\ProjectServiceInterface;
use App\Services\TaskService;
use App\Services\TaskServiceInterface;
use App\Services\UserService;
use App\Services\UserServiceInterface;
use Illuminate\Support\ServiceProvider;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     */
    public function register(): void
    {
        $this->app->bind(ProjectRepositoryInterface::class, ProjectRepository::class);

        $this->app->bind(ProjectServiceInterface::class, ProjectService::class);

        $this->app->bind(TaskRepositoryInterface::class, TaskRepository::class);

        $this->app->bind(TaskServiceInterface::class, TaskService::class);

        $this->app->bind(UserRepositoryInterface::class, UserRepository::class);

        $this->app->bind(UserServiceInterface::class, UserService::class);
    }

    /**
     * Bootstrap any application services.
     */
    public function boot(): void
    {
        //
    }
}
