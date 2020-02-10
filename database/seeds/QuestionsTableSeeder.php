<?php

use App\Models\MultipleChoiceAnswer;
use App\Models\Question;
use Illuminate\Database\Seeder;
use Faker\Factory as Faker;

class QuestionsTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $faker = Faker::create();
        for ($i = 1; $i <= 20; $i++) {

            $question = new Question;
            $question->course_sublevel_id = 1;
            $question->number = $i;
            $question->type = 1;
            $question->media = null;
            $question->question = $faker->realText($maxNbChars = 80);
            $question->correct_answer = $faker->numberBetween($min = 1, $max = 4);
            $question->save();

            for ($j = 1; $j <= 4; $j++) {
                $answer = new MultipleChoiceAnswer;
                $answer->question_id = $question->id;
                $answer->answer_order = $j;
                $answer->answer = $faker->realText($maxNbChars = 30);
                $answer->save();
            }
        }

    }
}
