<?php

namespace App\Modules\User\Utils;

use App\Modules\User\Utils\Constant\RBACPermission;

class UserModuleHelper
{
    public static function checkPermission(array $permissions, RBACPermission $value): bool
    {
        return array_key_exists($value->value, $permissions);
    }
    /**
     * Kiểm tra xem người dùng có ÍT NHẤT MỘT trong các quyền được yêu cầu hay không.
     * @param array $userPermissions Mảng quyền mà người dùng có (Key-Value).
     * @param array<RBACPermission> $permissionsToCheck Mảng các quyền Enum cần kiểm tra.
     * @return bool
     */
    public static function hasAnyPermission(array $userPermissions, array $permissionsToCheck): bool
    {
        foreach ($permissionsToCheck as $permission) {
            $permissionValue = $permission->value;
            // Nếu tìm thấy bất kỳ quyền nào, trả về TRUE ngay lập tức
            if (array_key_exists($permissionValue, $userPermissions)) {
                return true;
            }
        }
        // Nếu lặp qua hết mà không tìm thấy quyền nào, trả về FALSE
        return false;
    }
}
