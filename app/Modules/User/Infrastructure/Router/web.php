<?php

use App\Modules\User\Infrastructure\Http\Controller\AuthController;
use App\Modules\User\Infrastructure\Http\Controller\DashboardController;
use App\Modules\User\Infrastructure\Http\Controller\UserController;
use App\Modules\User\Utils\Constant\RBACPermission;
use Illuminate\Support\Facades\Route;


Route::middleware(['guest'])->group(function () {
    Route::get('/login', [AuthController::class, 'login'])->name('login');
    Route::post('/login', [AuthController::class, 'handleLogin'])->name('handle');
});

Route::middleware(['auth'])->group(function () {
    Route::get('/', [DashboardController::class, 'index'])->name('dashboard');
    Route::post('/logout', [AuthController::class, 'logout'])->name('logout');
    Route::prefix('users')->group(function () {
        Route::get('/list', [UserController::class, 'list'])
            ->middleware('check-permission:' . RBACPermission::USER_LIST->value)
            ->name('user.list');
    });

});


