<?php

use Illuminate\Database\Seeder;
use App\Role;
use App\User;

class RolesTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $role = new Role([
            'id' => 1,
            'name' => 'gunsnbits'
        ]);
        User::find(1)->roles()->save($role);

        $role = new Role([
            'id' => 2,
            'name' => 'permissionmanager'
        ]);
        User::find(1)->roles()->save($role);

        $role = new Role([
            'id' => 3,
            'name' => 'lanpartymanager'
        ]);
        User::find(1)->roles()->save($role);

        $role = new Role([
            'id' => 4,
            'name' => 'imagemanager'
        ]);
        User::find(1)->roles()->save($role);

        $role = new Role([
            'id' => 5,
            'name' => 'cateringmanager'
        ]);
        User::find(1)->roles()->save($role);
    }
}
