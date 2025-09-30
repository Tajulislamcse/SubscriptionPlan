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
        return view('user.dashboard');
    }
}
