@extends('layouts.app')

@section('title', 'Dashboard')

@section('content')
<div class="row">
    <div class="col-lg-12 mb-4">
        <h4 class="fw-bold py-3 mb-4">Welcome to Dashboard</h4>
        <p>This is your main dashboard content.</p>
    </div>
</div>

<div class="row">
    <!-- Example cards -->
    <div class="col-md-6 col-lg-3 mb-4">
        <div class="card">
            <div class="card-body">
                <h5 class="card-title">Users</h5>
                <p class="card-text">150</p>
            </div>
        </div>
    </div>
    <div class="col-md-6 col-lg-3 mb-4">
        <div class="card">
            <div class="card-body">
                <h5 class="card-title">Orders</h5>
                <p class="card-text">320</p>
            </div>
        </div>
    </div>
    <!-- Add more dashboard widgets here -->
</div>
@endsection
