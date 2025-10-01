<?php

namespace App\Http\Controllers;

use Stripe\Stripe;
use App\Models\Plan;
use App\Models\Subscription;
use Illuminate\Http\Request;
use Stripe\Checkout\Session as StripeSession;

class CheckoutController extends Controller
{
    public function index(Plan $plan)
    {
        return view('user.checkout', compact('plan'));
    }
public function createCheckoutSession(Request $request)
{
    $plan = Plan::findOrFail($request->plan_id);

    Stripe::setApiKey(config('stripe.secret'));

    $session = StripeSession::create([
        'ui_mode' => 'embedded',
        'line_items' => [[
            'price_data' => [
                'currency' => 'usd',
                'product_data' => [
                    'name' => 'Plan: ' . $plan->name,
                ],
                'unit_amount' => $plan->price * 100,
            ],
            'quantity' => 1,
        ]],
        'mode' => 'payment',
        'customer_email' => $request->email, // email from form
        'metadata' => [
            'plan_id' => $plan->id,
            'full_name' => $request->full_name, // full name from form
            'phone' => $request->phone ?? '',
            'address' => $request->address ?? '',
        ],
        'return_url' => route('thank-you') . '?session_id={CHECKOUT_SESSION_ID}',
    ]);

    return response()->json([
        'clientSecret' => $session->client_secret,
    ]);
}



public function success(Request $request)
{
    $sessionId = $request->query('session_id');

    Stripe::setApiKey(config('stripe.secret'));


    $session = StripeSession::retrieve($sessionId);

    if ($session->payment_status === 'paid') {

        $planId = $session->metadata->plan_id ?? null;
        $user = auth()->user();

        if ($planId && $user) {

            $plan = Plan::find($planId);

            if ($plan) {

                Subscription::where('user_id', $user->id)
                            ->where('status', 'active')
                            ->update(['status' => 'expired']);


                Subscription::create([
                    'user_id' => $user->id,
                    'plan_id' => $plan->id,
                    'starts_at' => now(),
                    'ends_at' => now()->addDays($plan->duration_days),
                    'status' => 'active',
                    'gateway_response' => json_encode($session), // store Stripe session info
                ]);

                return redirect()->route('dashboard')->with('success', "You have successfully subscribed to the {$plan->name} plan.");
            }
        }
    }

    return back()->with('error', 'Payment not completed.');
}
}
