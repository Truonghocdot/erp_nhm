<?php

namespace App\Modules\User\Infrastructure;

use App\Modules\User\Application\Service\AuthService;
use App\Modules\User\Domain\Repositories\PermissionRepository;
use App\Modules\User\Domain\Repositories\UserRepository;
use App\Modules\User\Domain\Services\PermissionService;
use App\Modules\User\Domain\Services\UserService;
use App\Modules\User\Infrastructure\Http\Middleware\CheckPermission;
use Illuminate\Support\Facades\Route;
use Illuminate\Support\ServiceProvider;

class Provider extends ServiceProvider
{
    public function register(): void
    {
        $this->registerApplicationService();
        $this->registerRepository();
        $this->registerDomainService();
    }

    public function boot(): void
    {
        Route::aliasMiddleware('check-permission', CheckPermission::class);
    }

    private function registerApplicationService(): void
    {
        $this->app->bind(AuthService::class, AuthService::class);
    }

    private function registerRepository(): void
    {
        $this->app->bind(UserRepository::class, UserRepository::class);
        $this->app->bind(PermissionRepository::class, PermissionRepository::class);
    }

    private function registerDomainService(): void
    {
        $this->app->bind(UserService::class, UserService::class);
        $this->app->bind(PermissionService::class, PermissionService::class);
    }

}
