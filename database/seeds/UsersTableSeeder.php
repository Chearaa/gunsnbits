<?php

use Illuminate\Database\Seeder;
use App\User;

class UsersTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $user = new User([
            'id' => 1,
            'name' => 'Chearaa',
            'email' => 'chearaa@googlemail.com',
            'password' => bcrypt('123')
        ]);
        $user->save();
    }
}
