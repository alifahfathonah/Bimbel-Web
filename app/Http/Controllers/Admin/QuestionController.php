<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\MultipleChoiceAnswer;
use App\Models\Question;
use Illuminate\Http\Request;
use Illuminate\Support\Arr;
use Illuminate\Validation\Rule;

class QuestionController extends Controller
{
    public function index($sublevel_id)
    {
        $questions = Question::where('course_sublevel_id', $sublevel_id)->with('choices')->get()->toArray();
        return response()->json(['questions' => $questions]);
    }
    public function store(Request $request)
    {
        $this->validate($request, [
            'questions.*.question' => 'required|max:1000',
            'questions.*.number' => 'required|numeric|min:0|max:1000',
            'questions.*.choices.*.answer' => 'required|max:1000',
            'questions.*.choices.*.is_correct' => 'required|boolean',
            'questions.*.choices.*.order' => 'required|numeric|min:0|max:25',
            'course_sublevel_id' => 'required|exists:course_sublevels,id'
        ]);

        $sublevel_id = $request['course_sublevel_id'];
        $old_questions_count = Question::where('course_sublevel_id', $sublevel_id)->count();
        $new_questions_count = count($request['questions']);

        if ($old_questions_count > $new_questions_count){
            $old = Question::where('course_sublevel_id', $sublevel_id)
                    ->whereBetween('number', [$new_questions_count, $old_questions_count])
                    ->delete();
        }
        foreach ($request['questions'] as $new_question) {
            $question = Question::firstOrNew(['course_sublevel_id' => $sublevel_id, 'number' => $new_question['number']]);
            $question->course_sublevel_id = $sublevel_id;
            $question->number = $new_question['number'];
            $question->question = $new_question['question'];
            $question->type = 1;
            $question->media = '';
            $question->save();

            foreach ($new_question['choices'] as $new_choice) {
                $choice = MultipleChoiceAnswer::firstOrNew(['question_id' => $question->id, 'order' => $new_choice['order']]);
                $choice->question_id = $question->id;
                $choice->answer = $new_choice['answer'];
                $choice->order = $new_choice['order'];
                $choice->is_correct = $new_choice['is_correct'];
                $choice->save();
            }
        }

        return $request;
    }

    public function show($id)
    {
        //
    }

    public function update(Request $request, $id)
    {
        //
    }

    public function destroy($id)
    {
        //
    }

    public function validateQuestion($question)
    {
    }

    public function validateChoices($choices)
    {

    }

}
