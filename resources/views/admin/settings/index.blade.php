@extends('admin.layouts.app')

@section('title', 'Settings')

@section('content')
<!-- Page Heading -->
<div class="d-flex flex-row justify-content-between align-content-center">
    <h1 class="h3 text-gray-800">@yield('title')</h1>
</div>

<hr class="mt-0 mb-4">

<div class="row">

    @component('components.custom_card', [
        'type' => 'danger',
        'class' => 'col-md-12',
    ])

        <div class="col-12">
            <div class="text-xl font-weight-bold text-danger text-uppercase mb-1">
                <i class="fas fa-skull-crossbones"></i> Danger Zone
            </div>
            <hr>

            <div class="d-block">
                <div class="d-inline-block">
                    <strong>Delete All Student</strong>
                    <p class="m-0">
                        Delete all students and their reports that have been stored in the database.
                    </p>
                </div>
                <a href="#" class="d-inline-block btn btn-danger disabled px-4 float-right"><strong>Delete</strong></a>
            </div>
            <hr>

            <div class="d-block">
                <div class="d-inline-block">
                    <strong>Delete All Teacher</strong>
                    <p class="m-0">
                        Delete all Teachers that have been stored in the database except teachers who have admin access.
                    </p>
                </div>
                <a href="#" class="d-inline-block btn btn-danger disabled px-4 float-right"><strong>Delete</strong></a>
            </div>
            <hr>

            <div class="d-block">
                <div class="d-inline-block">
                    <strong>Delete All Exams</strong>
                    <p class="m-0">
                        Delete all questions and reports that have been stored in the database.
                    </p>
                </div>
                <a href="#" class="d-inline-block btn btn-danger disabled px-4 float-right"><strong>Delete</strong></a>
            </div>
            <hr>

            <div class="d-block">
                <div class="d-inline-block">
                    <strong>Delete All Reports</strong>
                    <p class="m-0">
                        Delete all saved reports in database.
                    </p>
                </div>
                <a href="#" class="d-inline-block btn btn-danger disabled px-4 float-right"><strong>Delete</strong></a>
            </div>
            <hr>

            <div class="d-block">
                <div class="d-inline-block">
                    <strong>Wipe Data</strong>
                    <p class="m-0">
                        Delete all students, teachers, admin, exams, and reports in database.
                    </p>
                </div>
                <a href="#" class="d-inline-block btn btn-danger disabled px-4 float-right"><strong>Wipe</strong></a>
            </div>

        </div>
    @endcomponent
</div>
@endsection
