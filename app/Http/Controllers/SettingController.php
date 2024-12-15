<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\ArchiveDate;
use App\Models\SetDeleteDate;
use Carbon\Carbon;

class SettingController extends Controller
{
    public function setting() {
        $set_date = ArchiveDate::first();
        $delete_setDate = SetDeleteDate::first();

        return view('admin.admin_setting', compact('set_date', 'delete_setDate' ));
    }

    public function setArchive(Request $request)
    {

        $set_date = ArchiveDate::first();

        $data = $request->validate([
            'date' => 'nullable|integer|in:1,2,3,4,5',
        ]);

        if (!empty($data['date'])) {
            $set_date->archive_date = $data['date'];
            $set_date->save();
            return back()->with('success', 'Successfully updated.');
        }

        return back()->with('date', 'No valid date provided. Archive date remains unchanged.');
    }

    public function setDelete(Request $request)
    {

        $set_date = SetDeleteDate::first();

        $data = $request->validate([
            'delete' => 'nullable|integer|min:1|max:25',
        ]);

        if (!empty($data['delete'])) {
            $set_date->delete_date = $data['delete'];
            $set_date->save();
            return back()->with('success', 'Successfully updated.');
        }

        return back()->with('delete', 'No valid date provided. Delete date remains unchanged.');
    }
}
