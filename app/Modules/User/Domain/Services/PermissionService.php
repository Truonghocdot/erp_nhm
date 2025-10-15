<?php

namespace App\Modules\User\Domain\Services;

use App\Core\BaseService;
use App\Modules\User\Domain\Repositories\PermissionRepository;

class PermissionService extends BaseService
{
    public function __construct(PermissionRepository $repository)
    {
        parent::__construct($repository);
    }

    public function pluckPermissionsByRoleId(array $roleIds): array
    {
        return $this->repository->pluckPermissionsByRoleId($roleIds);
    }
}
