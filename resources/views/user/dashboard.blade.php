@extends('layouts.app')

@section('title', 'Dashboard')

@section('content')
<!-- Data Table Section -->
 <h4 class="fw-bold py-3 mb-4"><span class="text-muted fw-light">Dashboard</h4>
@if(isset($allPlans) && $allPlans->isNotEmpty())
    <div class="row mb-5">
        @foreach($allPlans as $plan)
        <div class="col-md-6 col-lg-4 mb-3">
            <div class="card h-100">
                <img class="card-img-top"
                src="{{ $plan->image ? asset('storage/' . $plan->image) : asset('assets/img/elements/2.jpg') }}"
                alt="Card image cap"
                style="width:100%; height:150px; object-fit:cover; border-radius:8px;" />

                <div class="card-body">
                    <h5 class="card-title">{{ $plan->name }} Plan</h5>
                    <p class="card-text">{{ $plan->data_limit }} peoples of data</p>
                    <a href="{{ route('checkout', $plan->id) }}" class="btn btn-outline-primary">
                        <i class="tf-icons bx bx-cart-alt me-1"></i>Subscribe Now
                    </a>
                    <span style="float: right; font-size: 20px; font-weight: 700;">${{ $plan->price }}</span>
                </div>
            </div>
        </div>
        @endforeach
    </div>
@endif
@if(isset($peoples) && $peoples->isNotEmpty())

<div class="row mb-5">
    <div class="col-12">
    <div class="card">
        <h5 class="card-header">Peoples Data</h5>
        <div class="table-responsive text-nowrap">
        <table class="table">
            <thead>
            <tr>
                <th>SL</th>
                <th>Name</th>
                <th>Email</th>
                <th>Phone</th>
            </tr>
            </thead>
            <tbody class="table-border-bottom-0">
            @forelse($peoples ?? [] as $people)
            <tr>
                <td>{{ $loop->iteration }}</td>
                <td>
                <i class="fab fa-angular fa-lg text-danger"></i>
                <strong>{{ $people->name }}</strong>
                </td>
                <td>{{ $people->email }}</td>
                <td>{{ $people->phone }}</td>
            
            </tr>
            @empty
            <tr>
                <td colspan="4" class="text-center">No data available</td>
            </tr>
            @endforelse
            </tbody>
        </table>
        </div>

        

    </div>
    </div>
</div>
@endif
@endsection
