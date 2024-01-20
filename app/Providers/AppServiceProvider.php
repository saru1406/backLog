<?php

namespace App\Providers;

use App\Repositories\ChildTaskRepository;
use App\Repositories\ChildTaskRepositoryInterface;
use App\Repositories\CommentRepository;
use App\Repositories\CommentRepositoryInterface;
use App\Repositories\CompanyRepository;
use App\Repositories\CompanyRepositoryInterface;
use App\Repositories\ContactRepository;
use App\Repositories\ContactRepositoryInterface;
use App\Repositories\GptRepository;
use App\Repositories\GptRepositoryInterface;
use App\Repositories\ProjectRepository;
use App\Repositories\ProjectRepositoryInterface;
use App\Repositories\TaskRepository;
use App\Repositories\TaskRepositoryInterface;
use App\Repositories\TypeRepository;
use App\Repositories\TypeRepositoryInterface;
use App\Repositories\UserRepository;
use App\Repositories\UserRepositoryInterface;
use App\Services\ChildTaskService;
use App\Services\ChildTaskServiceInterface;
use App\Services\CommentService;
use App\Services\CommentServiceInterface;
use App\Services\CompanyService;
use App\Services\CompanyServiceInterface;
use App\Services\ContactService;
use App\Services\ContactServiceInterface;
use App\Services\GoogleService;
use App\Services\GoogleServiceInterface;
use App\Services\ProjectService;
use App\Services\ProjectServiceInterface;
use App\Services\TaskService;
use App\Services\TaskServiceInterface;
use App\Services\TypeService;
use App\Services\TypeServiceInterface;
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

        $this->app->bind(CompanyRepositoryInterface::class, CompanyRepository::class);
        $this->app->bind(CompanyServiceInterface::class, CompanyService::class);

        $this->app->bind(ChildTaskRepositoryInterface::class, ChildTaskRepository::class);
        $this->app->bind(ChildTaskServiceInterface::class, ChildTaskService::class);

        $this->app->bind(GptRepositoryInterface::class, GptRepository::class);

        $this->app->bind(TypeRepositoryInterface::class, TypeRepository::class);
        $this->app->bind(TypeServiceInterface::class, TypeService::class);

        $this->app->bind(GoogleServiceInterface::class, GoogleService::class);

        $this->app->bind(ContactRepositoryInterface::class, ContactRepository::class);
        $this->app->bind(ContactServiceInterface::class, ContactService::class);

        $this->app->bind(CommentRepositoryInterface::class, CommentRepository::class);
        $this->app->bind(CommentServiceInterface::class, CommentService::class);
    }

    /**
     * Bootstrap any application services.
     */
    public function boot(): void
    {
        //
    }
}
