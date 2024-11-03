<?php

namespace App\Http\Controllers\AdminAuth;

use App\Http\Controllers\Controller;
use App\Models\Admin;
use App\Models\LogHistory;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;

class AdminLoginController extends Controller
{


    public function landingPage()
    {
        // if (Auth::guard('admin')->check() || Auth::check()) {
        //     Auth::guard('admin')->logout();
        //     Auth::logout();
        //     return view('welcome')->with('message', 'You have been logged out due to re-login attempt.');
        // }

        return view('welcome');
    }

    public function showLoginForm()
    {
        if (Auth::guard('admin')->check()) {
            Auth::guard('admin')->logout();

            return redirect()->to('admin/login')->with('message', 'You have been logged out due to re-login attempt.');
        }

        return view('admin.auth.login');
    }

    // public function login(Request $request)
    // {

    //     $request->validate([
    //         'user_id' => 'required',
    //         'password' => 'required|min:6',
    //     ]);

    //     $errors = [];

    //     $user = Admin::where('admin_id', $request->user_id)->first();

    //     if (!$user) {
    //         $errors['user_id'] = trans('auth.failed_user_id');
    //     } else {

    //         if (!Hash::check($request->password, $user->password)) {
    //             $errors['password'] = trans('auth.failed_password');
    //         } else {

    //             if (Auth::guard('admin')->attempt(['admin_id' => $request->user_id, 'password' => $request->password], $request->remember)) {

    //                 // $this->deleteOtherSessions($user);
    //                 $request->session()->regenerate();

    //                 return redirect()->intended(route('admin.dashboard'));
    //             }

    //             $errors['user_id'] = trans('auth.failed_user_id');
    //         }
    //     }

    //     if (!empty($errors)) {
    //         return back()->withErrors($errors)->withInput();
    //     }
    // }

    // protected function deleteOtherSessions(Admin $user)
    // {
    //     DB::table('sessions')
    //         ->where('user_id', $user->admin_id)
    //         ->delete();
    // }

    public function logout()
    {
        $user = Auth::guard('admin')->user();

        if (!$user) {
            return redirect()->route('login')->with('error', 'Please log in to continue.');
        }

        $logHistoryCount = LogHistory::where('user_code', $user->user_code)
        ->whereNull('logout')
        ->count();

        if ($logHistoryCount > 1) {
            Admin::where('user_code', $user->user_code)->update(['status' => 'active']);
        } else {
            Admin::where('user_code', $user->user_code)->update(['status' => 'inactive']);
        }

        Auth::guard('admin')->logout();

        request()->session()->invalidate();
        request()->session()->regenerateToken();

        return redirect('/')->with('success', 'You have been logged out.');
    }

    public function verifyEmail($user_code) {

        $user = Admin::where('user_code', $user_code)->first();

        if ($user) {

            $user->status = 'active';
            $user->save();

            return redirect()->route('admin.dashboard')->with('success', 'Email verified successfully!');
        }

        return redirect()->route('login')->with('error', 'Invalid verification link.');
    }
}
