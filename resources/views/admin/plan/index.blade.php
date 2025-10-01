@extends('layouts.app')

@section('title', 'Plans List')

@section('content')
<!-- Plans Table Section -->
<div class="row mb-5">
    <div class="col-12">
        <div class="card">
            <div class="card-header d-flex justify-content-between align-items-center">
                <h5 class="mb-0">Plans List</h5>
                <a href="{{ route('admin.plans.create') }}" class="btn btn-primary">
                    <i class="bx bx-plus"></i> Add Plan
                </a>
            </div>
           @if(session('success'))
                <div class="alert alert-success m-3">
                    {{ session('success') }}
                </div>
            @endif
            <div class="table-responsive text-nowrap">
                <table class="table">
                    <thead>
                        <tr>
                            <th>SL</th>
                            <th>Name</th>
                            <th>Price</th>
                            <th>Duration (Days)</th>
                            <th>Data Limit</th>
                            <th>Status</th>
                            <th>Actions</th>
                        </tr>
                    </thead>
                    <tbody class="table-border-bottom-0">
                        @forelse($plans ?? [] as $plan)
                        <tr>
                            <td>{{ $plan->id }}</td>
                            <td><strong>{{ $plan->name }}</strong></td>
                            <td>${{ number_format($plan->price, 2) }}</td>
                            <td>{{ $plan->duration_days }}</td>
                            <td>{{ $plan->data_limit }}</td>
                            <td>
                                <span class="badge bg-label-{{ $plan->is_active ? 'success' : 'danger' }}">
                                    {{ $plan->is_active ? 'Active' : 'Inactive' }}
                                </span>
                            </td>
                            <td>
                                <div class="dropdown">
                                    <button type="button" class="btn p-0 dropdown-toggle hide-arrow" data-bs-toggle="dropdown">
                                        <i class="bx bx-dots-vertical-rounded"></i>
                                    </button>
                                    <div class="dropdown-menu">
                                        <a class="dropdown-item" href="{{ route('admin.plans.edit', $plan->id) }}">
                                            <i class="bx bx-edit-alt me-1"></i> Edit
                                        </a>
                                        <form action="{{ route('admin.plans.destroy', $plan->id) }}" method="POST" class="d-inline">
                                            @csrf
                                            @method('DELETE')
                                            <button class="dropdown-item" type="submit" onclick="return confirm('Are you sure?')">
                                                <i class="bx bx-trash me-1"></i> Delete
                                            </button>
                                        </form>
                                    </div>
                                </div>
                            </td>
                        </tr>
                        @empty
                        <tr>
                            <td colspan="7" class="text-center">No plans available</td>
                        </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>

            <!-- Pagination links -->
            <div class="card-footer d-flex justify-content-center">
                {{ $plans->links() }}
            </div>
        </div>
    </div>
</div>
@endsection
