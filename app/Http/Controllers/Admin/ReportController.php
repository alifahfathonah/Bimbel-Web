<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Report;
use Illuminate\Http\Request;

class ReportController extends Controller
{
    /** Display a listing of the resource. */
    public function index()
    {
        $reports = Report::with(['student', 'sublevel'])->get()->toArray();
        return view('admin.reports.index', compact('reports'));
    }

    /** Display the specified resource. */
    public function show($id)
    {
        $report = Report::with(['student', 'sublevel.level.course'])->find($id)->toArray();
        return view('admin.reports.show', compact('report'));
    }

}
