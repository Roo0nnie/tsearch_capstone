<?php

namespace App\Http\Controllers;

use App\Models\InvalidAdmin;
use App\Models\Admin;
use Illuminate\Support\Facades\Hash;

use Illuminate\Http\Request;

class InvalidAdminController extends Controller
{
    public function edit(InvalidAdmin $invalidadmin)
    {
        return view('admin.admin_page.admin.invalidadminEdit', ['invalidadmin' => $invalidadmin]);
    }

    // =================== If execute, user can update information ==========================
    public function update(InvalidAdmin $invalidadmin, Request $request)
    {
        // Validate the input data
        $data = $request->validate([
            'user_code' => 'required|string|max:255',
            'name' => 'required|string|max:255',
            'email' => 'required|string|email|max:255',
            'phone' => 'nullable|string|max:255|regex:/^09\d{9}$/',
            'bday' => ['required', 'date'],
            'type' => ['required', 'string'],
            'status' => 'required|string|in:Active,Deactive',
        ]);

        $userCodeExists = Admin::where('user_code', $data['user_code'])
            ->where('id', '!=', $invalidadmin->id)
            ->exists();
        if ($userCodeExists) {
            return back()->withErrors(['user_code' => 'The user code is already taken.']);
        }

        $emailExists = Admin::where('email', $data['email'])
            ->where('id', '!=', $invalidadmin->id)
            ->exists();
        if ($emailExists) {
            return back()->withErrors(['email' => 'The email is already taken.']);
        }

        $phone = $data['phone'];
        $phoneExists = $phone !== null && Admin::where('phone', $phone)
            ->where('id', '!=', $invalidadmin->id)
            ->exists();
        if ($phoneExists) {
            return back()->withErrors(['phone' => 'The phone number is already taken.']);
        }

        $invalidadmin->update($data);

        $bdayFormatted = \Carbon\Carbon::createFromFormat('Y-m-d', $data['bday'])->format('Y-m-d');

        $user = Admin::create([
            'name' => $data['name'],
            'user_code' => $data['user_code'],
            'email' => $data['email'],
            'phone' => $data['phone'],
            'birthday' => $bdayFormatted,
            'password' => Hash::make($bdayFormatted),
            'type' => $data['type'],
            'status' => $data['status'],
        ]);

        // Delete the InvalidUser record if the User was created
        if ($user->wasRecentlyCreated) {
            $invalidadmin->delete();
        } else {
            // Update error message if User was not created
            $invalidadmin->error_message = 'Error creating user. Please check the details and try again.';
            $invalidadmin->save();
        }

        return redirect()->route('admin.admin')->with('success', 'Invalid admin updated successfully.');
    }


    // =================== If execute, admin can delete a user ==========================
    public function destroy(Admin $admin)
    {

        $admin->delete();

       return redirect()->back()->with('success', 'invalid admin deleted successfully.');

        // return redirect()->route('admin.admin')->with('success', 'invalid admin deleted successfully.');
    }
}
