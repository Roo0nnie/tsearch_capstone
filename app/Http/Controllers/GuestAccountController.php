<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\GuestAccount;
use App\Models\DeletedUsers;
use App\Models\LogHistory;
use App\Models\Preference;
use App\Models\Rating;
use App\Models\MyLibrary;
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

        if (Auth::guard('guest_account')->check()) {
            Auth::guard('guest_account')->logout();

            return redirect()->to('login')->with('message', 'You have been logged out due to re-login attempt.');
        }

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

    public function view()
    {

        // $invalidfaculties = InvalidFaculty::all();
        $guestAccounts = GuestAccount::all();
        return view('admin.admin_page.guest_account.guestAccount', compact('guestAccounts'));

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
            // Check if a deleted guest account exists for the provided email
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

                        $new_user = GuestAccount::create([
                                    'profile' => $filename,
                                    'name' => $user->getName(),
                                    'email' => $email,
                                    'google_id' => $user->getId(),
                                    'status' => 'Active',
                                    'type' => 'user',
                                    'user_code' => $user_code,
                                ]);

                        // if (str_ends_with($email, '@bicol-u.edu.ph')) {
                        //     $new_user = GuestAccount::create([
                        //         'profile' => $filename,
                        //         'name' => $user->getName(),
                        //         'email' => $email,
                        //         'google_id' => $user->getId(),
                        //         'status' => 'Active',
                        //         'type' => 'user',
                        //         'user_code' => $user_code,
                        //     ]);
                        // } else {
                        //     return redirect()->back()->with('error', 'Only university members are allowed. You can enter as a guest.');
                        // }

                        Auth::guard('guest_account')->login($new_user, true);
                        $request->session()->regenerate();

                        return redirect()->route('guest.account.home');
                    } else {
                        throw new Exception('Invalid image data.');
                    }
                } catch (Exception $ex) {
                    return redirect()->back()->with('error', 'Unable to process your avatar image: ' . $ex->getMessage());
                }
        }

        } if($guestUser->account_status == 'blocked') {
            return redirect()->back()->with('error', 'Your account has been blocked.');
        } else {

            Auth::guard('guest_account')->login($guestUser, true);
            $request->session()->regenerate();
            $guestUser->google_id = $user->getId();
            $guestUser->status = 'Active';
            $guestUser->save();

            return redirect()->route('guest.account.home');
        }
    } catch (\Exception $ex) {
        return redirect()->back()->with('error', 'Google authentication failed. ' . $ex->getMessage());
    }
}

    public function destroy(GuestAccount $guestAccount) {


        $guestAccount->update([
            'action' => 'deleted',
            'deleted_time' => now(),
            'delete_by' => auth()->user()->name,
            'permanent_delete' => now()->addDays(30),
            // 'permanent_delete' => now()->addSeconds(30),
        ]);

        return redirect()->route('admin.guestAccount')->with('success', 'Guest deleted successfully.');

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

        $saved = MyLibrary::with('imrad') // Eager load the related Imrad
        ->where('user_code', $guestAccount->user_code)
        ->get();

        $selectedAuthors = $userPreferences ? explode(',', $userPreferences->authors) : [];
        $selectedAdvisers = $userPreferences ? explode(',', $userPreferences->advisers) : [];
        $selectedDepartments = $userPreferences ? explode(',', $userPreferences->departments) : [];

        return view('admin.admin_page.guest_account.guestAccountView', compact('guestAccount', 'logs', 'selectedAuthors', 'selectedAdvisers', 'selectedDepartments', 'title_ratings', 'saved'));
    }
}

