<?php

namespace Database\Seeders;

use App\Modules\User\Domain\Model\Permission;
use App\Modules\User\Domain\Model\Role;
use App\Modules\User\Domain\Model\User;
use App\Modules\User\Utils\Constant\RBACPermission;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;


class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        DB::beginTransaction();
        try {
            $superAdminRole = Role::query()->create([
                'name' => 'Super Admin',
            ]);
            $userRead = Permission::query()->create([
               'code' => RBACPermission::USER_READ->value,
               'name' => RBACPermission::USER_READ->label(),
            ]);
            $superAdminRole->permissions()->attach(
                $userRead->id
            );

            $userCreate = Permission::query()->create([
                'code' => RBACPermission::USER_CREATE->value,
                'name' => RBACPermission::USER_CREATE->label(),
            ]);
            $superAdminRole->permissions()->attach(
                $userCreate->id
            );

            $userUpdate = Permission::query()->create([
                'code' => RBACPermission::USER_UPDATE->value,
                'name' => RBACPermission::USER_UPDATE->label(),
            ]);
            $superAdminRole->permissions()->attach(
                $userUpdate->id
            );

            $userDelete = Permission::query()->create([
                'code' => RBACPermission::USER_DELETE->value,
                'name' => RBACPermission::USER_DELETE->label(),
            ]);
            $superAdminRole->permissions()->attach(
                $userDelete->id
            );
            $userList = Permission::query()->create([
                'code' => RBACPermission::USER_LIST->value,
                'name' => RBACPermission::USER_LIST->label(),
            ]);
            $superAdminRole->permissions()->attach(
                $userList->id
            );


            $user = User::query()->create([
                'name' => 'Super Admin',
                'email' => 'admin@admin.com',
                'password' => bcrypt('test1234567'),
            ]);
            $user->roles()->attach($superAdminRole->id);

            DB::commit();
        } catch (\Exception $exception) {
            DB::rollBack();
            dump($exception->getMessage());
        }
    }
}
