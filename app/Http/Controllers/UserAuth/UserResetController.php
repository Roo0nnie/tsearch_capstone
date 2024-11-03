<?php

namespace App\Http\Controllers\UserAuth;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Password;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Auth;

class UserResetController extends Controller
{
    public function showResetForm(Request $request, $token = null)
    {
        return view('auth.passwords.reset')->with([
            'token' => $token,
            'email' => $request->query('email'),
            'user_code' => $request->query('user_code'),
        ]);
    }

    public function reset(Request $request)
    {
        $request->validate([
            'token' => 'required',
            'email' => 'required|email',
            'password' => 'required|confirmed|min:8',
            'user_code' => 'required',
        ]);

        $user_type = '';
        $guard = '';

        if (str_starts_with($request->user_code, '21')) {
            $user_type = 'users';
            $guard = 'user';
        } elseif (str_starts_with($request->user_code, '20')) {
            $user_type = 'faculties';
            $guard = 'faculty';
        } elseif (str_starts_with($request->user_code, '19')) {
            $user_type = 'admins';
            $guard = 'admin';
        } elseif (str_ends_with($request->user_code, '@gmail.com')) {
            $user_type = 'guest_account';
            $guard = 'guest_account';
        } else {
            return back()->withErrors(['user_code' => 'Invalid user ID format.'])->withInput();
        }

        $model = $this->getModelByUserType($user_type);
        $user = $model::where('user_code', $request->user_code)->first();

        if (!$user || $user->email !== $request->email) {
            return back()->withErrors(['email' => 'User not found or email does not match.'])->withInput();
        }

        $status = Password::broker($user_type)->reset(
            $request->only('email', 'password', 'password_confirmation', 'token'),
            function ($user, $password) use ($guard) {
                $user->forceFill([
                    'password' => Hash::make($password),
                ])->save();

                Auth::guard($guard)->login($user);
            }
        );

        return $status === Password::PASSWORD_RESET
            ? redirect($this->getRedirectRoute($guard))->with('status', __($status))
            : back()->withErrors(['email' => [__($status)]]);
    }

    protected function getRedirectRoute($guard)
    {
        switch ($guard) {
            case 'faculty':
                return route('faculty.home');
            case 'user':
                return route('home');
            case 'guest_account':
                return route('guest.account.home');
            case 'admin':
                return route('admin.dashboard');
            default:
                return route('login');
        }
    }

    protected function getModelByUserType($user_type)
    {
        $models = [
            'users' => \App\Models\User::class,
            'faculties' => \App\Models\Faculty::class,
            'admins' => \App\Models\Admin::class,
            'guest_account' => \App\Models\GuestAccount::class,
        ];

        return $models[$user_type] ?? null;
    }
}
