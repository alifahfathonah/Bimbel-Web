<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class CourseLevel extends Model
{
    protected $fillable = ['title', 'course_id'];

    public function course()
    {
        return $this->belongsTo(Course::class);
    }

    public function course_sublevels()
    {
        return $this->hasMany(CourseSublevel::class);
    }
}

