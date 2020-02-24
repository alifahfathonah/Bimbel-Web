<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class MultipleChoiceAnswer extends Model
{
    protected $fillable = ['question_id', 'order', 'answer', 'is_correct'];
}
