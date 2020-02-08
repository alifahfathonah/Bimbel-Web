<?php

use Illuminate\Database\Seeder;

class SublevelsTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::insert("INSERT INTO `course_sublevels`
            (`title`,`time`,`minimum_score`,`course_level_id`,`descrption`) VALUES
            ('A1',	'100' , '75', '1', 'Materi Penjumlahan'),
            ('A2',	'120' , '75', '1', 'Materi Pengurangan'),
            ('B1',	'140' , '75', '2', 'Materi Perkalian'),
            ('C1',	'110' , '75', '3', 'Materi Pembagian');
        ");
    }
}
