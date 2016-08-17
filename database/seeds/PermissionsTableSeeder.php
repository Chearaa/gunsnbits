<?php

use Illuminate\Database\Seeder;
use App\Permission;
use App\Role;

class PermissionsTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $permission = new Permission([
            'id' => 1,
            'name' => 'can_reserve_stage_seats'
        ]);
        Role::find(1)->permissions()->save($permission);

        $permission = new Permission([
            'id' => 2,
            'name' => 'can_handle_userroles'
        ]);
        Role::find(2)->permissions()->save($permission);

        $permission = new Permission([
            'id' => 3,
            'name' => 'can_handle_userpermissions'
        ]);
        Role::find(2)->permissions()->save($permission);

        $permission = new Permission([
            'id' => 4,
            'name' => 'can_handle_rolepermissions'
        ]);
        Role::find(2)->permissions()->save($permission);
    }
}
