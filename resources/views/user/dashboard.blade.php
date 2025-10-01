@extends('layouts.app')

@section('title', 'Dashboard')

@section('content')
<!-- Data Table Section -->
 <h4 class="fw-bold py-3 mb-4"><span class="text-muted fw-light">Dashboard</h4>
@if(isset($allPlans))
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
@endsection
