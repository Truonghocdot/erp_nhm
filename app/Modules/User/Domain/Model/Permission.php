<?php

namespace App\Modules\User\Domain\Model;

use App\Core\Utils\GenerateId\GenerateIdTimestamp;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Permission extends Model
{
    use HasFactory, GenerateIdTimestamp;
    public $timestamps = false;
    public $incrementing = false;

    protected $fillable = [
        'name',
        'code'
    ];

    /**
     * Permission có thể thuộc nhiều Role
     */
    public function roles()
    {
        return $this->belongsToMany(Role::class, 'role_permission');
    }
}
