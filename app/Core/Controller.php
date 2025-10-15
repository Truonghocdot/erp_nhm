<?php

namespace App\Core;

use App\Core\Utils\AppMenu;
use App\Modules\User\Application\Service\AuthService;
use Illuminate\Support\Facades\Auth;
use Inertia\Inertia;
use Psr\SimpleCache\InvalidArgumentException;

abstract class Controller
{
    protected AuthService $authService;

    public function __construct(AuthService $authService)
    {
        $this->authService = $authService;
    }

    /**
     * @throws InvalidArgumentException
     */
    protected function rendering(string $view, array $data = [], array $breadcrumbs = []): \Inertia\Response
    {
        $permissionResult = $this->authService->getPermissionUser();
        if ($permissionResult->isSuccess()){
            $permission = $permissionResult->getData();
        }else{
            $permission = null;
        }
        $menu = $this->authService->getMenus();
        Inertia::share([
            'breadcrumbs' => $breadcrumbs,
            'auth' => [
                'user' => Auth::check() ? Auth::user() : null,
                'permission' => $permission,
            ],
            'menu' => $menu,
        ]);
        return Inertia::render($view, $data);
    }


}
