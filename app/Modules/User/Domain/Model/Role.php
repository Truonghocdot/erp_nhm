<?php

namespace App\Modules\User\Domain\Model;

use App\Core\Utils\GenerateId\GenerateIdTimestamp;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Role extends Model
{
    use HasFactory, SoftDeletes, GenerateIdTimestamp;

    public $incrementing = false;
    public $timestamps = false;

    protected $fillable = ['name'];

    /**
     * Role có nhiều Permission (nhiều-nhiều)
     */
    public function permissions()
    {
        return $this->belongsToMany(Permission::class, 'role_permission');
    }

    /**
     * Role có nhiều User (nhiều-nhiều)
     */
    public function users()
    {
        return $this->belongsToMany(User::class, 'user_role');
    }
}
