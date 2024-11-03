<?php

namespace App\Http\Controllers\UserAuth;

use App\Http\Controllers\Controller;
use App\Models\Faculty;
use App\Models\GuestAccount;
use App\Models\LogHistory;
use App\Models\User;
use App\Models\Admin;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Str;
use Illuminate\Foundation\Auth\ThrottlesLogins;
use Illuminate\Http\Exceptions\ThrottleRequestsException;
use Illuminate\Support\Facades\RateLimiter;
use Carbon\Carbon;
use App\Notifications\SuperAdminVerification;
use App\Notifications\AdminVerification;
use Illuminate\Support\Facades\Notification;

class UserLoginController extends Controller
{
    use ThrottlesLogins;

    // protected $maxAttempts = 5;
    protected $decayMinutes = 1;


    protected function hasTooManyLoginAttempts(Request $request)
    {
        return RateLimiter::tooManyAttempts($this->throttleKey($request), $this->maxAttempts());
    }

    protected function throttleKey(Request $request)
    {
        return Str::lower($request->input('email')) . '|' . $request->ip();
    }

    protected function maxAttempts()
    {
        return 3;
    }


    protected function sendLockoutResponse($request)
    {
        $seconds = RateLimiter::availableIn($this->throttleKey($request));

        return back()->with('secondsRemaining', $seconds);
    }

    public function alreadyLoggedIn()
    {
        return view('alreadyLoggedIn');
    }

    public function landingPage()
    {
        //Show the landing page of the user
        // if (Auth::check()) {
        //     $user = Auth::user();
        //     return view('alreadyLoggedIn', ['user' => $user]);
        // }
        return view('welcome');
    }

    public function showLoginForm($userType)
    {
        // Show the login form of the user
        // if (Auth::check()) {
        //     Auth::logout();
        //     return redirect()->route('login')->with('message', 'You have been logged out due to re-login attempt.');
        // }
        return view('auth.login', ['userType' => $userType]);
    }

    public function login(Request $request, $userType)
    {
        $request->validate([
            'email' => 'required|email',
            'password' => 'required|min:6',
        ]);

        if ($this->hasTooManyLoginAttempts($request)) {
            return $this->sendLockoutResponse($request);
        }

        if ($userType === 'superadmin') {
            $credentials = $request->only('email', 'password');

            if (Auth::guard('superadmin')->attempt($credentials)) {
                return $this->handleSuperadminLogin(Auth::guard('superadmin')->user());
            }

            return $this->loginFailedResponse($request);
        }

        if ($userType === 'admin') {
            $credentials = $request->only('email', 'password');

            if (Auth::guard('admin')->attempt($credentials)) {
                return $this->handleAdminLogin(Auth::guard('admin')->user());
            }

            $this->incrementLoginAttempts($request);
            return $this->loginFailedResponse($request);
        }

        return back()->withErrors(['email' => 'Invalid user type or credentials.'])->withInput();
    }

    protected function handleSuperadminLogin($superAdmin)
    {
        $verificationCode = rand(100000, 999999);

        $superAdmin->verification_code = $verificationCode;
        $superAdmin->verification_code_expires_at = now()->addMinutes(1);
        $superAdmin->save();

        try {
            Notification::send($superAdmin, new SuperAdminVerification(
                app('auth.password.broker')->createToken($superAdmin),
                $verificationCode
            ));

            return redirect()->route('superadmin.verify')
                ->with('success', 'Check your email for the verification code.');
        } catch (\Exception $e) {
            return back()->withErrors(['email' => 'Failed to send the verification code. Please try again.']);
        }
    }

    protected function handleAdminLogin($admin)
    {
        if ($admin->action === 'deleted') {
            Auth::guard('admin')->logout();
            return back()->withErrors(['email' => 'Your account has been deleted, Cannot login.']);
        } else {
            $verificationCode = rand(100000, 999999);
            $admin->verification_code = $verificationCode;
            $admin->verification_code_expires_at = now()->addMinutes(3);
            $admin->save();

            try {
                Notification::send($admin, new AdminVerification(
                    app('auth.password.broker')->createToken($admin),
                    $verificationCode
                ));

                return redirect()->route('admin.verify')
                    ->with('success', 'Check your email for the verification code.');
            } catch (\Exception $e) {

        }
         return back()->withErrors(['email' => 'Failed to send the verification code. Please try again.']);
        }
    }

    protected function loginFailedResponse(Request $request)
    {
        $this->incrementLoginAttempts($request);
        return back()->withErrors(['email' => 'Login failed. Please check your credentials and try again.']);
    }

    protected function manageUserSession(Request $request, $user)
    {
        $request->session()->regenerate();

        if ($request->remember) {
            $user->setRememberToken(Str::random(60));
            $user->save();
        }

        $user->update(['status' => 'online']);
        $this->clearLoginAttempts($request);
    }

    protected function sendSecurityAlert($user)
    {
        Mail::to($user->email)->send(new \App\Mail\SecurityAlertMail([
            'title' => 'Security Alert',
            'body' => 'A new login attempt was made. Confirm if it was you.'
        ], $user));
    }

    protected function deleteOtherSessions($user)
    {
        DB::table('sessions')
            ->where('user_code', $user->user_code)
            ->delete();
    }

    protected function getRedirectRoute($guard)
    {
        return match($guard) {
            'faculty' => route('faculty.home'),
            'user' => route('home'),
            'guest_account' => route('guest.account.home', ['query' => null]),
            'admin' => route('admin.dashboard'),
            default => route('/')
        };
    }

    public function logout()
    {
        $user = Auth::guard('user')->user();

        if (!$user) {
            return redirect()->route('login')->with('error', 'Please log in to continue.');
        }

        $logHistoryCount = LogHistory::where('user_code', $user->user_code)
        ->whereNull('logout')
        ->count();

        if ($logHistoryCount > 1) {
            User::where('user_code', $user->user_code)->update(['status' => 'online']);
        } else {
            User::where('user_code', $user->user_code)->update(['status' => 'offline']);
        }

        Auth::guard('user')->logout();

        request()->session()->invalidate();
        request()->session()->regenerateToken();

        return redirect('/')->with('success', 'You have been logged out.');

    }

    public function verifyEmail($user_code) {

        $user = User::where('user_code', $user_code)->first();

        if ($user) {

            $user->status = 'online';
            $user->save();

            return redirect()->route('home')->with('success', 'Email verified successfully!');
        }

        return redirect()->route('login')->with('error', 'Invalid verification link.');
    }

    public function username()
    {
        return 'user_code';
    }
}
