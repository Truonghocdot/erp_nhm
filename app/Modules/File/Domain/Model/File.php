<?php

namespace App\Modules\File\Domain\Model;

use App\Core\Utils\GenerateId\GenerateIdTimestamp;
use App\Modules\FILE\Utils\Constant\FileType;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class File extends Model
{
    use SoftDeletes, GenerateIdTimestamp;

    protected $fillable = [
        'module_id',
        'type',
        'path',
        'extension',
        'size'
    ];

    public function module()
    {
        return $this->belongsTo(Model::class, 'module_id');
    }
}
