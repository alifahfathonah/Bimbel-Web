@extends('admin.layouts.main')

@section('title', 'Reports')

@section('content')

    <!-- Page Heading -->
    <div class="row">
        <h2 class="ml-3 text-gray-800">@yield('title')</h2>
    </div>

    <div class="row">
        <table class="table table-light">
            <thead class="thead-light">
                <tr>
                    <th>Student Name</th>
                    <th>Course</th>
                    <th>Start Time</th>
                    <th>Time Spent</th>
                    <th>Status</th>
                    <th>Score</th>
                    <th>Action</th>
                </tr>
            </thead>
            <tbody>
                @foreach ($reports as $report)
                    <tr>
                        <td>{{ $report['student']['name'] }}</td>
                        <td>{{ $report['sublevel']['title'] }}</td>
                        <td>{{ toCarbon($report['created_at'])->toDayDateTimeString() }}</td>
                        <td>
                            @if ($report['status'] == 2)
                            {{ getTimeSpent($report->created_at, $report->finish_time)->format('H:i:s') }}
                            @endif
                        </td>
                        <td>
                            {{ $report['status'] }}
                        </td>
                        <td>
                            @if ($report['status'] == 2)
                            {{ $report['score'] }}
                            @else
                            ~
                            @endif
                        </td>
                        <td>
                            <a href="#" class="btn btn-primary disabled">Edit</a>
                            <a href="#" class="btn btn-danger {{ ($report->id == 1) ? 'disabled' : 'disabled' }}">Delete</a>
                        </td>
                    </tr>
                @endforeach
            </tbody>
        </table>
    </div>

@endsection

