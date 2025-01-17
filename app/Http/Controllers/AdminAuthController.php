<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;
use App\Models\Admin;
use App\Models\Imrad;
use App\Models\GuestAccount;
use App\Models\LogHistory;
use App\Models\Announcement;
use App\Models\DeletedUsers;
// use App\Models\InvalidAdmin;
use Illuminate\Support\Facades\Hash;
use Maatwebsite\Excel\Facades\Excel;
use Carbon\Carbon;
use Illuminate\Support\Facades\Validator;
use App\Notifications\CustomUserCodePassword;
use Illuminate\Support\Facades\Notification;
use Illuminate\Support\Facades\Auth;

class AdminAuthController extends Controller
{
    public function index()
    {
        $imrads = Imrad::all();
        $users = GuestAccount::all();

        $logusers = LogHistory::where('login', '>=', now()->subDays(7))->get();
        $announcements = Announcement::all();

        return view('admin.dashboard', compact('imrads','users', 'logusers', 'announcements'));
    }

    public function view()
    {
        // $invalidadmins = InvalidAdmin::all();
        $admins = Admin::all();
        return view('superadmin.admin.admin', compact('admins'));
    }

    public function searchAdmin(Request $request)
    {
        $query = $request->input('query_admin');
        $admins = Admin::where('name', 'LIKE', "%{$query}%")
            ->orWhere('email', 'LIKE', "%{$query}%")
            ->orWhere('user_code', 'LIKE', "%{$query}%")
            ->orWhere('phone', 'LIKE', "%{$query}%")
            ->orWhere('birthday', 'LIKE', "%{$query}%")
            ->get();

        return response()->json($admins);
    }

    // =================== If execute, will redirect to admin.admin_page.user.userCreate ==========================
    public function create()
    {
        return view('superadmin.admin.adminCreate');
    }

    // =================== If execute, will redirect to admin.user along with success message ==========================
    public function store(Request $request)
    {
        $data = $request->validate([
            'name' => ['required', 'string', 'max:255'],
            'email' => ['required', 'string', 'email', 'max:255', 'unique:admins,email'],
            'phone' => ['nullable', 'string', 'max:255', 'unique:admins,phone', 'regex:/^09\d{9}$/'],
            'birthday' => 'required|date|before_or_equal:' . now()->subYears(12)->format('Y-m-d'),
            'age' => ['required', 'string'],
            'gender' => ['nullable', 'string', 'in:other,male,female'],
        ]);



        $BdayToPass = \Carbon\Carbon::createFromFormat('Y-m-d', $data['birthday'])->format('Y-m-d');

        $password = $BdayToPass;
        $user_code = $this->generateUserCode();

        $user = Admin::create([
            'user_code' => $user_code,
            'name' => $data['name'],
            'email' => $data['email'],
            'phone' => $data['phone'] ?: null,
            'birthday' => $BdayToPass,
            'age' => $data['age'] ?: null,
            'gender' => $data['gender'],
            'password' => Hash::make($password),
        ]);

        try {
            $token = app('auth.password.broker')->createToken($user);
            Notification::send($user, new CustomUserCodePassword($token, $user_code, $password));
            return redirect()->route('super_admin.admin')->with('status', 'Added admin successfully.');
        } catch (\Exception $e) {
            return back()->withErrors(['user_code' => 'Failed to send the User Code. Please try again.']);
        }
    }

    public function generateUserCode()
    {

        do {
            $randomNumber = mt_rand(100000, 999999);
            $user_code = '19' . $randomNumber;
        } while ($this->userCodeExists($user_code));

        return $user_code;
    }

    public static function userCodeExists($user_code)
    {
        return Admin::where('user_code', $user_code)->exists();
    }

    // =================== If execute, will redirect to admin.admin_page.user.userEdit along with user data to edit user ==========================
    public function edit(Admin $admin)
    {
        return view('superadmin.admin.adminEdit', ['admin' => $admin]);
    }

    // =================== If execute, user can update information ==========================
    public function update(Admin $admin, Request $request)
    {
        $data = $request->validate([
            'user_code' => 'required|string|max:255|unique:admins,user_code,' . $admin->id .'|regex:/^19\d{6}$/',
            'name' => 'required|string|max:255',
            'email' => 'required|string|email|max:255|unique:admins,email,' . $admin->id,
            'phone' => 'nullable|string|max:255|unique:admins,phone,' . $admin->id . '|regex:/^09\d{9}$/', // Optional phone validation
            'birthday' => ['nullable', 'date'],
            'age' => 'nullable|integer|min:0',
            'gender' => 'nullable|in:male,female,other',
        ]);

        $admin->user_code = $data['user_code'];
        $admin->name = $data['name'];
        $admin->email = $data['email'];
        $admin->gender = $data['gender'] ?: 'other';
        $admin->age = $data['age'] ?: null;
        $admin->phone = $data['phone'] ?: null;
        $admin->birthday = $data['birthday'] ?: null;
        // $admin->account_status = $data['account_status'];

        $admin->save();

        return redirect()->route('super_admin.admin')->with('success', 'Admin updated successfully.');
    }

    // =================== If execute, admin can delete a user ==========================
    public function destroy(Admin $admin)
    {

        $admin->update([
            'action' => 'deleted',
            'deleted_time' => now(),
            'delete_by' => auth()->user()->name,
            'permanent_delete' => now()->addDays(30),
            // 'permanent_delete' => now()->addSeconds(30),
        ]);

        return redirect()->back()->with('success', 'Admin deleted successfully.');
    }

    public function excelstore(Request $request)
    {

        $path = $request->file('file')->getRealPath();

        $data = Excel::toCollection(null, $path);

        if ($data->isNotEmpty()) {
            $insert_data = [];
            $invalid_admins = [];

            $headers = array_map('trim', array_map('strtolower', $data->first()->shift()->toArray()));

            foreach ($data->first() as $row) {

                $row = array_combine($headers, array_map('trim', $row->toArray()));

                if (isset($row['name'], $row['user_code'], $row['email'], $row['phone'], $row['birthday'], $row['type'])) {

                    try {
                        if (is_numeric($row['birthday'])) {
                            $formattedBirthday = Carbon::instance(\PhpOffice\PhpSpreadsheet\Shared\Date::excelToDateTimeObject($row['birthday']))->format('Y-m-d');
                        } else {
                            $formattedBirthday = Carbon::parse($row['birthday'])->format('Y-m-d');
                        }
                    } catch (\Exception $e) {

                        $invalid_admins[] = [
                            'name' => $row['name'] ?? null,
                            'user_code' => $row['user_code'] ?? null,
                            'email' => $row['email'] ?? null,
                            'phone' => $row['phone'] ?? null,
                            'birthday' => $row['birthday'] ?? null,
                            'type' => $row['type'] ?? null,
                            // 'status' => $row['status'] ?? null,
                            'error_message' => 'Invalid birthday date format',
                        ];
                        continue;
                    }

                    $insert_data[] = [
                        'name' => $row['name'],
                        'user_code' => $row['user_code'],
                        'email' => $row['email'],
                        'phone' => $row['phone'],
                        'birthday' => $formattedBirthday,
                        'type' => $row['type'],
                        // 'status' => $row['status'],
                    ];
                } else {

                    $invalid_admins[] = [
                        'name' => $row['name'] ?? null,
                        'user_code' => $row['user_code'] ?? null,
                        'email' => $row['email'] ?? null,
                        'phone' => $row['phone'] ?? null,
                        'birthday' => $row['birthday'] ?? null,
                        'type' => $row['type'] ?? null,
                        // 'status' => $row['status'] ?? null,
                        'error_message' => 'Missing required fields',
                    ];
                    continue;
                }
            }


            if (!empty($insert_data)) {
                foreach ($insert_data as $data) {

                    $validator = Validator::make($data, [
                        'name' => ['required', 'string', 'max:255'],
                        'user_code' => ['required', 'unique:admins,user_code'],
                        'email' => ['required', 'string', 'email', 'max:255', 'unique:admins,email'],
                        'phone' => ['nullable', 'string', 'max:255', 'unique:admins,phone,NULL,id', 'regex:/^09\d{9}$/'],
                        'birthday' => ['required', 'date_format:Y-m-d'],
                        'type' => ['required', 'string'],
                        'status' => ['required', 'string'],
                        // 'status' => ['required', 'string', 'in:Active,Deactive'],
                    ]);

                    if ($validator->fails()) {

                        $invalid_admins[] = [
                            'name' => $data['name'] ?? null,
                            'user_code' => $data['user_code'] ?? null,
                            'email' => $data['email'] ?? null,
                            'phone' => $data['phone'] ?? null,
                            'birthday' => $data['birthday'] ?? null,
                            'type' => $data['type'] ?? null,
                            'status' => $data['status'] ?? null,
                            'error_message' => $validator->errors()->first(),
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
                        'type' => $validatedData['type'],
                        'status' => $validatedData['status'],
                    ];

                    if (!empty($validatedData['phone'])) {
                        $userData['phone'] = $validatedData['phone'];
                    }

                    Admin::create($userData);
                }

                InvalidAdmin::insert($invalid_admins);

                $valid_admins =  count($insert_data) - count($invalid_admins);

                return redirect()->route('admin.admin')->with('success', $valid_admins . ' admins added successfully. ' . count($invalid_admins) . ' invalid entries.');
            }
        }

        return back()->with('error', 'No data to insert. ' . count($invalid_admins) . ' invalid entries.');
    }

    public function adminVerifyForm() {
        return view('admin.admin_page.admin.admin_verify');
    }

    public function adminVerifyCode(Request $request)
    {

        $request->validate([
            'verification_code' => 'required|numeric|digits:6',
        ]);

        $Admin = Auth::guard('admin')->user();


        if (!$Admin) {
            return redirect()->route('landing.page')->with('error', 'You must be logged in as a admin');
        }

        if ($Admin->verification_code == $request->verification_code) {
            if(now()->isBefore($Admin->verification_code_expires_at)) {
                $Admin->verification_code = null;
                $Admin->verification_code_expires_at = null;
                $Admin->status = 'active';
                $Admin->save();

                Auth::guard('admin')->login($Admin);

                return redirect()->route('admin.dashboard')->with('message', 'Verification successful!');
            }else {
                $Admin->verification_code = null;
                $Admin->verification_code_expires_at = null;
                $Admin->save();
                Auth::guard('admin')->logout();
                return back()->withErrors(['verification_code' => 'The verification code has expired.']);
            }
        } else {
            return back()->withErrors(['verification_code' => 'Invalid verification code. Please try again.']);
        }
    }

    public function userview(Admin $admin) {
        $logs = LogHistory::all();
        return view('superadmin.admin.adminView', compact('admin', 'logs'));
    }

    public function file_upload(Request $request) {

        $filter_type = $request->input('filter_type');

        $authors = Imrad::select('author')->get();
        $advisers = Imrad::select('adviser')->get();
        $departments = Imrad::select('department')->distinct()->get();
        $years = Imrad::select('publication_date')->distinct()->get();

        $adviserList = [];
        $departmentList = $departments->pluck('department')->toArray();
        $yearList = [];

        foreach ($years as $year) {
            $year = substr($year->publication_date, -4);
            if (!in_array($year, $yearList)) {
                $yearList[] = $year;
            }
        }

        rsort($yearList);


        foreach ($advisers as $adviser) {
            $names = explode(',', $adviser->adviser);
            foreach ($names as $name) {
                $trimmedName = trim($name);
                if (!in_array($trimmedName, $adviserList)) {
                    $adviserList[] = $trimmedName;
                }
            }
        }

        sort($adviserList);

        if ($filter_type === 'filter') {
            $query = Imrad::with('imradMetric');

            $this->applyFilters($request, $query);
            $imrads = $query->where('action', null)->get();
            return view('admin.admin_page.report-table.file_upload', compact('imrads','adviserList', 'departmentList', 'yearList' ));
        }

        $imrads = Imrad::where('action', null)->get();
        return view('admin.admin_page.report-table.file_upload', compact('imrads','adviserList', 'departmentList', 'yearList' ));
    }

    public function file_rating(Request $request) {

        $filter_type = $request->input('filter_type');

        $authors = Imrad::select('author')->get();
        $advisers = Imrad::select('adviser')->get();
        $departments = Imrad::select('department')->distinct()->get();
        $years = Imrad::select('publication_date')->distinct()->get();

        $adviserList = [];
        $departmentList = $departments->pluck('department')->toArray();
        $yearList = [];

        foreach ($years as $year) {
            $year = substr($year->publication_date, -4);
            if (!in_array($year, $yearList)) {
                $yearList[] = $year;
            }
        }

        rsort($yearList);


        foreach ($advisers as $adviser) {
            $names = explode(',', $adviser->adviser);
            foreach ($names as $name) {
                $trimmedName = trim($name);
                if (!in_array($trimmedName, $adviserList)) {
                    $adviserList[] = $trimmedName;
                }
            }
        }

        sort($adviserList);

        if ($filter_type === 'filter') {
            $query = Imrad::with('imradMetric');

            $this->applyFilters($request, $query);
            $imrads = $query->where('action', null)->get();
            return view('admin.admin_page.report-table.file_rating', compact('imrads','adviserList', 'departmentList', 'yearList' ));
        }

         $imrads = Imrad::with('imradMetric')->where('action', null)->get();
        return view('admin.admin_page.report-table.file_rating', compact('imrads','adviserList', 'departmentList', 'yearList' ));
    }

    public function file_sdg(Request $request) {

        $filter_type = $request->input('filter_type');

        $authors = Imrad::select('author')->get();
        $advisers = Imrad::select('adviser')->get();
        $departments = Imrad::select('department')->distinct()->get();
        $years = Imrad::select('publication_date')->distinct()->get();

        $adviserList = [];
        $departmentList = $departments->pluck('department')->toArray();
        $yearList = [];

        foreach ($years as $year) {
            $year = substr($year->publication_date, -4);
            if (!in_array($year, $yearList)) {
                $yearList[] = $year;
            }
        }

        rsort($yearList);


        foreach ($advisers as $adviser) {
            $names = explode(',', $adviser->adviser);
            foreach ($names as $name) {
                $trimmedName = trim($name);
                if (!in_array($trimmedName, $adviserList)) {
                    $adviserList[] = $trimmedName;
                }
            }
        }

        sort($adviserList);

        if ($filter_type === 'filter') {
            $query = Imrad::with('imradMetric');

            $this->applyFilters($request, $query);
            $imrads = $query->where('action', null)->get();
            return view('admin.admin_page.report-table.file_sdg', compact('imrads','adviserList', 'departmentList', 'yearList' ));
        }

            $imrads = Imrad::where('action', null)->get();
            return view('admin.admin_page.report-table.file_sdg', compact('imrads','adviserList', 'departmentList', 'yearList' ));
    }



    protected function applyFilters(Request $request, $query)
    {
        if ($request->filled('adviser')) {
            $advisers = $request->input('adviser');
            $query->where(function ($q) use ($advisers) {
                foreach ($advisers as $adviser) {
                    $q->orWhereRaw("FIND_IN_SET(?, adviser)", [$adviser]);
                }
            });
        }

        $startCreate = $request->input('start_create') ?? null;
        $endCreate = $request->input('end_create') ?? null;

        if (is_array($startCreate)) {
            $startCreate = $startCreate[0];
        }

        if (is_array($endCreate)) {
            $endCreate = $endCreate[0];
        }

        if ($startCreate && !$endCreate) {
            $query->whereDate('created_at', '>=', $startCreate);
        } elseif ($endCreate && !$startCreate) {
             $query->whereDate('created_at', '<=', $endCreate);
        } elseif ($startCreate && $endCreate) {
            if ($startCreate === $endCreate) {
                $query->whereDate('created_at', $startCreate);
            } else {
                $query->whereBetween('created_at', [$startCreate, $endCreate]);
            }
        }

        if($request->filled('category')) {
            $categories = $request->input('category');
            $query->whereIn('category', $categories);
        }

        if($request->filled('rating')) {
            $ratings = $request->input('rating');

            $query->whereHas('imradMetric', function ($q) use ($ratings) {
                $q->whereIn('rates', $ratings);
            });
        }

        if ($request->filled('status')) {
            $statuses = $request->input('status');
            $query->where(function ($q) use ($statuses) {
                foreach ($statuses as $status) {
                    $q->orWhereRaw("FIND_IN_SET(?, status)", [$status]);
                }
            });
        }

        $startYear = $request->input('start_year')[0] ?? null;
        $endYear = $request->input('end_year')[0] ?? null;

        if ($startYear && !$endYear) {
            $query->where('publication_date', '>=', $startYear);
        } elseif ($endYear && !$startYear) {
            $query->where('publication_date', '<=', $endYear);
        } elseif ($startYear && $endYear) {
            if ($startYear === $endYear) {
                $query->where('publication_date', $startYear);
            } else {
                $query->whereBetween('publication_date', [$startYear, $endYear]);
            }
        }

        if ($request->filled('department')) {
            $departments = $request->input('department');
            $query->where('department', $departments);
        }

        if ($request->filled('sdg')) {
            $sdgs = array_map('trim', $request->input('sdg'));
            $query->where(function ($q) use ($sdgs) {
                foreach ($sdgs as $sdg) {
                    $q->orWhereRaw("FIND_IN_SET(?, REPLACE(SDG, ' ', ''))", [$sdg]);
                }
            });
        }
    }

}
