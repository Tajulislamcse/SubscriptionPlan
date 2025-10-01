@extends('layouts.app')

@section('title', 'Dashboard')

@section('content')
<!-- Data Table Section -->
<div class="row mb-5">
    <div class="col-12">
    <div class="card">
        <h5 class="card-header">User Data</h5>
        <div class="table-responsive text-nowrap">
        <table class="table">
            <thead>
            <tr>
                <th>SL</th>
                <th>Name</th>
                <th>Email</th>
                <th>Plan</th>
                <th>Status</th>
                <th>Actions</th>
            </tr>
            </thead>
            <tbody class="table-border-bottom-0">
            @forelse($users ?? [] as $user)
            <tr>
                <td>{{ $loop->iteration }}</td>
                <td>
                <i class="fab fa-angular fa-lg text-danger"></i>
                <strong>{{ $user->name }}</strong>
                </td>
                <td>{{ $user->email }}</td>
                <td>{{ $user->plan ?? 'N/A' }}</td>
                <td>
                <span class="badge bg-label-{{ $user->email_verified_at ? 'success' : 'warning' }} me-1">
                    {{ $user->email_verified_at ? 'Verified' : 'Unverified' }}
                </span>
                </td>
                <td>
                <div class="dropdown">
                    <button type="button" class="btn p-0 dropdown-toggle hide-arrow" data-bs-toggle="dropdown">
                    <i class="bx bx-dots-vertical-rounded"></i>
                    </button>
                    <div class="dropdown-menu">
                    <a class="dropdown-item" href="#"><i class="bx bx-edit-alt me-1"></i> Edit</a>
                    <a class="dropdown-item" href="#"><i class="bx bx-trash me-1"></i> Delete</a>
                    </div>
                </div>
                </td>
            </tr>
            @empty
            <tr>
                <td colspan="6" class="text-center">No data available</td>
            </tr>
            @endforelse
            </tbody>
        </table>
        </div>

        <!-- ✅ Pagination links -->
        <div class="card-footer d-flex justify-content-center">
        {{ $users->links() }}
        </div>

    </div>
    </div>
</div>
@endsection
