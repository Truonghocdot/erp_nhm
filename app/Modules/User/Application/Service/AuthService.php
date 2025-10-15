<?php

namespace App\Modules\User\Application\Service;

use App\Core\Utils\Caching;
use App\Core\Utils\Constant\CacheKey;
use App\Core\Utils\Logging;
use App\Core\Utils\ServiceReturn;
use App\Modules\User\Application\DTO\AuthService\LoginDTO;
use App\Modules\User\Domain\Services\PermissionService;
use App\Modules\User\Domain\Services\UserService;
use App\Modules\User\Utils\Constant\RBACPermission;
use App\Modules\User\Utils\UserModuleHelper;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\RateLimiter;
use Psr\SimpleCache\InvalidArgumentException;

class AuthService
{
    private UserService $userService;
    private PermissionService $permissionService;

    public function __construct(UserService $userService, PermissionService $permissionService)
    {
        $this->userService = $userService;
        $this->permissionService = $permissionService;
    }

    public function getMenus(): array
    {
        $res = $this->getPermissionUser();
        if ($res->isError()){
            return [];
        }
        $permissions = $res->getData()['permissions'];
        return [
            [
                'title' => 'Trang chủ',
                'is_menu' => true,
                'url' => route('dashboard'),
                'icon' => 'LayoutDashboard',
                'can_show' => true, // Dashboard mặc định sẽ hiển thị cho mọi người
                'active' => request()->routeIs('dashboard'),
            ],
            [
                'title' => 'Nhân sự',
                'is_menu' => false,
                'can_show' => UserModuleHelper::hasAnyPermission($permissions, [
                    RBACPermission::USER_LIST,
                    // thêm sau
                ]),
            ],
            [
                'title' => 'Quản lý nhân sự',
                'is_menu' => true,
                'icon' => 'User',
                'can_show' => UserModuleHelper::hasAnyPermission($permissions, [
                    RBACPermission::USER_LIST,
                    // thêm sau
                ]),
                'active' => request()->routeIs('user.*'),
                'items' => [
                    [
                        'title' => 'Danh sách nhân sự',
                        'url' => route('user.list'),
                        'can_show' => UserModuleHelper::checkPermission($permissions, RBACPermission::USER_LIST),
                        'active' => request()->routeIs('user.list'),
                    ],
                ],
            ],
        ];

    }

    public function rateLimitLogin(): ServiceReturn
    {
        $key = 'login.attempts.' . request()->ip();
        $maxAttempts = 5; // số lần đăng nhập thất bại trong 1 khoảng thời gian
        $decayMinutes = 1; // số phút
        if (RateLimiter::tooManyAttempts($key, $maxAttempts)) {
            $seconds = RateLimiter::availableIn($key);
            Logging::logAction('Đăng nhập thất bại quá nhiều lần');
            return ServiceReturn::returnError(message: 'Email hoặc mật khẩu không đúng. Vui lòng thử lại sau ' . $seconds . ' giây');
        }
        RateLimiter::hit($key, $decayMinutes * 60);
        return ServiceReturn::returnSuccess();
    }

    public function login(LoginDTO $loginDTO): ServiceReturn
    {
        if (Auth::attempt(['email' => $loginDTO->email, 'password' => $loginDTO->password], true)) {
            request()->session()->regenerate();
            Logging::logAction('Nhân viên đăng nhập thành công', ['time' => now()->toDateTimeString()]);
            return ServiceReturn::returnSuccess(message: 'Đăng nhập thành công');
        }
        return ServiceReturn::returnError(message: 'Email hoặc mật khẩu không đúng');
    }

    public function logout(): ServiceReturn
    {
        Auth::logout();
        request()->session()->invalidate();
        request()->session()->regenerateToken();
        Caching::clearAllSessionCache();
        Logging::logAction('Nhân viên đã đăng xuất', ['time' => now()->toDateTimeString()]);
        return ServiceReturn::returnSuccess(message: 'Đăng xuất thành công');
    }

    public function getPermissionUser(): ServiceReturn
    {
        $user = Auth::user();
        if (!$user){
            return ServiceReturn::returnError(message: 'User chưa đăng nhâp');
        }
        // check cache
        try {
            $permissions = Caching::getSessionCache(CacheKey::USER_PERMISSIONS);
        }catch (InvalidArgumentException $e){
            $permissions = null;
        }
        if ($permissions){
            return ServiceReturn::returnSuccess(data: $permissions);
        }
        // get role id
        $role = $this->userService->getRoleUser($user->id);
        if (!$role){
            return ServiceReturn::returnError(message: 'Có lỗi xảy ra');
        }
        if ($role->isEmpty()){
            return ServiceReturn::returnError(message: 'User không có role');
        }
        $roleId = $role->pluck('role_id')->toArray();
        $permissions = $this->permissionService->pluckPermissionsByRoleId($roleId);
        $data = [
            'roles' => $role,
            'permissions' => $permissions,
        ];
        // set cache
        Caching::setSessionCache(CacheKey::USER_PERMISSIONS, $data);

        return ServiceReturn::returnSuccess(data: $data);
    }
}
