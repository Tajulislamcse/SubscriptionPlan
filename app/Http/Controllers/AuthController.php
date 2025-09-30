<?php

namespace App\Http\Controllers;
use App\Models\User;
use App\Mail\LoginOTPMail;
use Illuminate\Support\Facades\Mail;
use Illuminate\Http\Request;
use App\Models\UserOTP;
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
        if (auth()->check()) {
            return redirect()->route('dashboard');
        }
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
        return redirect('/login')->with('verified', 'Your email has been successfully verified!');
    }
    public function login(Request $request)
    {
        $loginField = filter_var($request->input('email'), FILTER_VALIDATE_EMAIL) ? 'email' : 'name';

            $credentials = [
                $loginField => $request->input('email'),
                'password' => $request->password,
            ];
        if (Auth::attempt($credentials)) {
            $user = User::where($loginField, $request->email)->first();
            if (! $user->hasVerifiedEmail()) {
                return back()->with('error', 'Please verify your email before logging in.');
             }
            $otp = rand(100000, 999999);

            UserOTP::create([
                'user_id' => $user->id,
                'otp' => $otp,
                'expires_at' => now()->addMinutes(5),
            ]);

            Mail::to($user->email)->send(new LoginOTPMail($otp, $user));
            session(['email' => $user->email]);
            return redirect()->route('otp.verify.form');
        }else{
            return back()
            ->withInput($request->only('email'))
            ->with('error', 'Invalid email or password');

        }

    }
    public function verifyOtp(Request $request)
    {
        $request->validate([
            'otp'   => 'required|numeric',
        ]);
        $user = User::where('email', $request->email)->first();
        if (!$user) {
            return back()->with('error', 'User not found.');
        }
        $latestOtp = UserOTP::where('user_id', $user->id)
            ->orderBy('created_at', 'desc')
            ->first();

        if (!$latestOtp) {
            return back()->with('error', 'OTP not found.');
        }

        if ($latestOtp->otp !== $request->otp) {
            return back()->with('error', 'Invalid OTP.');
        }

       if ($latestOtp->expires_at < now()) {
            return back()->with('error', 'OTP has expired.');
        }

        Auth::login($user);

        $latestOtp->delete();

        return redirect()->route('dashboard')->with('success', 'Login successful');
    }
    public function logout(Request $request)
    {
        Auth::logout();
        $request->session()->invalidate();
        $request->session()->regenerateToken();
        return redirect('/login');
    }

}
