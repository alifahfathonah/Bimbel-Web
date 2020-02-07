<?php

use Illuminate\Database\Seeder;

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

        DB::insert("INSERT INTO `students`
            (`id`, `username`, `password`, `password_enable`, `created_at`, `updated_at`) VALUES
            ('1',  'agus', '$password', '1', '2019-12-28 13:25:30', NULL);
        ");
    }

}
