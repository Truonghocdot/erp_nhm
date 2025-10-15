<?php

namespace App\Modules\File\Domain\Services;


use App\Core\BaseService;
use App\Core\Utils\Constant\Error\ModuleLog;
use App\Core\Utils\Constant\Error\TypeLog;
use App\Core\Utils\Logging;
use App\Core\Utils\ServiceReturn;
use App\Modules\File\Domain\Repositories\FileRepository;
use Illuminate\Database\QueryException;

class FileService extends BaseService
{
    public function __construct(FileRepository $repository)
    {
        parent::__construct($repository);
    }

    public function getDetail($file_id)
    {
        try {

            $file = $this->repository->getFile($file_id);
        } catch (QueryException $e) {
        }
    }
}
