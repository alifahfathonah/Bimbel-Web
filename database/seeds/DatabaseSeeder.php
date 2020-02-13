<?php

use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     *
     * @return void
     */
    public function run()
    {
        $this->call(StudentsTableSeeder::class);
        $this->call(CoursesTableSeeder::class);
        $this->call(RolesTableSeeder::class);
        $this->call(ReportsTableSeeder::class);
        $this->call(UsersTableSeeder::class);
    }
}
