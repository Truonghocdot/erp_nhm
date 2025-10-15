<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\Route;
class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     */
    public function register(): void
    {
        //
    }

    /**
     * Bootstrap any application services.
     */
    public function boot(): void
    {
        $modulesPath = app_path('Modules');

        if(File::exists($modulesPath)){
            $modules = File::directories($modulesPath);
            foreach ($modules as $module) {
                // --- Load web routes ---
                $webRoutes = $module . '/Infrastructure/Router/web.php';
                if (File::exists($webRoutes)) {
                    Route::middleware('web')->group($webRoutes);
                }
                // --- Load API routes ---
                $apiRoutes = $module . '/Infrastructure/Router/api.php';
                if (File::exists($apiRoutes)) {
                    Route::prefix('api')
                        ->middleware('api')
                        ->group($apiRoutes);
                }

            }
        };

    }
}
