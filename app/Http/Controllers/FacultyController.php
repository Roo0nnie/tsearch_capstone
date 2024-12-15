<?php

namespace App\Http\Controllers;

use App\Models\Faculty;
use App\Models\DeletedUsers;
use App\Models\Rating;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Notification;
use App\Notifications\CustomPassword;
use App\Models\InvalidFaculty;
use App\Models\LogHistory;
use Maatwebsite\Excel\Facades\Excel;
use Carbon\Carbon;
use Illuminate\Support\Facades\Validator;

class FacultyController extends Controller
{

    public function view()
    {

        $invalidfaculties = InvalidFaculty::all();
        $faculties = Faculty::all();
        return view('admin.admin_page.faculty.faculty', compact('faculties', 'invalidfaculties'));

    }
    // =================== If execute, will redirect to admin.admin_page.user.userCreate ==========================
    public function create()
    {
        return view('admin.admin_page.faculty.facultyCreate');
    }

    // =================== If execute, will redirect to admin.user along with success message ==========================
    public function store(Request $request)
    {
        $data = $request->validate([
            'name' => ['required', 'string', 'max:255'],
            'user_code' => ['required', 'string', 'unique:faculties,user_code', 'regex:/^20\d{6}$/'],
            'email' => ['required', 'string', 'email', 'max:255', 'unique:faculties,email'],
            'phone' => ['nullable', 'string', 'max:255', 'unique:faculties', 'regex:/^09\d{9}$/'],
            'bday' => ['required', 'date', 'before_or_equal:' . now()->subYears(20)->format('Y-m-d')],
        ]);


        $BdayToPass = \Carbon\Carbon::createFromFormat('Y-m-d', $data['bday'])->format('Y-m-d');

        $password = $BdayToPass;

        $user = Faculty::create([
            'name' => $data['name'],
            'user_code' => $data['user_code'],
            'email' => $data['email'],
            'phone' => $data['phone'] ?: null,
            'birthday' => $data['bday'],
            'password' => Hash::make($password),
        ]);

        return redirect()->route('admin.faculty')->with('success', 'Faculty created successfully.');
        // $token = app('auth.password.broker')->createToken($user);

        // try {
        //     Notification::send($user, new CustomPassword($token, $BdayToPass));
        //     return redirect()->route('admin.faculty')->with('success', 'Faculty created successfully.');
        // } catch (\Exception $e) {
        //     return back()->withErrors(['user_code' => 'Failed to send the Faculty Code. Please try again.']);
        // }
    }

    // =================== If execute, will redirect to admin.admin_page.user.userEdit along with user data to edit user ==========================
    public function edit(Faculty $faculty)
    {
        return view('admin.admin_page.faculty.facultyEdit', ['faculty' => $faculty]);
    }

    // =================== If execute, user can update information ==========================
    public function update(Faculty $faculty, Request $request)
    {
        // input field names must meet the required validation before storing into the database
        $data = $request->validate([
            'user_code' => 'required|string|max:255|unique:faculties,user_code,' . $faculty->id . '|regex:/^20\d{6}$/',
            'name' => 'required|string|max:255',
            'email' => 'required|string|email|max:255|unique:faculties,email,' . $faculty->id,
            'phone' => 'nullable|unique:faculties,phone,' . $faculty->id . '|regex:/^09\d{9}$/',
            'bday' => ['required', 'date', 'before_or_equal:' . now()->subYears(18)->format('Y-m-d')],
        ]);

        $faculty->update([
            'user_code' => $data['user_code'],
            'name' => $data['name'],
            'email' => $data['email'] ?? null,
            'phone' => $data['phone'],
            'birthday' => $data['bday'],
        ]);

        return redirect()->route('admin.faculty')->with('success', 'Faculty updated successfully.');
    }

    // =================== If execute, admin can delete a user ==========================
    public function destroy(Faculty $faculty)
    {
        DeletedUsers::create([
            'profile'    => $faculty->profile ?: null,
            'name'       => $faculty->name,
            'user_code'  => $faculty->user_code,
            'email'      => $faculty->email,
            'phone'      => $faculty->phone ?: null,
            'birthday'   => $faculty->birthday ?: null,
            'password'   => $faculty->password,
            'type'       => $faculty->type,
            'deleted_time' => now(),
            'delete_by' => auth()->user()->user_code,
            // 'permanent_delete' => now()->addDays(30),
            'permanent_delete' => now()->addSeconds(10),
        ]);

        $faculty->delete();

        return redirect()->route('admin.faculty')->with('success', 'Faculty deleted successfully.');

    }


    public function landingPage()
    {
        return view('welcome');
    }

    public function showLoginForm()
    {

        return view('auth.login');
    }

    public function logout()
    {
        $user = Auth::guard('faculty')->user();

        if (!$user) {
            return redirect()->route('login')->with('error', 'Please log in to continue.');
        }

        $logHistoryCount = LogHistory::where('user_code', $user->user_code)
        ->whereNull('logout')
        ->count();

        if ($logHistoryCount > 1) {
            Faculty::where('user_code', $user->user_code)->update(['status' => 'online']);
        } else {
            Faculty::where('user_code', $user->user_code)->update(['status' => 'offline']);
        }

        Auth::guard('faculty')->logout();

        request()->session()->invalidate();
        request()->session()->regenerateToken();

        return redirect('/')->with('success', 'You have been logged out.');
    }

    public function excelstore(Request $request)
    {
        $path = $request->file('file')->getRealPath();
        $data = Excel::toCollection(null, $path);

        if ($data->isNotEmpty()) {
            $insert_data = [];
            $invalid_users = [];

            // Retrieve headers from the first row
            $headers = array_map('trim', array_map('strtolower', $data->first()->shift()->toArray()));

            foreach ($data->first() as $row) {
                $row = array_combine($headers, array_map('trim', $row->toArray()));

                if (isset($row['code'], $row['name'], $row['email'], $row['phone'], $row['birthday'])) {
                    try {
                        // Handle Excel numeric birthday format
                        if (is_numeric($row['birthday'])) {
                            $formattedBirthday = Carbon::instance(\PhpOffice\PhpSpreadsheet\Shared\Date::excelToDateTimeObject($row['birthday']))->format('Y-m-d');
                        } else {
                            $formattedBirthday = Carbon::parse($row['birthday'])->format('Y-m-d');
                        }
                    } catch (\Exception $e) {
                        // Collect invalid user errors
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

                    // Prepare data for insertion
                    $insert_data[] = [
                        'name' => $row['name'],
                        'user_code' => $row['code'],
                        'email' => $row['email'],
                        'phone' => $row['phone'],
                        'birthday' => $formattedBirthday,
                    ];
                } else {
                    // Handle missing required fields
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
                        'user_code' => ['required', 'regex:/^20\d{6}$/'],
                        'email' => ['required', 'string', 'email', 'max:255'],
                        'phone' => ['nullable', 'string', 'max:255', 'regex:/^09\d{9}$/'],
                        'birthday' => ['required', 'date_format:Y-m-d', 'before_or_equal:' . now()->subYears(20)->format('Y-m-d')],
                    ]);

                    $errors = [];

                    if (!preg_match('/^20\d{6}$/', $data['user_code'])) {
                        $errors[] = 'error for user code';
                    }
                    if (Faculty::where('user_code', $data['user_code'])->exists()) {
                        $errors[] = 'duplicate user code';
                    }


                    if (Faculty::where('phone', $data['phone'])->exists()) {
                        $errors[] = 'duplicate phone number';
                    }

                    if (Faculty::where('email', $data['email'])->exists()) {
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

                    Faculty::create($userData);
                }

                InvalidFaculty::insert($invalid_users);

                foreach ($invalid_users as $invalidUser) {
                    $existingInvalidUsers = InvalidFaculty::where('user_code', $invalidUser['user_code'])->exists();

                    if ($existingInvalidUsers) {

                        $errorMessages = InvalidFaculty::where('user_code', $invalidUser['user_code'])->pluck('error_message')->toArray();

                        $invalidUser['error_message'] = implode(', ', $errorMessages);

                        InvalidFaculty::where('user_code', $invalidUser['user_code'])
                                ->update(['error_message' => $invalidUser['error_message']]);
                    }
                }

                $valid_users = count($insert_data) - count($invalid_users);

                return redirect()->route('admin.faculty')->with('success', $valid_users . ' users added successfully. ' . count($invalid_users) . ' invalid entries.');
            }
        }

        return back()->with('error', 'No data to insert. ' . count($invalid_users) . ' invalid entries.');
    }

    public function searchFaculty(Request $request)
    {
        $query = $request->input('query_faculty');
        $users = Faculty::where('name', 'LIKE', "%{$query}%")
            ->orWhere('email', 'LIKE', "%{$query}%")
            ->orWhere('user_code', 'LIKE', "%{$query}%")
            ->orWhere('phone', 'LIKE', "%{$query}%")
            ->orWhere('birthday', 'LIKE', "%{$query}%")
            ->orWhere('status', 'LIKE', "%{$query}%")
            ->get();

        return response()->json($users);
    }

    public function searchFacultyInvalid(Request $request)
    {
        $query = $request->input('query_faculty_invalid');
        $users = InvalidFaculty::where('name', 'LIKE', "%{$query}%")
            ->orWhere('email', 'LIKE', "%{$query}%")
            ->orWhere('user_code', 'LIKE', "%{$query}%")
            ->orWhere('phone', 'LIKE', "%{$query}%")
            ->orWhere('birthday', 'LIKE', "%{$query}%")
            ->orWhere('status', 'LIKE', "%{$query}%")
            ->orWhere('error_message', 'LIKE', "%{$query}%")
            ->get();

        return response()->json($users);
    }

    public function verifyEmail($user_code) {

        $user = Faculty::where('user_code', $user_code)->first();

        if ($user) {

            $user->status = 'online';
            $user->save();

            return redirect()->route('faculty.home')->with('success', 'Email verified successfully!');
        }

        return redirect()->route('login')->with('error', 'Invalid verification link.');
    }

}
