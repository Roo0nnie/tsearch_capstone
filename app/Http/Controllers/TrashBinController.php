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
    public function trashViewFile(Request $request)
    {
        $filter_type = $request->input('filter_type');
        if ($filter_type === 'published') {
            $query = Imrad::query();

            $this->applyFilters($request, $query);

            $archives = $query->where('action', 'deleted')->get();

            return view('admin.admin_page.trash_bin.trash_file', compact('archives'));
        }

        $archives = Imrad::where('action', 'deleted')->get();
        return view('admin.admin_page.trash_bin.trash_file', compact('archives'));
    }

    protected function applyFilters(Request $request, $query)
    {

        if($request->filled('category')) {
            $categories = $request->input('category');
            $query->whereIn('category', $categories);
        }
    }

    public function trashViewUser()
    {
        $users = GuestAccount::where('action', 'deleted')->get();
        return view('admin.admin_page.trash_bin.trash_user', compact('users'));
    }

    public function recover(Request $request) {

        $ids = $request->input('ids', []);

        if (!is_array($ids) || empty($ids)) {
            return response()->json(['message' => 'No items selected for deletion'], 400);
        }

        try {
            $users = GuestAccount::whereIn('id', $ids)->get();

            foreach ($users as $user) {
                $user->update([
                    'action' => null,
                    'deleted_time' => null,
                    'delete_by' => null,
                    'permanent_delete' => null,
                ]);
            }

            return response()->json(['message' => 'Selected items deleted successfully']);
        } catch (\Exception $e) {
            return response()->json(['message' => 'Error deleting items: ' . $e->getMessage()], 500);
        }
    }

    public function destroy(Request $request)
    {
        $ids = $request->input('ids', []);

        if (!is_array($ids) || empty($ids)) {
            return response()->json(['message' => 'No items selected for deletion'], 400);
        }

        try {
            GuestAccount::whereIn('id', $ids)->each(function ($user) {
                $filePath = public_path('assets/img/guest_profile/' . $user->profile);
                if (file_exists($filePath)) {
                    @unlink($filePath);
                }
                $user->delete();
            });

            return response()->json(['message' => 'Selected items deleted successfully']);
        } catch (\Exception $e) {
            return response()->json(['message' => 'Error deleting items: ' . $e->getMessage()], 500);
        }
    }

    public function destroyAutomatic(GuestAccount $user)
    {
        $filePath = public_path('assets/img/guest_profile/' . $user->profile);

        if (file_exists($filePath)) {
            @unlink($filePath);
        }

        $user->delete();

        return redirect()->back()->with('success', 'User Deleted successfully.');
    }

    public function recoverImrad(Request $request) {
        $ids = $request->input('ids', []);

        if (!is_array($ids) || empty($ids)) {
            return response()->json(['message' => 'No items selected for recovery'], 400);
        }

        try {
            $files = Imrad::whereIn('id', $ids)->get();
            $error = false;

            foreach ($files as $file) {
                $exists = Imrad::where('title', $file->title)
                               ->where('action', null)
                               ->exists();
                if (!$exists) {
                    $file->update([
                        'action' => null,
                        'deleted_time' => null,
                        'delete_by' => null,
                        'permanent_delete' => null,
                    ]);
                } else {
                    $error = true;
                }
            }

            if ($error) {
                return response()->json([
                    'message' => 'One or more files with the same title already exist and were not recovered.'
                ], 400);
            }

            return response()->json(['message' => 'Selected items recovered successfully']);
        } catch (\Exception $e) {
            return response()->json([
                'message' => 'Error recovering items: ' . $e->getMessage()
            ], 500);
        }
    }


    public function delete(Imrad $archive)
    {
        $pdf_file = $archive->pdf_file;

        $destinationPath = public_path('assets/pdf/');
        $filePath = $destinationPath . $pdf_file;

        if (file_exists($filePath)) {

            if (unlink($filePath)) {
                \Log::info("Deleted temporary file: " . $filePath);
            } else {
                return back()->with('error', 'Failed to delete the file. Please try again.');
            }
        } else {
            return back()->with('error', 'File not found.');
        }
        $archive->delete();

        return redirect()->back()->with('success', 'File deleted successfully.');

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

    public function trashDelete(Request $request) {
        $ids = $request->input('ids', []);

        if (!is_array($ids) || empty($ids)) {
            return response()->json(['message' => 'No items selected for deletion'], 400);
        }

        try {
            $deletedFiles = Imrad::whereIn('id', $ids)->get();

            foreach ($deletedFiles as $file) {
                $filePath = public_path('assets/pdf/' . $file->pdf_file);
                if (file_exists($filePath)) {
                    @unlink($filePath);
                }
                $file->delete();
            }

            return response()->json(['message' => 'Selected items deleted successfully.']);
        } catch (\Exception $e) {
            return response()->json([
                'message' => 'Error deleting items. Please try again later.',
                'error' => $e->getMessage()
            ], 500);
        }
    }


}




