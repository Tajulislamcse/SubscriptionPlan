<?php

namespace App\Http\Controllers;
use App\Models\User;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Auth;
use Illuminate\Auth\Events\Registered;
use App\Http\Requests\RegisterRequest;


class AuthController extends Controller
{
      public function showRegisterForm()
    {
        return view('auth.register');
    }
    public function register(RegisterRequest $request)
    {
 
        $user = User::create([
        'name' => $request->name,
        'email' => $request->email,
        'phone' => $request->phone,
        'password' => Hash::make($request->password),
        ]);

        event(new Registered($user)); // send verification mail

        return back()->with('success', 'Registration successful. Please check your email for verification.');
    }
    public function showLoginForm()
    {
    
        return view('auth.login');
    }
    public function emailVerify($id, $hash)
    {
        $user = User::findOrFail($id);
        if (! hash_equals(sha1($user->getEmailForVerification()), $hash)) {
            abort(403);
        }
        if (! $user->hasVerifiedEmail()) {
            $user->markEmailAsVerified();
        }
        return redirect('/login')->with('verified', true);
    }

}
