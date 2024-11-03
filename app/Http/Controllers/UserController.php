<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Models\Admin;
use App\Models\Faculty;
use App\Models\GuestAccount;
use App\Models\LogHistory;
use App\Models\DeletedUsers;
use App\Models\InvalidUser;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Maatwebsite\Excel\Facades\Excel;
use Carbon\Carbon;
use Illuminate\Support\Facades\Validator;
use App\Notifications\CustomPassword;
use Illuminate\Support\Facades\Notification;
use Illuminate\Support\Facades\Auth;


class UserController extends Controller
{
    // =================== If execute, will redirect to admin.admin_page.user.user along with user data ==========================
    public function view()
    {

        $invalidusers = InvalidUser::all();
        $users = User::all();

        if (Auth::guard('superadmin')->check()) {

            return view('superadmin.student.user', compact('users', 'invalidusers'));
        } elseif (Auth::guard('admin')->check()) {

            return view('admin.admin_page.user.user', compact('users', 'invalidusers'));
        } else {

            return redirect()->route('login')->withErrors('Unauthorized access.');
        }
    }

    public function searchUser(Request $request)
    {
        $query = $request->input('query_user');
        $users = User::where('name', 'LIKE', "%{$query}%")
            ->orWhere('email', 'LIKE', "%{$query}%")
            ->orWhere('user_code', 'LIKE', "%{$query}%")
            ->orWhere('phone', 'LIKE', "%{$query}%")
            ->orWhere('birthday', 'LIKE', "%{$query}%")
            ->get();

        return response()->json($users);
    }

    public function searchUserInvalid(Request $request)
    {
        $query = $request->input('query_user_invalid');
        $users = InvalidUser::where('name', 'LIKE', "%{$query}%")
            ->orWhere('email', 'LIKE', "%{$query}%")
            ->orWhere('user_code', 'LIKE', "%{$query}%")
            ->orWhere('phone', 'LIKE', "%{$query}%")
            ->orWhere('birthday', 'LIKE', "%{$query}%")
            ->orWhere('error_message', 'LIKE', "%{$query}%")
            ->get();

        return response()->json($users);
    }

    // =================== If execute, will redirect to admin.admin_page.user.userCreate ==========================
    public function create()
    {
        return view('admin.admin_page.user.userCreate');
    }

    // =================== If execute, will redirect to admin.user along with success message ==========================
    public function store(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'name' => ['required', 'string', 'max:255'],
            'user_code' => ['required', 'string', 'unique:users,user_code', 'regex:/^21\d{6}$/'],
            'email' => ['required', 'string', 'email', 'max:255', 'unique:users,email'],
            'phone' => ['nullable', 'string', 'max:255', 'unique:users,phone', 'regex:/^09\d{9}$/'],
            'bday' => ['required', 'date', 'before_or_equal:' . now()->subYears(18)->format('Y-m-d')],
        ]);

        if ($validator->fails()) {
            return redirect()->back()->withErrors($validator)->withInput();
        }

        $data = $validator->validated();

        $BdayToPass = \Carbon\Carbon::createFromFormat('Y-m-d', $data['bday'])->format('Y-m-d');

        $password = $BdayToPass;

        $user = User::create([
            'name' => $data['name'],
            'user_code' => $data['user_code'],
            'email' => $data['email'],
            'phone' => $data['phone'] ?: null,
            'birthday' => $BdayToPass,
            'password' => Hash::make($password),
        ]);

        return redirect()->route('admin.user')->with('success', 'User created successfully.');


        // try {
        //     $token = app('auth.password.broker')->createToken($user);
        //     Notification::send($user, new CustomPassword($token, $BdayToPass));
        //     return redirect()->route('admin.user')->with('success', 'User created successfully.');
        // } catch (\Exception $e) {
        //     return back()->withErrors(['user_code' => 'Failed to send the User Code. Please try again.']);
        // }
}

    // =================== If execute, will redirect to admin.admin_page.user.userEdit along with user data to edit user ==========================
    public function edit(User $user)
    {
        return view('admin.admin_page.user.userEdit', ['user' => $user]);
    }

    // =================== If execute, user can update information ==========================
    public function update(Request $request, User $user)
    {
        $data = $request->validate([
            'user_code' => 'required|string|max:255|unique:users,user_code,' . $user->id . '|regex:/^21\d{6}$/',
            'name' => 'required|string|max:255',
            'email' => 'required|string|email|max:255|unique:users,email,' . $user->id,
            'bday' => ['required', 'date', 'before_or_equal:' . now()->subYears(18)->format('Y-m-d')],
            'phone' => 'nullable|string|max:255|unique:users,phone,' . $user->id . '|regex:/^09\d{9}$/',
        ]);

        $user->update([
            'user_code' => $data['user_code'],
            'name' => $data['name'],
            'email' => $data['email'] ?? null,
            'phone' => $data['phone'],
            'birthday' => $data['bday'],
        ]);

        return redirect()->route('admin.user')->with('success', 'Student updated successfully.');
    }

    public function generateUserCode($role)
    {
        $beginNumber = '';

        // Set the prefix based on the role
        if ($role == 'Faculty') {
            $beginNumber = '20'; // Faculty user code starts with 20
        } elseif ($role == 'Admin') {
            $beginNumber = '19'; // Admin user code starts with 19
        } elseif ($role == 'GuestAccount') {
            $beginNumber = '21'; // GuestAccount user code starts with 21
        }

        do {
            $randomNumber = mt_rand(100000, 999999);
            $user_code = $beginNumber . $randomNumber;
        } while ($this->userCodeExists($user_code, $role));

        return $user_code;
    }

    public static function userCodeExists($user_code, $role)
    {

        return $role::where('user_code', $user_code)->exists();
    }

    // =================== If execute, admin can delete a user ==========================
    public function destroy(User $user)
    {

        DeletedUsers::create([
            'profile'    => $user->profile ?: null,
            'name'       => $user->name,
            'user_code'  => $user->user_code,
            'email'      => $user->email,
            'phone'      => $user->phone ?: null,
            'birthday'   => $user->birthday ?: null,
            'password'   => $user->password,
            'type'       => $user->type,
            'deleted_time' => now(),
            'delete_by' => auth()->user()->user_code,
            // 'permanent_delete' => now()->addDays(30),
            'permanent_delete' => now()->addSeconds(10),
        ]);

        $user->delete();

        return redirect()->back()->with('success', 'User deleted successfully.');
    }

    public function excelstore(Request $request)
    {
        $path = $request->file('file')->getRealPath();
        $data = Excel::toCollection(null, $path);

        if ($data->isNotEmpty()) {
            $insert_data = [];
            $invalid_users = [];

            $headers = array_map('trim', array_map('strtolower', $data->first()->shift()->toArray()));

            foreach ($data->first() as $row) {
                $row = array_combine($headers, array_map('trim', $row->toArray()));

                if (isset($row['code'], $row['name'], $row['email'], $row['phone'], $row['birthday'])) {
                    try {

                        if (is_numeric($row['birthday'])) {
                            $formattedBirthday = Carbon::instance(\PhpOffice\PhpSpreadsheet\Shared\Date::excelToDateTimeObject($row['birthday']))->format('Y-m-d');
                        } else {
                            $formattedBirthday = Carbon::parse($row['birthday'])->format('Y-m-d');
                        }
                    } catch (\Exception $e) {

                        $invalid_users[] = [
                            'name' => $row['name'] ?? null,
                            'user_code' => $row['code'] ?? null,
                            'email' => $row['email'] ?? null,
                            'phone' => $row['phone'] ?? null,
                            'birthday' => $row['birthday'] ?? null,
                            'error_message' => 'Invalid birthday date format',
                        ];
                        continue;
                    }

                    $insert_data[] = [
                        'name' => $row['name'],
                        'user_code' => $row['code'],
                        'email' => $row['email'],
                        'phone' => $row['phone'],
                        'birthday' => $formattedBirthday,
                    ];
                } else {

                    $missingFields = [];
                    foreach (['code', 'name', 'email', 'phone', 'birthday'] as $field) {
                        if (!isset($row[$field])) {
                            $missingFields[] = ucfirst($field) . ' is missing';
                        }
                    }
                    $invalid_users[] = [
                        'name' => $row['name'] ?? null,
                        'user_code' => $row['code'] ?? null,
                        'email' => $row['email'] ?? null,
                        'phone' => $row['phone'] ?? null,
                        'birthday' => $row['birthday'] ?? null,
                        'error_message' => implode(', ', $missingFields),
                    ];
                    continue;
                }
            }

            if (!empty($insert_data)) {
                foreach ($insert_data as $data) {

                    $validator = Validator::make($data, [
                        'name' => ['required', 'string', 'max:255'],
                        'user_code' => ['required', 'regex:/^21\d{6}$/'],
                        'email' => ['required', 'string', 'email', 'max:255'],
                        'phone' => ['nullable', 'string', 'max:255', 'regex:/^09\d{9}$/'],
                        'birthday' => ['required', 'date_format:Y-m-d', 'before_or_equal:' . now()->subYears(18)->format('Y-m-d')],
                    ]);

                    $errors = [];


                    if (!preg_match('/^21\d{6}$/', $data['user_code'])) {
                        $errors[] = 'error for user code';
                    }
                    if (User::where('user_code', $data['user_code'])->exists()) {
                        $errors[] = 'duplicate user code';
                    }

                    if (User::where('phone', $data['phone'])->exists()) {
                        $errors[] = 'duplicate phone number';
                    }

                    if (User::where('email', $data['email'])->exists()) {
                        $errors[] = 'duplicate email';
                    }

                    if ($validator->fails() || !empty($errors)) {

                        $validatorErrors = $validator->errors()->all();
                        $combinedErrors = array_merge($errors, $validatorErrors);
                        $invalid_users[] = [
                            'name' => $data['name'] ?? null,
                            'user_code' => $data['user_code'] ?? null,
                            'email' => $data['email'] ?? null,
                            'phone' => $data['phone'] ?? null,
                            'birthday' => $data['birthday'] ?? null,
                            'error_message' => implode(', ', $combinedErrors),
                        ];
                        continue;
                    }

                    $validatedData = $validator->validated();

                    $userData = [
                        'name' => $validatedData['name'],
                        'user_code' => $validatedData['user_code'],
                        'email' => $validatedData['email'],
                        'birthday' => $validatedData['birthday'],
                        'password' => Hash::make($validatedData['birthday']),
                    ];

                    if (!empty($validatedData['phone'])) {
                        $userData['phone'] = $validatedData['phone'];
                    }

                    User::create($userData);
                }

                InvalidUser::insert($invalid_users);

                foreach ($invalid_users as $invalidUser) {
                    $existingInvalidUsers = InvalidUser::where('user_code', $invalidUser['user_code'])->exists();

                    if ($existingInvalidUsers) {

                        $errorMessages = InvalidUser::where('user_code', $invalidUser['user_code'])->pluck('error_message')->toArray();

                        $invalidUser['error_message'] = implode(', ', $errorMessages);

                        InvalidUser::where('user_code', $invalidUser['user_code'])
                                ->update(['error_message' => $invalidUser['error_message']]);
                    }
                }

                $valid_users = count($insert_data) - count($invalid_users);

                return redirect()->route('admin.user')->with('success', $valid_users . ' users added successfully. ' . count($invalid_users) . ' invalid entries.');
            }
        }

        return back()->with('error', 'No data to insert. ' . count($invalid_users) . ' invalid entries.');
    }
}
