<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Question extends Model
{
    protected $fillable = ['course_sublevel_id', 'question', 'number', 'type', 'media'];

    public function marked()
    {
        return $this->hasOne(MarkedQuestion::class, 'number', 'number');
    }

    public function choices()
    {
        return $this->hasMany(MultipleChoiceAnswer::class);
    }
}
