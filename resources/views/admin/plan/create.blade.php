@extends('layouts.app')

@section('title', 'Create Plan')

@section('content')
<div class="container-xxl flex-grow-1 container-p-y">
    <h4 class="fw-bold py-3 mb-4"><span class="text-muted fw-light">Plans /</span> Create Plan</h4>

    <div class="row">
        <div class="col-md-12">
            <div class="card mb-4">
                <h5 class="card-header">New Plan Details</h5>
                <div class="card-body">
                    @if ($errors->any())
                        <div class="alert alert-danger">
                            <ul class="mb-0">
                                @foreach ($errors->all() as $error)
                                    <li>{{ $error }}</li>
                                @endforeach
                            </ul>
                        </div>
                    @endif
                    @if(session('success'))
                        <div class="alert alert-success">
                            {{ session('success') }}
                        </div>
                    @endif
                    <form action="{{ route('admin.plans.store') }}" method="POST" enctype="multipart/form-data">
                        @csrf

                        <div class="mb-3 row">
                            <label for="name" class="col-md-2 col-form-label">Plan Name</label>
                            <div class="col-md-10">
                                <input type="text" class="form-control" id="name" name="name"
                                    value="{{ old('name') }}" placeholder="Enter plan name" required>
                            </div>
                        </div>

                        <div class="mb-3 row">
                            <label for="image" class="col-md-2 col-form-label">Plan Image</label>
                            <div class="col-md-10">
                                <div class="row">
                                    <div class="col-md-5">
                                        {{-- Default preview placeholder --}}
                                        <img id="plan_preview" src="{{ asset('assets/img/default.png') }}" width="120" class="border rounded">
                                    </div>
                                    <div class="col-md-7">
                                        <button type="button" class="btn btn-info mt-2"
                                                onclick="document.getElementById('image').click();">
                                            <i class="fas fa-upload"></i> Select Image
                                        </button>
                                        <input type="file" accept="image/*" name="image" id="image"
                                               onchange="showImage(event, 'plan_preview')" style="display: none;">

                                        @if($errors->has('image'))
                                            <div class="text-danger mt-2">{{ $errors->first('image') }}</div>
                                        @endif
                                    </div>
                                </div>
                            </div>
                        </div>

                        <div class="mb-3 row">
                            <label for="price" class="col-md-2 col-form-label">Price ($)</label>
                            <div class="col-md-10">
                                <input type="number" step="0.01" class="form-control" id="price" name="price"
                                    value="{{ old('price') }}" placeholder="Enter plan price" required>
                            </div>
                        </div>

                        <div class="mb-3 row">
                            <label for="duration_days" class="col-md-2 col-form-label">Duration (Days)</label>
                            <div class="col-md-10">
                                <input type="number" class="form-control" id="duration_days" name="duration_days"
                                    value="{{ old('duration_days') }}" placeholder="Enter duration in days" required>
                            </div>
                        </div>

                        <div class="mb-3 row">
                            <label for="data_limit" class="col-md-2 col-form-label">Data Limit</label>
                            <div class="col-md-10">
                                <input type="number" class="form-control" id="data_limit" name="data_limit"
                                    value="{{ old('data_limit') }}" placeholder="Enter data limit (e.g., 5, 10, 20)" required>
                            </div>
                        </div>

                        <div class="mb-3 row">
                            <label class="col-md-2 col-form-label">Status</label>
                            <div class="col-md-10 d-flex align-items-center">
                                <div class="form-check form-switch">
                                    <input type="hidden" name="is_active" value="0">
                                    <input class="form-check-input" type="checkbox" id="is_active" name="is_active" value="1"
                                        {{ old('is_active', 1) ? 'checked' : '' }}>
                                    <label class="form-check-label" for="is_active">Active</label>
                                </div>
                            </div>
                        </div>

                        <div class="mt-4">
                            <button type="submit" class="btn btn-primary">
                                Submit
                            </button>
                            <a href="{{ route('admin.plans.index') }}" class="btn btn-outline-secondary">Cancel</a>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection

@push('scripts')
<script>
    var showImage = function(event, targetId) {
        var image = document.getElementById(targetId);
        image.src = URL.createObjectURL(event.target.files[0]);
    };
</script>
@endpush
