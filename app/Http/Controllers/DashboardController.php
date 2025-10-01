<?php

namespace App\Http\Controllers;

use App\Models\Plan;
use App\Models\User;
use App\Models\People;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;


class DashboardController extends Controller
{
    public function index()
    {
        if(Auth::guard('admin')->check()){
            $users = User::paginate(10);
            return view('admin.dashboard',compact('users'));
        }
         $user = auth()->user();
        if ($user->activeSubscription()->exists()) {
            $activePlan = $user->activeSubscription->plan;
            $limit = $activePlan->data_limit; 
            $peoples = People::take($limit)->get(); 
            return view('user.dashboard', compact('peoples'));
        } else {
            $allPlans = Plan::where('is_active', 1)->get();
        }
        return view('user.dashboard', compact('allPlans'));
    }
}
