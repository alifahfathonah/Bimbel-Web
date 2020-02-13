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

        for ($i=0; $i < 25; $i++) {
            $date = $faker->dateTimeThisYear($max = 'now', $timezone = null);
            $time = $faker->numberBetween($min = 10, $max = 80);

            $report = new Report;
            $report->student_id = $faker->numberBetween($min = 1, $max = $student_count);
            $report->course_sublevel_id = $faker->numberBetween($min = 1, $max = $sublevel_count);
            $report->score = $faker->numberBetween($min = 0, $max = 100);
            $report->status = $faker->numberBetween($min = 1, $max = 2);;
            $report->created_at = $date;
            $report->finish_time = $report->status == 2 ? $date->add(new DateInterval('PT' . $time . 'M')) : null;
            $report->save();
        }
    }
}
