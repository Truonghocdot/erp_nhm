<?php

namespace App\Modules\User\Domain\Repositories;

use App\Core\BaseRepository;
use App\Modules\User\Domain\Model\User;

class UserRepository extends BaseRepository
{
    public function model(): User
    {
        return new User();
    }

    public function getRoleUser($user_id)
    {
        return $this->query()->find($user_id)->roles();
    }
}
