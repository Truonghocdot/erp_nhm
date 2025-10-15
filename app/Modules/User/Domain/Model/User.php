<?php

namespace App\Modules\User\Domain\Model;

use App\Core\Utils\GenerateId\GenerateIdTimestamp;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;

class User extends Authenticatable
{
    use HasFactory, Notifiable, SoftDeletes, GenerateIdTimestamp;

    protected $fillable = [
        'email',
        'password',
        'name',
    ];

    protected $hidden = [
        'password',
        'remember_token',
    ];

    protected function casts(): array
    {
        return [
            'password' => 'hashed',
        ];
    }

    /**
     * User có thể thuộc nhiều Role
     */
     public function roles()
    {
        return $this->belongsToMany(Role::class, 'user_role');
    }
}
