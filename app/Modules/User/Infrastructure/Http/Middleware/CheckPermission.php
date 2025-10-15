<?php

namespace App\Modules\User\Infrastructure\Http\Middleware;

use App\Modules\User\Application\Service\AuthService;
use App\Modules\User\Utils\Constant\RBACPermission;
use App\Modules\User\Utils\UserModuleHelper;
use Closure;
use Illuminate\Http\Request;

class CheckPermission
{
    private AuthService $authService;

    public function __construct(AuthService $authService)
    {
        $this->authService = $authService;
    }

    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next, string $permission)
    {

        $user = $this->authService->getPermissionUser();
        if ($user->isError()){
            return redirect()->route('login');
        }
        try {
            $enumPermission = RBACPermission::from($permission);
        } catch (\Throwable $e) {
            session()->flash('error', "Lỗi Phân quyền không đúng.");
            return redirect()->route('dashboard');
        }
        $permissions = $user->getData()['permissions'];
        if (!UserModuleHelper::checkPermission($permissions, $enumPermission)){
            session()->flash('error', "Bạn không có quyền truy cập.");
            return redirect()->route('dashboard');
        }
        return $next($request);
    }
}
