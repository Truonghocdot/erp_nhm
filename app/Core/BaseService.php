<?php

namespace App\Core;

abstract class BaseService
{
    protected  $repository;

    public function __construct(BaseRepository $repository)
    {
        $this->repository = $repository;
    }


}
