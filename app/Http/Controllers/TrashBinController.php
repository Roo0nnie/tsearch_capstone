<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;
use App\Models\Faculty;
use App\Models\GuestAccount;
use App\Models\Admin;
use App\Models\LogHistory;
use App\Models\DeletedUsers;
use App\Models\DeletedImrad;
use App\Models\InvalidUser;
use App\Models\Imrad;
use Illuminate\Support\Facades\Hash;
use Maatwebsite\Excel\Facades\Excel;
use Carbon\Carbon;
use Illuminate\Support\Facades\Validator;
use App\Notifications\CustomPassword;
use Illuminate\Support\Facades\Notification;
use Illuminate\Support\Facades\Auth;
use Illuminate\Validation\Rule;

class TrashBinController extends Controller
{
    public function view()
    {
        $archives = Imrad::where('action', 'deleted')->get();
        $users = GuestAccount::where('action', 'deleted')->get();
        return view('admin.admin_page.trash_bin.trash_bin', compact('users', 'archives'));
    }

    public function recover(GuestAccount $user) {
        // $user_code = $user->user_code;

        // $userData = [
        //     'profile'   => $user->profile ?: null,
        //     'name'      => $user->name,
        //     'user_code' => $user->user_code,
        //     'email'     => $user->email,
        //     'phone'     => $user->phone ?: null,
        //     'birthday'  => $user->birthday ?: null,
        //     'password'  => $user->password ?: null,
        //     'status'    => 'offline',
        //     'type'      => $user->type,
        // ];


        // if (str_starts_with($user_code, '09')) {
        //     $userData['google'] = $user->google_id ?: null;
        //     GuestAccount::create($userData);
        // } elseif (str_starts_with($user_code, '20')) {
        //     Faculty::create($userData);
        // } elseif (str_starts_with($user_code, '21')) {
        //     User::create($userData);
        // } elseif (str_starts_with($user_code, '19')) {
        //     Admin::create($userData);
        // } else {
        //     return redirect()->back()->with('error', 'Invalid user, You must delete it.');
        // }

        // $user->delete();

        $user->update([
            'action' => null,
            'deleted_time' => null,
            'delete_by' => null,
            'permanent_delete' => null,
        ]);
        return redirect()->route('admin.trash-bin')->with('success', 'User recovered successfully.');
    }

    public function destroy(GuestAccount $user)
    {
        $user->delete();

        return redirect()->back()->with('success', 'User Deleted successfully.');
    }

    public function recoverImrad(Imrad $archive) {

        $exists = Imrad::where('title', $archive->title)->where('action', null)->exists();
        // Update the archive record to recover it
        if (!$exists) {
            $archive->update([
                'action' => null,
                'deleted_time' => null,
                'delete_by' => null,
                'permanent_delete' => null,
            ]);
            return redirect()->route('admin.trash-bin')->with('success', 'File recovered successfully.');
        }

        return redirect()->route('admin.trash-bin')->with('error', 'A record with this title already exists and is not deleted.');

    }

    public function delete(Imrad $archive)
    {

        $pdf_file = $archive->pdf_file;
        $filePath = storage_path('app/' . $pdf_file);

        if ($pdf_file && file_exists($filePath)) {
            unlink($filePath);
        }

        $archive->delete();

        // return redirect()->route('admin.trash-bin')->with('success', 'File deleted successfully.');
        return redirect()->back()->with('success', 'File deleted successfully.');
        // return response()->json(['success' => 'File successfully']);

    }

    public function trashview() {
        $admins = Admin::where('action', 'deleted')->get();
        return view('superadmin.trash-bin.superadmin_trash-bin', compact('admins'));

    }

    public function recoveradmin(Admin $admin) {

        $admin->update([
            'action' => null,
            'deleted_time' => null,
            'delete_by' => null,
            'permanent_delete' => null,
        ]);
        return redirect()->route('superadmin.trash-bin')->with('success', 'Admin recovered successfully.');
    }

}




