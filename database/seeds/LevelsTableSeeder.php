<?php

use Illuminate\Database\Seeder;

class LevelsTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::insert("INSERT INTO `course_levels`
            (`title`,`course_id`) VALUES
            ('Paket A',	'1'),
            ('Paket B',	'1'),
            ('Paket C',	'1'),
            ('Paket D',	'1');
        ");
    }
}
