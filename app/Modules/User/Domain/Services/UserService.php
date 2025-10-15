<?php

namespace App\Modules\User\Domain\Services;


use App\Core\BaseService;
use App\Core\Utils\Constant\Error\ModuleLog;
use App\Core\Utils\Constant\Error\TypeLog;
use App\Core\Utils\Logging;
use App\Modules\User\Domain\Repositories\UserRepository;
use Illuminate\Database\QueryException;

class UserService extends BaseService
{
    public function __construct(UserRepository $repository)
    {
        parent::__construct($repository);
    }

    public function getRoleUser($user_id)
    {
        try {
            $roles = $this->repository->getRoleUser($user_id);

            $rolesCollection = $roles->get(['id', 'name']);

            return $rolesCollection->map(function ($role) {
                return [
                    'role_id' => $role->id,
                    'role_name' => $role->name,
                ];
            });
        }catch (QueryException $e){
            Logging::logError(ModuleLog::USER, TypeLog::QUERY, '001', ['message' => $e->getMessage()]);
            return false;
        }

    }

}
