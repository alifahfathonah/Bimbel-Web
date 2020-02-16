<?php

use App\Models\User;
use Illuminate\Database\Seeder;
use Faker\Factory as Faker;

class UsersTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $faker = Faker::create();

        $user = new User;
        $user->name = 'Administrator';
        $user->email = 'admin@manggis.com';
        $user->username = 'admin';
        $user->password = bcrypt('admin');
        $user->role = 1;
        $user->save();

        for ($i = 1; $i < $faker->numberBetween(10, 25); $i++) {
            $user = new User;
            $user->name = $faker->name;
            $user->email = $faker->freeEmail;
            $user->username = $faker->userName;
            $user->password = bcrypt('admin');
            $user->role = $faker->numberBetween($min = 2, $max = 3);
            $user->save();
        }
    }
}
