<?php

use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Route;

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

function get_user($guard = null)
{
    if ($guard && auth()->guard($guard)->check()){

        return auth()->guard($guard)->user();

    } else if (Auth::check()){

        return Auth::user();

    }

    return null;
}

function toAlpha($num)
{
    return chr(substr("000" . ($num + 65), -3));
}

function reportStatus($status)
{
    switch ($status){
        case 1:
            return 'Running';
        case 2:
            return 'Done';
    }
}

function toTimeFormat(Carbon $time)
{
    if ($time->hour == 0)
        return $time->format('i:s');

    return $time->format('H:i:s');
}

function toTimeStringFormat(Carbon $time)
{
    $hour_string = ($time->hour > 0) ? $time->hour . ' Hour' . (($time->hour > 1) ? 's' : '') : '';
    $minute_string = ($time->minute > 0) ? $time->minute . ' Minute' . (($time->minute > 1) ? 's' : '') : '';
    $second_string = ($time->second > 0) ? $time->second . ' Second' . (($time->second > 1) ? 's' : '') : '';

    return $hour_string . ' ' . $minute_string . ' ' . $second_string;
}

function set_active($uri, $output = 'active')
{
    if (is_array($uri)) {
        foreach ($uri as $u) {
            if (Route::is($u)) {
                return $output;
            }
        }
    } else {
        if (Route::is($uri)) {
            return $output;
        }
    }
}
