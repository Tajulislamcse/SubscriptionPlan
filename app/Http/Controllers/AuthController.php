<?php

namespace App\Http\Controllers;
use App\Models\User;
use App\Models\UserOTP;
use App\Mail\LoginOTPMail;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Mail;
use App\Http\Requests\RegisterRequest;
use Illuminate\Auth\Events\Registered;


class AuthController extends Controller
{
      public function showRegisterForm()
    {
        return view('user.register');
    }
   public function register(RegisterRequest $request)
    {
        try {
            DB::beginTransaction();

            $user = User::create([
                'name' => $request->name,
                'email' => $request->email,
                'phone' => $request->phone,
                'password' => Hash::make($request->password),
            ]);

            // This triggers the verification email
            event(new Registered($user));

            DB::commit();

            return back()->with('success', 'Registration successful. Please check your email for verification.');

        } catch (\Throwable $e) {
            DB::rollBack();

            // Log the error for debugging
            Log::error('Registration failed: '.$e->getMessage());

            // Show friendly error message to the user
            return back()->withInput()->with('error','Registration failed. Please try again later.');
        }
    }
    public function showLoginForm()
    {
        if (Auth::check()) {
            return redirect()->route('dashboard');
        }
        return view('user.login');
    }
     public function showAdminLoginForm()
    {
        if (Auth::check()) {
            return redirect()->route('dashboard');
        }
        return view('admin.login');
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
        $request->validate([
            'email' => 'required|string',
            'password' => 'required|string',
        ]);

        $loginField = filter_var($request->input('email'), FILTER_VALIDATE_EMAIL) ? 'email' : 'name';

        $credentials = [
            $loginField => $request->input('email'),
            'password' => $request->password,
        ];

        // check only, but DON'T log in
        if (Auth::validate($credentials)) {
            $user = User::where($loginField, $request->email)->first();

            if (!$user->hasVerifiedEmail()) {
                return back()->with('error', 'Please verify your email before logging in.');
            }

            $otp = rand(100000, 999999);

            UserOTP::create([
                'user_id' => $user->id,
                'otp' => $otp,
                'expires_at' => now()->addMinutes(5),
            ]);

            Mail::to($user->email)->send(new LoginOTPMail($otp, $user));

            // keep only email in session until OTP verified
            session(['email' => $user->email]);

            return redirect()->route('otp.verify.form');
        } else {
            return back()->withInput()->with('error', 'Invalid email or password');
        }
    }

    public function adminLogin(Request $request)
    {
        $request->validate([
            'email' => 'required|string',
            'password' => 'required|string',
        ]);
        $loginField = filter_var($request->input('email'), FILTER_VALIDATE_EMAIL) ? 'email' : 'name';

        $credentials = [
            $loginField => $request->input('email'),
            'password' => $request->password,
        ];

        if (Auth::guard('admin')->attempt($credentials)) {
            return redirect()->route('admin.dashboard');
        }

        return back()
            ->withInput($request->only('email'))
            ->with('error', 'Invalid email or password');
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

        return redirect()->route('dashboard');
    }
    public function logout(Request $request)
    {
      if(Auth::guard('admin')->check()){
            Auth::guard('admin')->logout();
        $request->session()->invalidate();
        $request->session()->regenerateToken();
        return redirect('/admin/login');
        }
        Auth::logout();
        $request->session()->invalidate();
        $request->session()->regenerateToken();
        return redirect('/login');
    }

}
