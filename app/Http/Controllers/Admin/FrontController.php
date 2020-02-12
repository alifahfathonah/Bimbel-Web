<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\CourseSublevel;
use App\Models\Report;
use App\Models\Student;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class FrontController extends Controller
{
    public function dashboard()
    {
        $user_count = User::count();
        $student_count = Student::count();
        $report_count = Report::count();
        $exam_count = CourseSublevel::count();

        return view('admin.dashboard', compact(
            'user_count',
            'student_count',
            'report_count',
            'exam_count'
        ));
    }

    public function profile()
    {
        $user = Auth::user();
        return view('admin.profile', compact('user'));
    }
}
