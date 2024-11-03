<?php

namespace App\Http\Controllers;

use App\Models\Announcement;
use App\Models\MyLibrary;
use Illuminate\Http\Request;
use App\Models\ImradMetric;

class MyLibraryController extends Controller
{
    public function index(Request $request)
    {


        $announcements = Announcement::where('activation', 'Activate')->get();
        $noAnnouncements = false;
        if ($announcements->isEmpty()) {
            $noAnnouncements = true;
        }

        $user_code = $request->user()->user_code;

        $savefiles = MyLibrary::with('imrad')->where('user_code', $user_code)->get();


        return view('main_layouts.mylibrary', compact('savefiles', 'announcements', 'noAnnouncements'));
    }

    public function save(Request $request, $imrad)
    {

        $user = $request->user();
        $metric = ImradMetric::where('imradID', $imrad)->first();

        $alreadyExist = MyLibrary::where('user_code', $user->user_code)
            ->where('user_type', $user->type)
            ->where('imrad_id', $imrad)
            ->first();

        if ($alreadyExist) {
            return redirect()->back()->with('error', 'IMRAD already saved.');
        }

        MyLibrary::create([
            'user_code' => $user->user_code,
            'user_type' => $user->type,
            'imrad_id' => $imrad,
        ]);

        if ($metric) {
            $metric->increment('saved');
            $metric->save();
        }

        return response()->json(['success' => 'IMRAD saved successfully.']);
    }

    public function unsave(Request $request, $imrad)
    {

        $user = $request->user();
        $metric = ImradMetric::where('imradID', $imrad)->first();

        $savedEntry = MyLibrary::where('user_code', $user->user_code)
        ->where('user_type', $user->type)
        ->where('imrad_id', $imrad)
        ->first();

        if (!$savedEntry) {
            return redirect()->back()->with('error', 'IMRAD not found in your library.');
        }

        $savedEntry->delete();

        if ($metric && $metric->saved > 0) {
            $metric->decrement('saved');
        }

        return response()->json(['success' => 'IMRAD unsaved successfully.']);
    }
}
