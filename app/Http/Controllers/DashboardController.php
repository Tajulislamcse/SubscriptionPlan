<?php

namespace App\Http\Controllers;

use App\Models\User;
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
        if ($user->plans()->exists()) {
            $userPlans = $user->plans()->withPivot('start_date', 'end_date', 'status')->get();
            return view('user.dashboard', compact('userPlans'));
        } else {
            $allPlans = \App\Models\Plan::all();
        }
        return view('user.dashboard', compact('allPlans'));
    }
}
