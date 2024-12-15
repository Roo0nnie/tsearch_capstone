<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;
use App\Models\Admin;
use App\Models\SuperAdmin;


class ProfileController extends Controller
{
    public function view($user_code)
    {
        $user_code = decrypt($user_code);

            $credentials = [];
            $guard = '';
            $model = '';

            if (str_starts_with($user_code, '21')) {
                $credentials['user_code'] = $user_code;
                $guard = 'user';
                $model = \App\Models\User::class;
            } elseif (str_starts_with($user_code, '20')) {
                $credentials['user_code'] = $user_code;
                $guard = 'faculty';
                $model = \App\Models\Faculty::class;
            } elseif (str_starts_with($user_code, '19')) {
                $credentials['user_code'] = $user_code;
                $guard = 'admin';
                $model = \App\Models\Admin::class;
            } elseif (str_starts_with($user_code, '09')) {
                $credentials['user_code'] = $user_code;
                $guard = 'guest_account';
                $model = \App\Models\GuestAccount::class;
            } else {
                return back();
            }

            $user = $model::where(key($credentials), $user_code)->first();

            return view('profile.profile', compact('user'));
    }

    public function update($user_code, Request $request)
    {

        $user_code = decrypt($user_code);
        $model = null;
        $profileExtension = null;

        if (str_starts_with($user_code, '21')) {
            $profileExtension = 'user';
            $model = new \App\Models\User;
        } elseif (str_starts_with($user_code, '20')) {
            $profileExtension = 'faculty';
            $model = new \App\Models\Faculty;
        } elseif (str_starts_with($user_code, '19')) {
            $profileExtension = 'admin';
            $model = new \App\Models\Admin;
        } elseif (str_starts_with($user_code, '09')) {
            $profileExtension = 'guest';
            $model = new \App\Models\GuestAccount;
        } else {
            return back()->withErrors(['error' => 'Invalid user_code']);
        }

        $user = $model::where('user_code', $user_code)->firstOrFail();

        $rules = [
            'user_code' => 'required|string|max:255|unique:' . $model->getTable() . ',user_code,' . $user->id,
            'name' => 'required|string|max:255',
            'age' => 'nullable|integer|min:0',
            'gender' => 'nullable|in:male,female,other',
            'email' => 'required|string|email|max:255|unique:' . $model->getTable() . ',email,' . $user->id,
            'phone' => 'nullable|string|max:255|unique:' . $model->getTable() . ',phone,' . $user->id . '|regex:/^09\d{9}$/',
        ];

        if (str_starts_with($user_code, '09')) {
            $rules['birthday'] = 'nullable|date|before_or_equal:' . now()->subYears(12)->format('Y-m-d');
        } else {
            $rules['birthday'] = 'required|date|before_or_equal:' . now()->subYears(12)->format('Y-m-d');
        }

        $data = $request->validate($rules);

        if ($request->hasFile('profile')) {
            $file = $request->file('profile');
            $extension = $file->getClientOriginalExtension();
            $filename = time() . "_" . $data['user_code'] . "." . $extension;


            $profileDirectory = '';
            switch ($profileExtension) {
                case 'user':
                    $profileDirectory = public_path('assets/img/student_profile');
                    break;
                case 'admin':
                    $profileDirectory = public_path('assets/img/admin_profile');
                    break;
                case 'guest':
                    $profileDirectory = public_path('assets/img/guest_profile');
                    break;
                case 'faculty':
                    $profileDirectory = public_path('assets/img/faculty_profile');
                    break;
                case 'superadmin':
                    $profileDirectory = public_path('assets/img/superadmin_profile');
                    break;
                default:
                    return back()->with('error', 'Invalid user type.');
            }

            foreach (glob($profileDirectory . "/*_" . $data['user_code'] . ".*") as $existingFile) {
                if (file_exists($existingFile)) {
                    unlink($existingFile);
                }
            }

            $file->move($profileDirectory, $filename);

            $user->profile = $filename;
        }

        $user->user_code = $data['user_code'];
        $user->name = $data['name'];
        $user->email = $data['email'];
        $user->age = $data['age'] ?: null;
        $user->gender = $data['gender'];
        $user->phone = $data['phone'] ?: null;
        $user->birthday = $data['birthday'] ?: null;

        $user->save();

        return back()->with('success', 'Profile updated successfully.');
    }

    public function updatePassword($user_code, Request $request)
    {

        $request->validate([
            'password' => ['required', 'string', 'min:8', 'confirmed'],
        ]);

        $user_code = decrypt($user_code);

        $model = match (true) {
            str_starts_with($user_code, '21') => \App\Models\User::class,
            str_starts_with($user_code, '20') => \App\Models\Faculty::class,
            str_starts_with($user_code, '19') => \App\Models\Admin::class,
            str_starts_with($user_code, '09') => \App\Models\GuestAccount::class,
            default => null,
        };

        if ($model === null) {
            return back()->withErrors(['error' => 'Invalid user_code']);
        }

        $user = $model::where('user_code', $user_code)->firstOrFail();
        $user->password = $request['password'];

        $user->save();

        return redirect()->back()->with('success', 'Password has been changed');
    }

    public function currPass($user_code, Request $request)
    {

        $user_code = decrypt($user_code);

        if (str_starts_with($user_code, '21')) {
            $model = \App\Models\User::class;
        } elseif (str_starts_with($user_code, '20')) {
            $model = \App\Models\Faculty::class;
        } elseif (str_starts_with($user_code, '19')) {
            $model = \App\Models\Admin::class;
        } elseif (str_starts_with($user_code, '09')) {
            $model = \App\Models\GuestAccount::class;
        } else {
            return response()->json(['valid' => false, 'error' => 'Invalid user_code']);
        }

        $user = $model::where('user_code', $user_code)->first();

        if (!$user || !Hash::check($request->currPass, $user->password)) {
            return response()->json(['valid' => false]);
        }

        return response()->json(['valid' => true]);
    }

    // Admin profile
    public function adminProfile($admin) {

        $adminId = decrypt($admin);
        $admin = Admin::findOrFail($adminId);
        return view('admin.admin_profile', compact('admin'));
    }

    public function superadminProfile(SuperAdmin $superadmin) {
        return view('superadmin.superadmin_profile', compact('superadmin'));
    }

    public function adminProfileUpdate(Admin $admin, Request $request)
    {

        $model = new Admin();

        $data = $request->validate([
            'user_code' => 'required|string|max:255|unique:' . $model->getTable() . ',user_code,' . $admin->id,
            'name' => 'required|string|max:255',
            'age' => 'nullable|integer|min:0',
            'gender' => 'nullable|in:male,female,other',
            'email' => 'required|string|email|max:255|unique:' . $model->getTable() . ',email,' . $admin->id,
            'phone' => 'nullable|string|max:255|unique:' . $model->getTable() . ',phone,' . $admin->id . '|regex:/^09\d{9}$/',
            'birthday' => 'nullable|date|before_or_equal:' . now()->subYears(12)->format('Y-m-d'),
        ]);

        $admin->user_code = $data['user_code'];
        $admin->name = $data['name'];
        $admin->email = $data['email'];
        $admin->age = $data['age'] ?? null;
        $admin->gender = $data['gender'];
        $admin->phone = $data['phone'] ?? null;
        $admin->birthday = $data['birthday'] ?? null;

        $admin->save();

        return back()->with('success', 'Profile updated successfully.');
    }

    public function superadminProfileUpdate(SuperAdmin $superadmin, Request $request)
    {

        $model = new SuperAdmin();

        $data = $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|string|email|max:255|unique:' . $model->getTable() . ',email,' . $superadmin->id,
        ]);

        $superadmin->name = $data['name'];
        $superadmin->email = $data['email'];
        $superadmin->save();

        return back()->with('success', 'Profile updated successfully.');
    }

    public function adminupdatePassword(Admin $admin, Request $request) {

        $request->validate([
            'password' => [
                'required',
                'string',
                'min:8',
                'regex:/^(?=.*[a-z])(?=.*[A-Z])(?=.*\d)(?=.*[@$!%*?&])[A-Za-z\d@$!%*?&]{8,}$/',
                'confirmed',
            ],
        ]);

        if (Hash::check($request->currpass, $admin->password)) {

            $admin->password = Hash::make($request->password);
            $admin->save();

            return redirect()->back()->with('success', 'Password has been changed');
        } else {
            return back()->withErrors(['currpass' => 'Current password is incorrect.']);
        }

    }

    public function superadminupdatePassword(SuperAdmin $superadmin, Request $request) {

        $request->validate([
            'password' => [
                'required',
                'string',
                'min:8',
                'regex:/^(?=.*[a-z])(?=.*[A-Z])(?=.*\d)(?=.*[@$!%*?&])[A-Za-z\d@$!%*?&]{8,}$/',
                'confirmed',
            ],
        ]);


        if (Hash::check($request->currpass, $superadmin->password)) {

            $superadmin->password = Hash::make($request->password);
            $superadmin->save();

            return redirect()->back()->with('success', 'Password has been changed');
        } else {
            return back()->withErrors(['currpass' => 'Current password is incorrect.']);
        }

    }

    public function profilePicture(Admin $admin,Request $request) {

        if ($request->hasFile('profile')) {
            $file = $request->file('profile');
            $extension = $file->getClientOriginalExtension();
            $filename = time() . "_" . $admin->user_code . "." . $extension;

            $profileDirectory = public_path('assets/img/admin_profile');

            foreach (glob($profileDirectory . "/*_" . $admin->user_code . ".*") as $existingFile) {
                if (file_exists($existingFile)) {
                    unlink($existingFile);
                }
            }

            $file->move($profileDirectory, $filename);

            $admin->profile = $filename;
        }

        $admin->save();

        return back()->with('success', 'Profile Picture successfully updated.');
     }

     public function superadminprofilePicture(SuperAdmin $superadmin, Request $request) {

        if ($request->hasFile('profile')) {
            $file = $request->file('profile');
            $extension = $file->getClientOriginalExtension();
            $filename = time() . "_" . $superadmin->id . "." . $extension;

            $profileDirectory = public_path('assets/img/superadmin_profile');

            foreach (glob($profileDirectory . "/*_" . $superadmin->id . ".*") as $existingFile) {
                if (file_exists($existingFile)) {
                    unlink($existingFile);
                }
            }

            $file->move($profileDirectory, $filename);

            $superadmin->profile = $filename;
        }

        $superadmin->save();

        return back()->with('success', 'Profile Picture successfully updated.');
     }
}
