<?php

namespace App\Http\Controllers;

use App\Models\InvalidFaculty;
use App\Models\Faculty;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;

class InvalidFacultyController extends Controller
{
    public function edit(InvalidFaculty $invalidfaculty)
    {
        return view('admin.admin_page.faculty.invalidfacultyEdit', ['invalidfaculty' => $invalidfaculty]);
    }

    // =================== If execute, user can update information ==========================
    public function update(InvalidFaculty $invalidfaculty, Request $request)
    {
        $data = $request->validate([
            'user_code' => 'required|string|max:255|regex:/^20\d{6}$/',
            'name' => 'required|string|max:255',
            'email' => 'required|string|email|max:255',
            'phone' => 'nullable|string|max:255|regex:/^09\d{9}$/',
            'bday' => ['required', 'date'],
        ]);

        $userCodeExists = Faculty::where('user_code', $data['user_code'])
            ->where('id', '!=', $invalidfaculty->id)
            ->exists();
        if ($userCodeExists) {
            $invalidfaculty->update(['user_code' => $data['user_code']]);
            $invalidfaculty->update(['error_message' => 'The user code is already taken.']);
            return back()->withErrors(['user_code' => 'The user code is already taken.']);
        }
        $invalidfaculty->update(['user_code' => $data['user_code']]);

        $emailExists = Faculty::where('email', $data['email'])
            ->where('id', '!=', $invalidfaculty->id)
            ->exists();
        if ($emailExists) {
            $invalidfaculty->update(['email' => $data['email']]);
            $invalidfaculty->update(['error_message' => 'The email is already taken']);
            return back()->withErrors(['email' => 'The email is already taken.']);
        }
        $invalidfaculty->update(['email' => $data['email']]);

        $phone = $data['phone'];

        $phoneExists = $phone !== null && Faculty::where('phone', $phone)
            ->where('id', '!=', $invalidfaculty->id)
            ->exists();
        if ($phoneExists) {
            $invalidfaculty->update(['phone' => $data['phone']]);
            $invalidfaculty->update(['error_message' => 'The phone number is already taken.']);
            return back()->withErrors(['phone' => 'The phone number is already taken.']);
        }
        $invalidfaculty->update(['phone' => $data['phone']]);

        $invalidfaculty->update($data);

        $bdayFormatted = \Carbon\Carbon::createFromFormat('Y-m-d', $data['bday'])->format('Y-m-d');

        $user = Faculty::create([
            'name' => $data['name'],
            'user_code' => $data['user_code'],
            'email' => $data['email'],
            'phone' => $data['phone'],
            'birthday' => $bdayFormatted,
            'password' => Hash::make($bdayFormatted),
        ]);


        if ($user->wasRecentlyCreated) {
            $invalidfaculty->delete();
        } else {

            $invalidfaculty->error_message = 'Error creating user. Please check the details and try again.';
            $invalidfaculty->save();
        }

        return redirect()->route('admin.faculty')->with('success', 'Invalid user updated successfully.');
    }


    // =================== If execute, admin can delete a user ==========================
    public function destroy(InvalidFaculty $invalidfaculty)
{

    $invalidfaculty->delete();

    return redirect()->route('admin.faculty')->with('success', 'Invalid user deleted successfully.');
}
}
