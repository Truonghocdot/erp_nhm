<?php

namespace App\Modules\File\Domain\Repositories;

use App\Core\BaseRepository;
use App\Modules\File\Domain\Model\File;

class FileRepository extends BaseRepository
{
    public function model(): File
    {
        return new File();
    }

    public function getFile($file_id)
    {
        return $this->query()->find($file_id);
    }
}
