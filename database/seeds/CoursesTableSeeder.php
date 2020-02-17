<?php

use App\Models\Course;
use App\Models\CourseLevel;
use App\Models\CourseSublevel;
use App\Models\MultipleChoiceAnswer;
use App\Models\Question;
use Illuminate\Database\Seeder;
use Faker\Factory as Faker;

class CoursesTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $faker = Faker::create();

        $titles = ['Matematika', 'Bahasa Inggris', 'Tematik'];

        foreach ($titles as $title) {

            $course = new Course;
            $course->title = $title;
            $course->save();

            for ($i = 0; $i < $faker->numberBetween(5, 15); $i++) {

                $level = new CourseLevel;
                $level->course_id = $course->id;
                $level->title = 'Paket ' . toAlpha($i);
                $level->save();

                for ($j = 1; $j <= $faker->numberBetween(10, 30); $j++) {

                    $sublevel = new CourseSublevel;
                    $sublevel->course_level_id = $level->id;
                    $sublevel->title = $level->title . $j;
                    $sublevel->time = $faker->numberBetween(80, 120);
                    $sublevel->minimum_score = $faker->numberBetween(50, 100);
                    $sublevel->description = $faker->realText($maxNbChars = 200);
                    $sublevel->save();

                    for ($k = 1; $k <= $faker->numberBetween(15, 30); $k++) {

                        $question = new Question;
                        $question->course_sublevel_id = $sublevel->id;
                        $question->number = $k;
                        $question->type = 1;
                        $question->media = null;
                        $question->question = $faker->realText($maxNbChars = 80);
                        $question->save();

                        $choice_count = $faker->numberBetween(3, 5);
                        $choice_correct = $faker->numberBetween(1, $choice_count);
                        for ($l = 1; $l <= $choice_count; $l++) {
                            $answer = new MultipleChoiceAnswer;
                            $answer->question_id = $question->id;
                            $answer->order = $l;
                            $answer->is_correct = ($l == $choice_correct);
                            $answer->answer = $faker->realText($maxNbChars = 30);
                            $answer->save();

                        }
                    }
                }
            }
        }
    }
}
