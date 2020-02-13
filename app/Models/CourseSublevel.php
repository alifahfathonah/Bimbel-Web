<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class CourseSublevel extends Model
{
    public function level()
    {
        return $this->belongsTo(CourseLevel::class, 'course_level_id');
    }
}
