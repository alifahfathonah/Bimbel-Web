<?php

use App\Models\CourseSublevel;
use App\Models\Report;
use App\Models\Student;
use Illuminate\Database\Seeder;
use Faker\Factory as Faker;
use Illuminate\Support\Carbon;

class ReportsTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $faker = Faker::create();
        $student_count = Student::count();
        $sublevel_count = CourseSublevel::count();

        for ($i=0; $i < $faker->numberBetween(30, 100); $i++) {
            $date = $faker->dateTimeThisMonth('now', $timezone = 'Asia/Jakarta');
            $time = $faker->numberBetween(10, 80);

            $report = new Report;
            $report->student_id = $faker->numberBetween(1, $student_count);
            $report->course_sublevel_id = $faker->numberBetween(1, $sublevel_count);
            $report->score = $faker->numberBetween(0, 100);
            $report->status = $faker->numberBetween(1, 2);;
            $report->created_at = $date;
            $report->finish_time = $report->status == 2 ? $date->add(new DateInterval('PT' . $time . 'M')) : null;
            $report->save();
        }
    }
}
