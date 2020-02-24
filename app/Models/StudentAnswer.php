<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class StudentAnswer extends Model
{
    public function choice()
    {
        return $this->hasOne(MultipleChoiceAnswer::class, 'id', 'multiple_choice_id');
    }
}
