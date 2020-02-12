<?php

use App\Models\Student;
use Illuminate\Database\Seeder;
use Faker\Factory as Faker;

class StudentsTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $password = bcrypt('admin');

        $faker = Faker::create();

        $student = new Student();
        $student->name = 'Administrator';
        $student->username = 'admin';
        $student->password = bcrypt('admin');
        $student->password_enable = 1;
        $student->save();

        for ($i = 1; $i < 100; $i++) {
            $student = new Student;
            $student->name = $faker->name;
            $student->username = $faker->userName;
            $student->password = bcrypt('admin');
            $student->password_enable = $faker->numberBetween($min = 0, $max = 1);
            $student->save();
        }
    }

}
