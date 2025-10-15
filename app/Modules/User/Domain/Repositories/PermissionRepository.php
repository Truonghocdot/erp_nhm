<?php

namespace App\Modules\User\Domain\Repositories;

use App\Core\BaseRepository;
use App\Modules\User\Domain\Model\Permission;

class PermissionRepository extends BaseRepository
{
    function model(): Permission
    {
        return new Permission();
    }

    public function pluckPermissionsByRoleId(array $roleIds): array
    {
        return $this->query()->whereHas('roles', function ($query) use ($roleIds) {
            $query->whereIn('id', $roleIds);
        })->pluck('name','code')->toArray();
    }

}
