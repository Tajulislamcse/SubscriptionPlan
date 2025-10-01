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
                  <button type="button" class="btn btn-primary" id="payNowBtn"><i class="tf-icons bx bx-cart-alt me-1"></i>Buy
                    Now</button>
            </div>
            <div id="checkout" class="mt-4" style="display: none;">
                <!-- Stripe Embedded Checkout will mount here -->
            </div>
        </form>
      </div>
    </div>

  </div>
</div>
@endsection
@push('scripts')
<script src="https://js.stripe.com/basil/stripe.js"></script>
<script>
    const stripe = Stripe('{{ config('stripe.key') }}');

    document.getElementById('payNowBtn').addEventListener('click', async () => {
        const email = document.querySelector('input[name="email"]').value;
        if (!email) {
            alert('Please enter your email address.');
            return;
        }

        const user_name = document.querySelector('input[name="full_name"]').value;
        const phone = document.querySelector('input[name="phone"]').value;
        const address = document.querySelector('textarea[name="address"]').value;

        document.getElementById('payNowBtn').style.display = 'none';
        document.getElementById('checkout').style.display = 'block';


        const fetchClientSecret = async () => {
            const response = await fetch("/create-checkout-session", {
                method: "POST",
                headers: {
                    "X-CSRF-TOKEN": "{{ csrf_token() }}",
                    "Content-Type": "application/json"
                },
                body: JSON.stringify({
                    plan_id: "{{ $plan->id }}",
                    user_name: user_name,
                    email: email,
                    phone: phone,
                    address: address
                })
            });

            const { clientSecret } = await response.json();
            return clientSecret;
        };

        const checkout = await stripe.initEmbeddedCheckout({
            fetchClientSecret
        });

        checkout.mount("#checkout");
    });
</script>
@endpush
