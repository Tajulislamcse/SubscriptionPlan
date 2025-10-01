@extends('layouts.app')

@section('title', 'Checkout')

@section('content')
<!-- Page Header -->
<h4 class="fw-bold py-3 mb-4">
  <span class="text-muted fw-light">Dashboard /</span> Checkout Page
</h4>

<div class="row mb-5">
  <div class="col-md-12 col-lg-12 mb-3">

    <!-- Item Info -->
    <div class="card mb-4">
      <h5 class="card-header">Item Info</h5>
      <div class="card-body">
        <div class="mb-3 row">
          <label class="col-md-2 col-form-label">Item Name</label>
          <div class="col-md-10">
            <input class="form-control" type="text" value="{{ $plan->name }}" readonly />
          </div>
        </div>
        <div class="mb-3 row">
          <label class="col-md-2 col-form-label">Amount</label>
          <div class="col-md-10">
            <input class="form-control" type="text" value="${{ number_format($plan->price, 2) }}" readonly />
          </div>
        </div>
        <div class="mb-3 row">
          <label class="col-md-2 col-form-label">Total Payable</label>
          <div class="col-md-10">
            <input class="form-control" type="text" value="${{ number_format($plan->price, 2) }}" readonly />
          </div>
        </div>
      </div>
    </div>

    <!-- Billing Info -->
    <div class="card mb-4">
      <h5 class="card-header">Billing Info</h5>
      <div class="card-body">
        <form action="{{ route('checkout.process', $plan->id) }}" method="POST">
          @csrf
            <div class="mb-3 row">
                <label class="col-md-2 col-form-label">Full Name</label>
                <div class="col-md-10">
                    <input class="form-control" type="text" name="full_name"
                        value="{{ old('full_name', auth()->user()->name) }}" required />
                </div>
            </div>

            <div class="mb-3 row">
                <label class="col-md-2 col-form-label">Email</label>
                <div class="col-md-10">
                    <input class="form-control" type="email" name="email"
                        value="{{ old('email', auth()->user()->email) }}" required />
                </div>
            </div>

            <div class="mb-3 row">
                <label class="col-md-2 col-form-label">Phone</label>
                <div class="col-md-10">
                    <input class="form-control" type="tel" name="phone"
                        value="{{ old('phone', auth()->user()->phone ?? '') }}" required />
                </div>
            </div>

            <div class="mb-3 row">
                <label class="col-md-2 col-form-label">Full Address</label>
                <div class="col-md-10">
                    <textarea class="form-control" name="address" required>{{ old('address', auth()->user()->address ?? '') }}</textarea>
                </div>
            </div>

          <div class="col-md-12 col-lg-12">
                  <a href="javascript:void(0)" class="btn btn-primary"><i class="tf-icons bx bx-cart-alt me-1"></i>Buy
                    Now</a>
            </div>
        </form>
      </div>
    </div>

  </div>
</div>
@endsection
