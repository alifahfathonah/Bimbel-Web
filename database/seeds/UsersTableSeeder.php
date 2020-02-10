<?php

use App\Models\User;
use Illuminate\Database\Seeder;

class UsersTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $user = new User;
        $user->name = 'Administrator';
        $user->email = 'admin@manggis.com';
        $user->username = 'admin';
        $user->password = bcrypt('admin');
        $user->role = 1;
        $user->save();

        $user = new User;
        $user->name = 'Admin';
        $user->email = 'admin1@manggis.com';
        $user->username = 'admin1';
        $user->password = bcrypt('admin1');
        $user->role = 2;
        $user->save();

        $user = new User;
        $user->name = 'Teacher';
        $user->email = 'teacher@manggis.com';
        $user->username = 'teacher';
        $user->password = bcrypt('teacher');
        $user->role = 3;
        $user->save();
    }
}
