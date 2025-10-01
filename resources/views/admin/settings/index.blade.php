@extends('layouts.app')

@section('title', 'Stripe Settings')

@section('content')
<div class="container-xxl flex-grow-1 container-p-y">
    <h4 class="fw-bold py-3 mb-4"><span class="text-muted fw-light">Settings /</span> Stripe</h4>

    <div class="row">
        <div class="col-md-12">
            <div class="card mb-4">
                <h5 class="card-header">Stripe Payment Settings</h5>
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

                    <form action="{{ route('admin.settings.store') }}" method="POST">
                        @csrf

                        <div class="mb-3 row">
                            <label for="stripe_publishable_key" class="col-md-2 col-form-label">Publishable Key</label>
                            <div class="col-md-10">
                                <input type="text" class="form-control" id="stripe_publishable_key"
                                       name="stripe_publishable_key"
                                       value="{{ old('stripe_publishable_key', config('stripe.key') ?? '') }}"
                                       placeholder="Enter Stripe Publishable Key" required>
                            </div>
                        </div>

                        <div class="mb-3 row">
                            <label for="stripe_secret_key" class="col-md-2 col-form-label">Secret Key</label>
                            <div class="col-md-10">
                                <input type="text" class="form-control" id="stripe_secret_key"
                                       name="stripe_secret_key"
                                       value="{{ old('stripe_secret_key', config('stripe.secret') ?? '') }}"
                                       placeholder="Enter Stripe Secret Key" required>
                            </div>
                        </div>


                        <div class="mt-4">
                            <button type="submit" class="btn btn-primary">
                                Save Settings
                            </button>
                        </div>
                    </form>

                </div>
            </div>
        </div>
    </div>
</div>
@endsection
