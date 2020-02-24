<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Course;
use App\Models\CourseLevel;
use App\Models\CourseSublevel;
use App\Models\MarkedQuestion;
use App\Models\MultipleChoiceAnswer;
use App\Models\Question;
use App\Models\Report;
use App\Models\Student;
use App\Models\StudentAnswer;
use App\Models\User;
use Illuminate\Http\Request;

class SettingController extends Controller
{
    /** Show main settings page */
    public function index()
    {
        return view('admin.settings.index');
    }

    public function delete_all(Request $request)
    {
        $this->validate($request, [
            'action' => 'required|string',
        ]);

        switch($request['action']){
            case 'delete_all_students':
                $this->_deleteAllStudent();
                $this->_deleteAllReports();
                break;
            case 'delete_all_teacher':
                $this->_deleteAllTeacher();
                break;
            case 'delete_all_reports':
                $this->_deleteAllReports();
                break;
            case 'delete_all_exams':
                $this->_deleteAllExams();
                $this->_deleteAllReports();
                break;
            case 'wipe_data':
                $this->_deleteAllStudent();
                $this->_deleteAllUser();
                $this->_deleteAllExams();
                $this->_deleteAllReports();
                $this->_createAdminUser();
                break;

        }
        return redirect()->route('admin.settings.index')->with([
            'status'
        ]);
    }




    //Helpers
    private function _createAdminUser()
    {
        $user = new User;
        $user->name = 'Administrator';
        $user->email = 'admin@manggis.com';
        $user->username = 'admin';
        $user->password = bcrypt('admin');
        $user->role = 1;
        $user->save();
    }
    private function _deleteAllStudent()
    {
        Student::truncate();
    }
    private function _deleteAllTeacher()
    {
        User::where('role', 3)->delete();
    }
    private function _deleteAllUser()
    {
        User::truncate();
    }
    private function _deleteAllExams()
    {
        Course::truncate();
        CourseLevel::truncate();
        CourseSublevel::truncate();
        Question::truncate();
        MultipleChoiceAnswer::truncate();
    }
    private function _deleteAllReports()
    {
        Report::truncate();
        StudentAnswer::truncate();
        MarkedQuestion::truncate();
    }
    public function _wipeData()
    {
        $this->_deleteAllStudent();
        $this->_deleteAllUser();
        $this->_deleteAllExams();
        $this->_deleteAllReports();
    }

}
