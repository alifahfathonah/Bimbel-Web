<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Course extends Model
{
    public function course_levels()
    {
        return $this->hasMany(CourseLevel::class);
    }
}
