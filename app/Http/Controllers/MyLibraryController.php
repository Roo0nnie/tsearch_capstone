<?php

namespace App\Http\Controllers;

use App\Models\Announcement;
use App\Models\MyLibrary;
use Illuminate\Http\Request;
use App\Models\ImradMetric;
use App\Models\Admin;
use Illuminate\Pagination\LengthAwarePaginator;
use App\Services\SpellCheckerService;

class MyLibraryController extends Controller
{

    protected $spellCheckerService;

    public function __construct(SpellCheckerService $spellCheckerService)
    {
        $this->spellCheckerService = $spellCheckerService;
    }
    public function index(Request $request)
    {

        $admins = Admin::all();
        $announcements = Announcement::where('activation', 'Activate')->get();
        $noAnnouncements = false;
        if ($announcements->isEmpty()) {
            $noAnnouncements = true;
        }

        $user_code = $request->user()->user_code;
        $query = $request->input('query', '');

        if (!is_string($query)) {
            $query = '';
        }

        $querySuggestions = $this->spellCheckerService->autoCorrectText($query);

        if ($query) {
            $savefiles = MyLibrary::with('imrad')->whereHas('imrad', function ($query) {$query->where('status', 'published')->where('action', null); })
            ->where('user_code', $user_code)
            ->whereHas('imrad', function ($q) use ($query) {
                $q->where('department', 'like', '%' . $query . '%')
                    ->orWhere('author', 'like', '%' . $query . '%')
                    ->orWhere('adviser', 'like', '%' . $query . '%')
                    ->orWhere('title', 'like', '%' . $query . '%')
                    ->orWhere('abstract', 'like', '%' . $query . '%')
                    ->orWhere('keywords', 'like', '%' . $query . '%')
                    ->orWhere('awards', 'like', '%' . $query . '%')
                    ->orWhere('publication_date', 'like', '%' . $query . '%')
                    ->orWhere('publisher', 'like', '%' . $query . '%')
                    ->orWhere('location', 'like', '%' . $query . '%')
                    ->orWhere('pdf_file', 'like', '%' . $query . '%');
            })
            ->get();

            $savefiles = $savefiles->map(function ($item) use ($query) {
                $item->occurrences = (
                    substr_count(strtolower($item->department), strtolower($query)) +
                    substr_count(strtolower($item->author), strtolower($query)) +
                    substr_count(strtolower($item->adviser), strtolower($query)) +
                    substr_count(strtolower($item->title), strtolower($query)) +
                    substr_count(strtolower($item->abstract), strtolower($query)) +
                    substr_count(strtolower($item->keywords), strtolower($query)) +
                    substr_count(strtolower($item->awards), strtolower($query)) +
                    substr_count(strtolower($item->publication_date), strtolower($query)) +
                    substr_count(strtolower($item->publisher), strtolower($query)) +
                    substr_count(strtolower($item->location), strtolower($query)) +
                    substr_count(strtolower($item->pdf_file), strtolower($query))
                );
                return $item;
            });

            $savefiles = $savefiles->sortByDesc(function ($item) {
                return $item->imradMetric ? $item->imradMetric->rates : 0;
            })->sortByDesc('occurrences');

            $currentPage = $request->input('page', 1);
            $perPage = 5;
            $currentItems = $savefiles->slice(($currentPage - 1) * $perPage, $perPage)->values();

            $savefiles = new LengthAwarePaginator($currentItems, $savefiles->count(), $perPage, $currentPage, [
                'path' => $request->url(),
                'query' => $request->query(),
            ]);

            $noResults = $savefiles->total() === 0;
        } else {

            $savefiles = MyLibrary::where('user_code', $user_code)->whereHas('imrad', function($query) {
                {$query->where('status', 'published')->where('action', null);}
            })->with('imrad')->get();

            $savefiles = $savefiles->sortByDesc(function ($item) {
                return $item->imradMetric ? $item->imradMetric->rates : 0;
            });

            $currentPage = $request->input('page', 1);
            $perPage = 5;
            $currentItems = $savefiles->slice(($currentPage - 1) * $perPage, $perPage)->values();

            $savefiles = new LengthAwarePaginator($currentItems, $savefiles->count(), $perPage, $currentPage, [
                'path' => $request->url(),
                'query' => $request->query(),
            ]);
        }


        return view('main_layouts.mylibrary', compact('querySuggestions','savefiles', 'announcements', 'noAnnouncements', 'admins', 'query'));
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

        // return response()->json(['success' => 'IMRAD unsaved successfully.']);
        return redirect()->back()->with('success', 'IMRAD unsaved successfully.');
    }

    public function searchSave(Request $request) {
        dd('sample');
    }
}
