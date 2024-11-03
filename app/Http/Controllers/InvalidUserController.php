<?php

namespace App\Http\Controllers;

use App\Models\InvalidUser;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;

class InvalidUserController extends Controller
{
    public function edit(InvalidUser $invaliduser)
    {
        return view('admin.admin_page.user.invaliduserEdit', ['invaliduser' => $invaliduser]);
    }

    // =================== If execute, user can update information ==========================
    public function update(InvalidUser $invaliduser, Request $request)
    {

        $data = $request->validate([
            'user_code' => 'required|string|max:255|regex:/^21\d{6}$/',
            'name' => 'required|string|max:255',
            'email' => 'required|string|email|max:255',
            'phone' => 'nullable|string|max:255|regex:/^09\d{9}$/',
            'bday' => ['required', 'date'],
        ]);

        $userCodeExists = User::where('user_code', $data['user_code'])
            ->where('id', '!=', $invaliduser->id)
            ->exists();
        if ($userCodeExists) {
            $invaliduser->update(['user_code' => $data['user_code']]);
            $invaliduser->update(['error_message' => 'The user code is already taken.']);
            return back()->withErrors(['user_code' => 'The user code is already taken.']);
        }
        $invaliduser->update(['user_code' => $data['user_code']]);

        $emailExists = User::where('email', $data['email'])
            ->where('id', '!=', $invaliduser->id)
            ->exists();
        if ($emailExists) {
            $invaliduser->update(['email' => $data['email']]);
            $invaliduser->update(['error_message' => 'The email is already taken']);
            return back()->withErrors(['email' => 'The email is already taken.']);
        }
        $invaliduser->update(['email' => $data['email']]);

        $phone = $data['phone'];

        $phoneExists = $phone !== null && User::where('phone', $phone)
            ->where('id', '!=', $invaliduser->id)
            ->exists();
        if ($phoneExists) {
            $invaliduser->update(['phone' => $data['phone']]);
            $invaliduser->update(['error_message' => 'The phone number is already taken.']);
            return back()->withErrors(['phone' => 'The phone number is already taken.']);
        }
        $invaliduser->update(['phone' => $data['phone']]);

        $invaliduser->update($data);

        $bdayFormatted = \Carbon\Carbon::createFromFormat('Y-m-d', $data['bday'])->format('Y-m-d');

        $user = User::create([
            'name' => $data['name'],
            'user_code' => $data['user_code'],
            'email' => $data['email'],
            'phone' => $data['phone'],
            'birthday' => $bdayFormatted,
            'password' => Hash::make($bdayFormatted),
        ]);


        if ($user->wasRecentlyCreated) {
            $invaliduser->delete();
        } else {

            $invaliduser->error_message = 'Error creating user. Please check the details and try again.';
            $invaliduser->save();
        }

        return redirect()->route('admin.user')->with('success', 'Invalid user updated successfully.');
    }


    // =================== If execute, admin can delete a user ==========================
    public function destroy(InvalidUser $invaliduser)
    {

        $invaliduser->delete();

        return redirect()->route('admin.user')->with('success', 'invaliduser deleted successfully.');
    }
}
