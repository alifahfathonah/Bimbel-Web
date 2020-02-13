<!-- DataTales Example -->
<div class="card shadow mb-4">
    <div class="card-header py-3">
        <h6 class="m-0 font-weight-bold text-primary">Reports List</h6>
    </div>
    <div class="card-body">

        @component('components.table', [
        'colums' => $colums ?? [ 'Student Name','Course','Start Time','Time Spent','Status','Score','Action']
        ])
        @foreach ($reports as $report)
        <tr>

            @empty($student)
            <td>{{ Arr::get($report, 'student.name') }}</td>
            @endempty

            <td>{{ Arr::get($report, 'sublevel.title') }}</td>
            <td>{{ toCarbon(Arr::get($report, 'created_at'))->isoFormat('ddd, D MMM YYYY') }}</td>
            <td>
                @if ($report['status'] == 2)
                {{ toTimeFormat(getTimeSpent($report['created_at'], $report['finish_time'])) }}
                @else
                -
                @endif
            </td>
            <td>
                <span class="badge badge-pill badge-{{ $report['status'] == 2 ? 'success' : 'warning' }}">
                    {{ reportStatus($report['status']) }}
                </span>
            </td>
            <td>
                @if ($report['score'] >= Arr::get($report, 'sublevel.minimum_score'))
                <b class="text-success">
                    @else
                    <b class="text-danger">
                        @endif
                        {{ $report['score'] }} ({{ getScoreGrade($report['score']) }})
                    </b>
            </td>

            <td>
                <div class="d-flex flex-row justify-content-center align-content-center">
                    <a href="{{ route('admin.reports.show', ['report' => $report['id']]) }}"
                        class="btn btn-primary btn-circle btn-sm mx-1" data-toggle="tooltip" data-placement="bottom"
                        title="Details">
                        <i class="fas fa-info"></i>
                    </a>
                </div>
            </td>
        </tr>
        @endforeach

        @endcomponent

    </div>
</div>
