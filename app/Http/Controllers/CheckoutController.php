<?php

namespace App\Http\Controllers;

use App\Models\Plan;
use Illuminate\Http\Request;

class CheckoutController extends Controller
{
    public function index(Plan $plan)
    {
        return view('user.checkout', compact('plan'));
    }
}
