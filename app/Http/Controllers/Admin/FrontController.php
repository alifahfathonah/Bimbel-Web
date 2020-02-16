<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\CourseSublevel;
use App\Models\Report;
use App\Models\Student;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class FrontController extends Controller
{
    public function dashboard()
    {
        $user_count = User::count();
        $student_count = Student::count();
        $report_count = Report::count();
        $exam_count = CourseSublevel::count();

        $chart_data[0] = DB::table('reports')
                        ->join('course_sublevels', 'course_sublevel_id', '=', 'course_sublevels.id')
                        ->whereColumn('reports.score', '>=', 'course_sublevels.minimum_score')
                        ->count();
        $chart_data[1] = $report_count - $chart_data[0];

        $today = Carbon::today();
        $now = Carbon::now();

        $reports_today = Report::with(['sublevel', 'student'])->whereBetween('created_at', [$today, $now])->get();

        return view('admin.dashboard', compact(
            'user_count',
            'student_count',
            'report_count',
            'exam_count',
            'chart_data',
            'reports_today',
        ));
    }

    public function profile()
    {
        $user = Auth::user();
        return view('admin.profile', compact('user'));
    }
}
