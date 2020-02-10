@extends('admin.layouts.main')

@section('title', 'Dashboard')

@section('content')

    <!-- Page Heading -->
    <div class="row">
        <h2 class="ml-3 text-gray-800">Dashboard</h2>
    </div>

    Welcome {{ Auth::user()->name }}<br>
    <a href="{{ route('admin.logout') }}">Logout</a>

@endsection

