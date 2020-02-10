<?php

use Illuminate\Support\Carbon;

function getScoreGrade($score)
{
    $grades = ['E-', 'E', 'E+', 'D-', 'D', 'D+', 'C-', 'C', 'C+', 'B-', 'B', 'B+', 'A-', 'A', 'A+'];
    $grade_step = (100 / count($grades));
    foreach ($grades as $key => $grade)
    {
        if ($score <= ($grade_step * ($key + 1)))
        {
            return $grade;
        }
    }
    return 'A++';
}

function getTimeSpent($start, $finish)
{
    $start = new Carbon($start);
    $finish = new Carbon($finish);
    return new Carbon($finish->diffInSeconds($start));
}
function toCarbon($datetime)
{
    return new Carbon($datetime);
}
