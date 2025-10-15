<?php

use App\Modules\File\Infrastructure\Http\Controller\FileController;
use App\Modules\User\Utils\Constant\RBACPermission;
use Illuminate\Support\Facades\Route;

Route::middleware(['auth'])->group(function () {
    Route::get('file/{id}', [FileController::class, 'show']);

    Route::post('upload', [FileController::class, 'upload']);
});
