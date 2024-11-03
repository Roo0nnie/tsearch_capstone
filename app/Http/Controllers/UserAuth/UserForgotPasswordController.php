<?php

namespace App\Http\Controllers\UserAuth;

use App\Http\Controllers\Controller;
use App\Notifications\CustomResetPassword;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Notification;
use App\Models\Admin;


class UserForgotPasswordController extends Controller
{
    public function showLinkRequestForm()
    {
        return view('auth.passwords.email');
    }

    public function sendResetLinkEmail(Request $request)
    {
        $request->validate(['email' => 'required']);

        // $user_type = '';
        // if (str_starts_with($request->user_code, '21')) {
        //     $user_type = 'users';
        // } elseif (str_starts_with($request->user_code, '20')) {
        //     $user_type = 'faculties';
        // } elseif (str_starts_with($request->user_code, '19')) {
        //     $user_type = 'admins';
        // } elseif (str_starts_with($request->user_code, '09')) {
        //     $user_type = 'guest_account';
        // } else {
        //     return back()->withErrors(['user_code' => 'Invalid user ID format.'])->withInput();
        // }

        // $modelClass = $this->getModelClassForUserType($user_type);

        $user = Admin::where('email', $request->email)->first();

        if (!$user) {
            return back()->withErrors(['email' => 'User not found.'])->withInput();
        }

        $token = app('auth.password.broker')->createToken($user);

        try {
            Notification::send($user, new CustomResetPassword($token, $user->user_code));
            return back()->with(['status' => 'Password reset link sent to your email address.']);
        } catch (\Exception $e) {
            return back()->withErrors(['user_code' => 'Failed to send the password reset link. Please try again.']);
        }
    }

    private function getModelClassForUserType($user_type)
    {
        switch ($user_type) {
            case 'users':
                return \App\Models\User::class;
            case 'faculties':
                return \App\Models\Faculty::class;
            case 'admins':
                return \App\Models\Admin::class;
            case 'guest_account':
                return \App\Models\GuestAccount::class;
            default:
                throw new \Exception('Invalid user type');
        }
    }
}
