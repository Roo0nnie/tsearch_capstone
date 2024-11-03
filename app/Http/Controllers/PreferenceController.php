<?php

namespace App\Http\Controllers;


use App\Models\Imrad;
use App\Models\Preference;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;


class PreferenceController extends Controller
{
    public function view()
    {

        $authors = Imrad::select('author')->get();
        $advisers = Imrad::select('adviser')->get();
        $departments = Imrad::select('department')->distinct()->get();

        $authorList = [];
        $adviserList = [];
        $departmentList = $departments->pluck('department')->toArray();

        foreach ($authors as $author) {
            $names = explode(',', $author->author);
            foreach ($names as $name) {
                $trimmedName = trim($name);
                if (!in_array($trimmedName, $authorList)) {
                    $authorList[] = $trimmedName;
                }
            }
        }

        foreach ($advisers as $adviser) {
            $names = explode(',', $adviser->adviser);
            foreach ($names as $name) {
                $trimmedName = trim($name);
                if (!in_array($trimmedName, $adviserList)) {
                    $adviserList[] = $trimmedName;
                }
            }
        }

        $user_code = Auth::user()->user_code;
        $userPreferences = Preference::where('user_code', $user_code)->first();

        $selectedAuthors = $userPreferences ? explode(',', $userPreferences->authors) : [];
        $selectedAdvisers = $userPreferences ? explode(',', $userPreferences->advisers) : [];
        $selectedDepartments = $userPreferences ? explode(',', $userPreferences->departments) : [];

        return view('user_preference.user_preference', compact(
            'authorList',
            'adviserList',
            'departmentList',
            'selectedAuthors',
            'selectedAdvisers',
            'selectedDepartments'
        ));
    }

    public function save(Request $request)
    {

        // $validated = $request->validate([
        //     'authors' => 'required|array|min:1',
        //     'advisers' => 'required|array|min:1',
        //     'departments' => 'required|array|min:1',
        // ]);

         $validated = $request->validate([
            'authors' => 'required|array|min:1',
            // 'advisers' => 'required|array|min:1',
            'departments' => 'required|array|min:1',
        ]);

        $user_code = Auth::user()->user_code;

        $UserExist = Preference::where('user_code', $user_code)->first();

        $data = [
            'authors' => implode(',', $validated['authors']),
            // 'advisers' => implode(',', $validated['advisers']),
            'departments' => implode(',', $validated['departments']),
        ];

        if ($UserExist) {
            $UserExist->update($data);
        } else {
            Preference::create(array_merge(['user_code' => $user_code], $data));
        }

        return redirect()->back()->with('success', 'Preferences saved successfully.');
    }
}
