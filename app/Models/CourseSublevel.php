<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class CourseSublevel extends Model
{
    protected $fillable = ['course_level_id', 'title', 'minimum_score', 'time', 'description'];

    public function level()
    {
        return $this->belongsTo(CourseLevel::class, 'course_level_id');
    }
}
