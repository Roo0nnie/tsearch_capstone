<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\User;
use App\Models\Admin;
use App\Models\Imrad;
use App\Models\GuestAccount;
use App\Models\LogHistory;
use App\Models\Announcement;
use App\Models\DeletedUsers;
use App\Models\InvalidAdmin;
use Illuminate\Support\Facades\Hash;
use Maatwebsite\Excel\Facades\Excel;
use Carbon\Carbon;
use Illuminate\Support\Facades\Validator;
use App\Notifications\CustomUserCodePassword;
use Illuminate\Support\Facades\Notification;

class SuperAdminController extends Controller
{

    public function verify_code(Request $request)
    {
        $request->validate([
            'verification_code' => 'required|numeric|digits:6',
        ]);

        $superadmin = Auth::guard('superadmin')->user();

        if (!$superadmin) {
            return redirect()->route('landing.page')->with('error', 'You must be logged in as a superadmin');
        }

        if ($superadmin->verification_code == $request->verification_code) {
            if(now()->isBefore($superadmin->verification_code_expires_at)) {
                $superadmin->verification_code = null;
                $superadmin->verification_code_expires_at = null;
                $superadmin->save();

                Auth::guard('superadmin')->login($superadmin);

                return redirect()->route('superadmin.super_dashboard')->with('message', 'Verification successful!');
            }else {
                $superadmin->verification_code = null;
                $superadmin->verification_code_expires_at = null;
                $superadmin->save();
                Auth::guard('superadmin')->logout();
                return back()->withErrors(['verification_code' => 'The verification code has expired.']);
            }
        } else {
            return back()->withErrors(['verification_code' => 'Invalid verification code. Please try again.']);
        }
    }

    public function showVerifyForm() {
        return view('superadmin.verify');
    }

    public function dashboard() {
        $imrads = Imrad::all();
        $users = GuestAccount::all();

        $logusers = LogHistory::where('login', '>=', now()->subDays(7))->get();
        $announcements = Announcement::all();

        return view('superadmin.super_dashboard', compact('imrads','users', 'logusers', 'announcements'));
    }

    public function logout() {
        Auth::guard('superadmin')->logout();
        return redirect()->route('landing.page');
    }

    public function trashview() {
        $admins = Admin::all();
        return view('superadmin.trash-bin.superadmin_trash-bin', compact('admins'));

    }


public function recover(Admin $admin) {

    $admin->update([
        'action' => null,
        'deleted_time' => null,
        'delete_by' => null,
        'permanent_delete' => null,
    ]);
    return redirect()->route('superadmin.trash')->with('success', 'User recovered successfully.');
}
}
