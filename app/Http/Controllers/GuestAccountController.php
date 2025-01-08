<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\GuestAccount;
use App\Models\DeletedUsers;
use App\Models\LogHistory;
use App\Models\Preference;
use App\Models\Rating;
use App\Models\SetDeleteDate;
use App\Models\MyLibrary;
use App\Models\Imrad;
use App\Models\MyThesis;
use App\Models\InvalidFaculty;
use App\Notifications\CustomUserCode;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Notification;
use Laravel\Socialite\Facades\Socialite;
use Intervention\Image\Facades\Image;


class GuestAccountController extends Controller
{

    public function landingPage()
    {
        // pupunta cya sa welcome page
        return view('welcome');
    }

    public function showLoginForm()
    {

        return view('auth.login');
    }

    public function login(Request $request)
    {
        //validate if and inpass na value is meron laman.
        $request->validate([
            'email' => 'required',
            'password' => 'required|min:6',
        ]);

        $errors = [];
        //kukunin first data sa guest_account na may kapareho sa input email.
        $user = GuestAccount::where('email', $request->email)->first();

        //if hindi parehas, failed email.
        if (!$user) {
            $errors['email'] = trans('auth.failed_email');
        } else {
            //if parehas, check the password. else password failed
            if (!Hash::check($request->password, $user->password)) {
                $errors['password'] = trans('auth.failed_password');
            } else {

                if (Auth::guard('guest_account')->attempt(['email' => $request->email, 'password' => $request->password])) {

                    $this->deleteOtherSessions($user);
                    $request->session()->regenerate();

                    return redirect()->intended(route('guest.account.home'));
                }
                $errors['email'] = trans('auth.failed_email');
            }
        }

        if (!empty($errors)) {
            return back()->withErrors($errors)->withInput();
        }
    }

    protected function deleteOtherSessions(GuestAccount $user)
    {
        DB::table('sessions')
            ->where('user_code', $user->email)
            ->delete();
    }

    public function logout()
    {
        $user = Auth::guard('guest_account')->user();
        if (!$user) {
            return redirect()->route('login')->with('error', 'Please log in to continue.');
        }

        $logHistoryCount = LogHistory::where('user_code', $user->user_code)
        ->whereNull('logout')
        ->count();

        if ($logHistoryCount > 1) {
            GuestAccount::where('user_code', $user->user_code)->update(['status' => 'Active']);
        } else {
            GuestAccount::where('user_code', $user->user_code)->update(['status' => 'Inactive']);
        }

        Auth::guard('guest_account')->logout();

        request()->session()->invalidate();
        request()->session()->regenerateToken();

        return redirect('/')->with('success', 'You have been logged out.');

    }

    public function showRegistrationForm()
    {
        return view('guestAccount.register');
    }

    public function register(Request $request)
    {
        $this->validator($request->all())->validate();

        $user = $this->create($request->all());
        $token = app('auth.password.broker')->createToken($user);

        try {
            Notification::send($user, new CustomUserCode($token, $user->user_code));
            return redirect()->route('login')->with(['status' => 'Your User Code has been sent to your email. Check before login']);
        } catch (\Exception $e) {
            return back()->withErrors(['user_code' => 'Failed to send the User Code. Please try again.']);
        }

        // Auth::guard('guest_account')->login($user);
        // return redirect()->route('guest.account.home');
    }

    protected function validator(array $data)
    {

        return Validator::make($data, [
            'name' => ['required', 'string', 'max:255'],
            'email' => ['required', 'string', 'email', 'max:255', 'unique:guest_account'],
            'password' => ['required', 'string', 'min:8', 'confirmed'],
            'type' => ['required', 'string'],
            'status' => ['required', 'string'],
        ]);
    }
    public function createfromadmin() {
        return view('admin.admin_page.guest_account.guestAccountCreate');
    }

    public function storefromadmin(Request $request)
    {
        $data = $request->validate([
            'name' => ['required', 'string', 'max:255'],
            'email' => ['required', 'string', 'email', 'max:255', 'unique:guest_account'],
            'phone' => ['nullable', 'string', 'max:255', 'unique:guest_account', 'regex:/^09\d{9}$/'],
            'bday' => ['required', 'date'],
            'type' => ['required', 'string'],
            // 'status' => ['required', 'string', 'in:Active,Deactive'],
            'status' => ['required', 'string'],
        ]);

        // Format the birthday date
        $BdayToPass = \Carbon\Carbon::createFromFormat('Y-m-d', $data['bday'])->format('Y-m-d');

        $password = $BdayToPass;
        $user_code = $this->generateUserCode();


        // Create the admin record
        $user = GuestAccount::create([
            'user_code' => $user_code,
            'name' => $data['name'],
            'email' => $data['email'],
            'phone' => $data['phone'] ?: null,
            'birthday' => $BdayToPass,
            'password' => Hash::make($password),
            'type' => $data['type'],
            'status' => $data['status'],
        ]);

        return redirect()->route('admin.guestAccount')->with('success', 'Added guest successfully.');
    }



    protected function create(array $data)
    {

        $user = GuestAccount::create([
            'name' => $data['name'],
            'email' => $data['email'],
            'password' => Hash::make($data['password']),
            'type' => $data['type'],
            'status' => $data['status'],
        ]);

        $user->user_code = $this->generateUserCode();

        $user->save();

        return $user;
    }

    public function generateUserCode()
    {

        do {
            $randomNumber = mt_rand(100000, 999999);
            $user_code = '09' . $randomNumber;
        } while ($this->userCodeExists($user_code));

        return $user_code;
    }

    public static function userCodeExists($user_code)
    {
        return GuestAccount::where('user_code', $user_code)->exists();
    }

    public function verifyEmail($user_code) {

        $user = GuestAccount::where('user_code', $user_code)->first();

        if ($user) {

            $user->status = 'Active';
            $user->save();

            return redirect()->route('guest.account.home')->with('success', 'Email verified successfully!');
        }

        return redirect()->route('login')->with('error', 'Invalid verification link.');
    }

    public function view(Request $request)
    {

        $filter_type = $request->input('filter_type');

        if ($filter_type === 'published') {
            $query = GuestAccount::query();

            $this->applyFilters($request, $query);

            $guestAccounts = $query->where('type', 'student')->get();

            return view('admin.admin_page.guest_account.guestAccount', compact('guestAccounts'));
        }

        $guestAccounts = GuestAccount::where('type', 'student')->get();
        return view('admin.admin_page.guest_account.guestAccount', compact('guestAccounts'));
    }

    public function facultyView(Request $request)
    {

        $filter_type = $request->input('filter_type');

        if ($filter_type === 'published') {
            $query = GuestAccount::query();

            $this->applyFilters($request, $query);

            $guestAccounts = $query->where('type', 'faculty')->get();

            return view('admin.admin_page.faculty.faculty', compact('guestAccounts'));
        }

        $guestAccounts = GuestAccount::where('type', 'faculty')->get();
        return view('admin.admin_page.faculty.faculty', compact('guestAccounts'));
    }

    public function changeToFaculty(Request $request)
    {
        $ids = $request->input('ids', []);

        if (!is_array($ids) || empty($ids)) {
            return response()->json(['message' => 'No items selected for archiving'], 400);
        }

        try {
            $files = GuestAccount::whereIn('id', $ids)->get();

            foreach ($files as $file) {
                $file->update([
                    'type' => 'faculty',
                ]);
            }

            return response()->json(['message' => 'Selected items archived successfully']);
        } catch (\Exception $e) {
            return response()->json(['message' => 'Error deleting items: ' . $e->getMessage()], 500);
        }
    }

    public function changeToStudent(Request $request)
    {
        $ids = $request->input('ids', []);

        if (!is_array($ids) || empty($ids)) {
            return response()->json(['message' => 'No items selected for archiving'], 400);
        }

        try {
            $files = GuestAccount::whereIn('id', $ids)->get();

            foreach ($files as $file) {
                $file->update([
                    'type' => 'student',
                ]);
            }

            return response()->json(['message' => 'Selected items archived successfully']);
        } catch (\Exception $e) {
            return response()->json(['message' => 'Error deleting items: ' . $e->getMessage()], 500);
        }
    }

    protected function applyFilters(Request $request, $query)
    {

        if($request->filled('status')) {
            $statuses = $request->input('status');
            $query->whereIn('status', $statuses);
        }
    }

    public function searchguestAccount(Request $request)
    {
        $query = $request->input('query_faculty');
        $users = GuestAccount::where('name', 'LIKE', "%{$query}%")
            ->orWhere('email', 'LIKE', "%{$query}%")
            ->orWhere('user_code', 'LIKE', "%{$query}%")
            ->orWhere('phone', 'LIKE', "%{$query}%")
            ->orWhere('birthday', 'LIKE', "%{$query}%")
            ->orWhere('status', 'LIKE', "%{$query}%")
            ->get();

        return response()->json($users);
    }

// User login using google api
public function googleLogin() {
    return Socialite::driver('google')->redirect();
}

public function callbackGoogle(Request $request) {

    try {
        $user = Socialite::driver('google')->user();
        $guestUser = GuestAccount::where('email', $user->email)
        ->where('action', null)
        ->first();

        if (!$guestUser) {
            $guestDeleted = GuestAccount::where('email', $user->email)
                                         ->where('action', 'deleted')
                                         ->first();

            if ($guestDeleted) {
                return redirect()->back()->with('error', 'Your account has been deleted.');
            } else {
                try {
                    $profileUrl = $user->getAvatar();
                    $user_code = $this->generateUserCode();
                    $filename = time() . "_" . $user_code . ".png";
                    $profileDirectory = public_path('assets/img/guest_profile');

                    if (!file_exists($profileDirectory)) {
                        mkdir($profileDirectory, 0755, true);
                    }

                    $imageContent = file_get_contents($profileUrl);
                    $image = imagecreatefromstring($imageContent);

                    if ($image !== false) {
                        $newProfilePath = $profileDirectory . '/' . $filename;
                        imagepng($image, $newProfilePath);
                        imagedestroy($image);

                        $email = $user->getEmail();

                         if (str_ends_with($email, '@bicol-u.edu.ph')) {
                            $new_user = GuestAccount::create([
                                'profile' => $filename,
                                'name' => $user->getName(),
                                'email' => $email,
                                'google_id' => $user->getId(),
                                'status' => 'Active',
                                'type' => 'student',
                                'user_code' => $user_code,
                            ]);

                        } else {
                            return redirect()->back()->with('error', 'Make sure you are using your Sorsu email address to login.');
                        }

                        Auth::guard('guest_account')->login($new_user, true);
                        $request->session()->regenerate();

                        return redirect()->route('guest.account.home')->with('success', 'Welcome to our T-search Management System!');
                    } else {
                        throw new Exception('Invalid image data.');
                    }
                } catch (Exception $ex) {
                    return redirect()->back()->with('error', 'Unable to process your avatar image: ' . $ex->getMessage());
                }
        }

        } if($guestUser->account_status == 'blocked') {
            return redirect()->back()->with('error', 'Your account has been blocked due to multiple failed login attempts.');
        } else {

            Auth::guard('guest_account')->login($guestUser, true);
            $request->session()->regenerate();
            $guestUser->google_id = $user->getId();
            $guestUser->status = 'Active';
            $guestUser->save();

            return redirect()->route('guest.account.home')->with('success', 'Welcome to our T-search Management System!');
        }
    } catch (\Exception $ex) {
        return redirect()->back()->with('error', 'Google authentication failed. ' . $ex->getMessage());
    }
}

    public function destroy(Request $request) {

        $deleted_date = SetDeleteDate::first();
        $ids = $request->input('ids', []);

        if (!is_array($ids) || empty($ids)) {
            return response()->json(['message' => 'No items selected for deletion'], 400);
        }

        try {
            $users = GuestAccount::whereIn('id', $ids)->get();

            foreach ($users as $user) {
                $user->update([
                    'action' => 'deleted',
                    'deleted_time' => now(),
                    'delete_by' => auth()->user()->name,
                    'permanent_delete' => now()->addDays($deleted_date->delete_date),
                ]);
            }

            return response()->json(['message' => 'Selected items deleted successfully']);
        } catch (\Exception $e) {
            return response()->json(['message' => 'Error deleting items: ' . $e->getMessage()], 500);
        }
    }

    public function edit(GuestAccount $guestAccount)
    {
        return view('admin.admin_page.guest_account.guestAccountEdit', ['guestAccount' => $guestAccount]);
    }

    public function update(GuestAccount $guestAccount, Request $request)
    {
        // input field names must meet the required validation before storing into the database
        $data = $request->validate([
            'user_code' => 'required|string|max:255|unique:guest_account,user_code,' . $guestAccount->id .'|regex:/^09\d{6}$/',
            'name' => 'required|string|max:255',
            'email' => 'required|string|email|max:255|unique:guest_account,email,' . $guestAccount->id,
            'phone' => 'nullable|unique:guest_account,phone,' . $guestAccount->id . '|regex:/^09\d{9}$/',
            'bday' => ['nullable', 'date'],
            'age' => 'nullable|integer|min:0',
            'gender' => 'nullable|in:male,female,other',
            'status' => 'required|string|in:active,blocked',
        ]);

        $guestAccount->user_code = $data['user_code'];
        $guestAccount->name = $data['name'];
        $guestAccount->email = $data['email'];
        $guestAccount->gender = $data['gender'] ?: 'other';
        $guestAccount->age = $data['age'] ?: null;
        $guestAccount->phone = $data['phone'] ?: null;
        $guestAccount->birthday = $data['bday'] ?: null;
        $guestAccount->account_status = $data['status'];

        $guestAccount->save();

        return redirect()->route('admin.guestAccount')->with('success', 'Guest updated successfully.');
    }

    public function userview(GuestAccount $guestAccount) {
        $logs = LogHistory::all();
        $userPreferences = Preference::where('user_code', $guestAccount->user_code)->first();

        $title_ratings = Rating::where('user_code', $guestAccount->user_code)
        ->with('imrad_metric.imrad')
        ->get();

        $saved = MyLibrary::with('imrad')
        ->where('user_code', $guestAccount->user_code)
        ->get();

        $myTheses = MyThesis::with('imrad')->where('user_code', $guestAccount->user_code)->get();
        $myThesesID = $myTheses->pluck('imrad_id')->toArray();

        $thesisFileList = Imrad::whereNotIn('id', $myThesesID)->get();

        $selectedAuthors = $userPreferences ? explode(',', $userPreferences->authors) : [];
        $selectedAdvisers = $userPreferences ? explode(',', $userPreferences->advisers) : [];
        $selectedDepartments = $userPreferences ? explode(',', $userPreferences->departments) : [];

        return view('admin.admin_page.guest_account.guestAccountView', compact('guestAccount', 'myTheses','logs','thesisFileList', 'selectedAuthors', 'selectedAdvisers', 'selectedDepartments', 'title_ratings', 'saved'));
    }

    public function mythesisdestroy($id)
    {
        $myThesis = MyThesis::findOrFail($id);

        if ($myThesis->delete()) {
            return redirect()->back()->with('success', 'File successfully removed.');
        }

        return redirect()->back()->with('error', 'Failed to unselect the thesis.');
    }


    public function storeSelectedThesis(Request $request)
    {

        try {
            $request->validate([
                'ids' => 'required|array',
                'user_code' => 'required|string',
                'user_type' => 'required|string',
            ]);

            // $validatedData = $request->validate([
            //     'ids' => 'required|array',
            //     'user_code' => 'required|string',
            //     'user_type' => 'required|string',
            // ]);

            // return response()->json([
            //     'message' => 'Validation successful',
            //     'data' => $validatedData
            // ], 200);

            foreach ($request->ids as $id) {
                MyThesis::create([
                    'user_code' => $request->user_code,
                    'user_type' => $request->user_type,
                    'imrad_id' => $id,
                ]);
            }

            return response()->json(['message' => 'Selected theses successfully stored.']);
        } catch (\Exception $e) {
            \Log::error('Error storing theses: ' . $e->getMessage());

            return response()->json(['message' => 'An error occurred while processing your request.'], 500);
        }
    }


}

