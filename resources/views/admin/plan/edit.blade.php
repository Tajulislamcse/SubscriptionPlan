@extends('layouts.app')

@section('title', 'Edit Plan')

@section('content')
<div class="container-xxl flex-grow-1 container-p-y">
    <h4 class="fw-bold py-3 mb-4"><span class="text-muted fw-light">Plans /</span> Edit Plan</h4>

    <div class="row">
        <div class="col-md-12">
            <div class="card mb-4">
                <h5 class="card-header">Edit Plan Details</h5>
                <div class="card-body">

                    {{-- Validation Errors --}}
                    @if ($errors->any())
                        <div class="alert alert-danger">
                            <ul class="mb-0">
                                @foreach ($errors->all() as $error)
                                    <li>{{ $error }}</li>
                                @endforeach
                            </ul>
                        </div>
                    @endif

                    {{-- Success Message --}}
                    @if(session('success'))
                        <div class="alert alert-success">
                            {{ session('success') }}
                        </div>
                    @endif

                    <form action="{{ route('admin.plans.update', $plan->id) }}" method="POST" enctype="multipart/form-data">
                        @csrf
                        @method('PUT')

                        {{-- Name --}}
                        <div class="mb-3 row">
                            <label for="name" class="col-md-2 col-form-label">Plan Name</label>
                            <div class="col-md-10">
                                <input type="text" class="form-control" id="name" name="name"
                                    value="{{ old('name', $plan->name) }}" placeholder="Enter plan name" required>
                                @error('name')
                                    <span class="text-danger small">{{ $message }}</span>
                                @enderror
                            </div>
                        </div>

                        {{-- Image --}}
                        <div class="mb-3 row">
                            <label for="image" class="col-md-2 col-form-label">Plan Image</label>
                            <div class="col-md-10">
                                <input type="file" class="form-control" id="image" name="image" accept="image/*">

                                {{-- Preview --}}
                                <div class="mt-2">
                                    <img id="preview-image"
                                         src="{{ $plan->image ? asset('storage/' . $plan->image) : 'https://via.placeholder.com/150' }}"
                                         alt="Plan Image Preview"
                                         class="img-thumbnail"
                                         width="150">
                                </div>

                                @error('image')
                                    <span class="text-danger small">{{ $message }}</span>
                                @enderror
                            </div>
                        </div>

                        {{-- Price --}}
                        <div class="mb-3 row">
                            <label for="price" class="col-md-2 col-form-label">Price ($)</label>
                            <div class="col-md-10">
                                <input type="number" step="0.01" class="form-control" id="price" name="price"
                                    value="{{ old('price', $plan->price) }}" placeholder="Enter plan price" required>
                                @error('price')
                                    <span class="text-danger small">{{ $message }}</span>
                                @enderror
                            </div>
                        </div>

                        {{-- Duration --}}
                        <div class="mb-3 row">
                            <label for="duration_days" class="col-md-2 col-form-label">Duration (Days)</label>
                            <div class="col-md-10">
                                <input type="number" class="form-control" id="duration_days" name="duration_days"
                                    value="{{ old('duration_days', $plan->duration_days) }}" placeholder="Enter duration in days" required>
                                @error('duration_days')
                                    <span class="text-danger small">{{ $message }}</span>
                                @enderror
                            </div>
                        </div>

                        {{-- Data Limit --}}
                        <div class="mb-3 row">
                            <label for="data_limit" class="col-md-2 col-form-label">Data Limit</label>
                            <div class="col-md-10">
                                <input type="number" class="form-control" id="data_limit" name="data_limit"
                                    value="{{ old('data_limit', $plan->data_limit) }}" placeholder="Enter data limit (e.g., 5, 10, 20)" required>
                                @error('data_limit')
                                    <span class="text-danger small">{{ $message }}</span>
                                @enderror
                            </div>
                        </div>

                        {{-- Status --}}
                        <div class="mb-3 row">
                            <label class="col-md-2 col-form-label">Status</label>
                            <div class="col-md-10 d-flex align-items-center">
                                <div class="form-check form-switch">
                                    <input type="hidden" name="is_active" value="0">
                                    <input class="form-check-input" type="checkbox" id="is_active" name="is_active" value="1"
                                        {{ old('is_active', $plan->is_active) ? 'checked' : '' }}>
                                    <label class="form-check-label" for="is_active">Active</label>
                                </div>
                            </div>
                        </div>

                        {{-- Buttons --}}
                        <div class="mt-4">
                            <button type="submit" class="btn btn-primary">Submit</button>
                            <a href="{{ route('admin.plans.index') }}" class="btn btn-outline-secondary">Cancel</a>
                        </div>

                    </form>
                </div>
            </div>
        </div>
    </div>
</div>

{{-- Image Preview Script --}}
@push('scripts')
<script>
    document.getElementById('image').addEventListener('change', function (e) {
        const reader = new FileReader();
        reader.onload = function (e) {
            document.getElementById('preview-image').setAttribute('src', e.target.result);
        };
        reader.readAsDataURL(this.files[0]);
    });
</script>
@endpush
@endsection
