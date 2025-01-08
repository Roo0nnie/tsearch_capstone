<?php

namespace App\Http\Controllers;

use App\Models\Announcement;
use App\Models\Imrad; // Use proper casing for model names
use App\Models\User;
use App\Models\Rating;
use App\Models\ImradMetric;
use App\Models\Admin;

use App\Models\Preference;
use Illuminate\Http\Request;

use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Pagination\LengthAwarePaginator;

use App\Services\SpellCheckerService;
use Illuminate\Support\Facades\Log;
use PhpSpellcheck\Spellchecker\Aspell;

class GuestController extends Controller
{
    protected $spellCheckerService;

    public function __construct(SpellCheckerService $spellCheckerService)
    {
        $this->spellCheckerService = $spellCheckerService;
    }

    public function index(Request $request)
    {
        $announcements = Announcement::where('activation', 'Activate')->get();
        $query = $request->input('query', '');

        $admins = Admin::all();

        if (!is_string($query)) {
            $query = '';
        }

        $querySuggestions = $this->spellCheckerService->autoCorrectText($query);

        $noResults = false;
        $noAnnouncements = false;

        if ($query) {

            $imrads = Imrad::with('imradMetric')->where('status', 'published')->where('action', null)
                ->where(function ($q) use ($query) {
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

            $imrads = $imrads->map(function ($item) use ($query) {
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

            // Sort by rating first and then by occurrences
            $imrads = $imrads->sortByDesc(function ($item) {
                return $item->imradMetric ? $item->imradMetric->rates : 0;
            })->sortByDesc('occurrences');

            // Paginate the results
            $currentPage = $request->input('page', 1);
            $perPage = 2;
            $currentItems = $imrads->slice(($currentPage - 1) * $perPage, $perPage)->values();

            $imrads = new LengthAwarePaginator($currentItems, $imrads->count(), $perPage, $currentPage, [
                'path' => $request->url(),
                'query' => $request->query(),
            ]);

            if ($imrads->total() === 0) {
                $noResults = true;
            }
        } else {

            $imrads = Imrad::with('imradMetric')->where('status', 'published')->where('action', null)->get();

            $imrads = $imrads->sortByDesc(function ($item) {
                return [$item->preferenceScore, $item->imradMetric ? $item->imradMetric->rates : 0];
            });

            $currentPage = $request->input('page', 1);
            $perPage = 2;
            $currentItems = $imrads->slice(($currentPage - 1) * $perPage, $perPage)->values();

            $imrads = new LengthAwarePaginator($currentItems, $imrads->count(), $perPage, $currentPage, [
                'path' => $request->url(),
                'query' => $request->query(),
            ]);
        }

        if ($announcements->isEmpty()) {
            $noAnnouncements = true;
        }

        $SDGMapping = [
            1 => 'No Poverty',
            2 => 'Zero Hunger',
            3 => 'Good Health and Well-being',
            4 => 'Quality Education',
            5 => 'Gender Equality',
            6 => 'Clean Water and Sanitation',
            7 => 'Affordable and Clean Energy',
            8 => 'Decent Work and Economic Growth',
            9 => 'Industry, Innovation, and Infrastructure',
            10 => 'Reduced Inequalities',
            11 => 'Sustainable Cities and Communities',
            12 => 'Responsible Consumption and Production',
            13 => 'Climate Action',
            14 => 'Life Below Water',
            15 => 'Life on Land',
            16 => 'Peace, Justice, and Strong Institutions',
            17 => 'Partnerships for the Goals',
        ];

        $authors = Imrad::select('author')->get();
        $advisers = Imrad::select('adviser')->get();
        $categories = Imrad::select('category')->distinct()->get();
        $departments = Imrad::select('department')->distinct()->get();
        $years = Imrad::select('publication_date')->distinct()->get();
        $SDGs = Imrad::select('SDG')->get();



        $SDGNO = [];
        $SDGList = [];
        $authorList = [];
        $adviserList = [];
        $categories = $categories->pluck('category')->toArray();
        $departmentList = $departments->pluck('department')->toArray();
        $yearList = [];

        sort($categories);

        foreach ($SDGs as $SDG) {
            // Split the SDG values by comma
            $sdgArray = explode(',', $SDG->SDG);

            foreach ($sdgArray as $sdgItem) {
                $trimmedName = trim($sdgItem);
                $sdgNumber = (int)$trimmedName;

                if (!in_array($sdgNumber, $SDGNO)) {
                    $SDGNO[] = $sdgNumber;
                    if (isset($SDGMapping[$sdgNumber])) { $SDGList[$sdgNumber] = $SDGMapping[$sdgNumber];
                    }
                }
            }
        }

        foreach ($SDGs as $SDG) {
            $SDG = explode(',', $SDG->SDG);
            foreach ($SDG as $SDG) {
                $trimmedName = trim($SDG);
                if (!in_array($trimmedName, $SDGNO)) {
                    $SDGNO[] = $trimmedName;
                }
            }
        }

        sort($SDGList);

        foreach ($years as $year) {
            $year = substr($year->publication_date, -4);
            if (!in_array($year, $yearList)) {
                $yearList[] = $year;
            }
        }

        rsort($yearList);

        foreach ($authors as $author) {
            $names = explode(',', $author->author);
            foreach ($names as $name) {
                $trimmedName = trim($name);
                if($trimmedName != 'R.M.' && $trimmedName != 'BSM' && $trimmedName != 'R.M') {
                    if (!in_array($trimmedName, $authorList)) {
                        $authorList[] = $trimmedName;
                    }
                }
            }
        }
        sort($authorList);

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
        $imradList = Imrad::with('imradMetric')->where('status', 'published')->where('action', null)->get();

        return view('guest.guestLayout', compact('imrads','categories','imradList',  'noResults', 'announcements', 'noAnnouncements', 'query', 'querySuggestions', 'admins', 'authorList', 'adviserList', 'departmentList', 'yearList', 'SDGList', 'admins'));
    }

    protected function applyFilters(Request $request, $query)
{
    if ($request->filled('author')) {
        $authors = $request->input('author');
        $query->where(function ($q) use ($authors) {
            foreach ($authors as $author) {
                $author = trim($author);
                $q->orWhereRaw("FIND_IN_SET(?, REPLACE(author, ', ', ','))", [$author]);
            }
        });
    }

    if ($request->filled('adviser')) {
        $advisers = $request->input('adviser');
        $query->where(function ($q) use ($advisers) {
            foreach ($advisers as $adviser) {
                $q->orWhereRaw("FIND_IN_SET(?, adviser)", [$adviser]);
            }
        });
    }

    if ($request->filled('year')) {
        $years = $request->input('year');
        $query->where(function ($q) use ($years) {
            foreach ($years as $year) {
                $q->orWhere('publication_date', 'like', '%' . $year);
            }
        });
    }

    if ($request->filled('category')) {
        $categories = $request->input('category');
        $query->whereIn('category', $categories);
    }

    if ($request->filled('department')) {
        $departments = $request->input('department');
        $query->whereIn('department', $departments);
    }

    if ($request->filled('SDG')) {
        $sdgs = array_map('trim', $request->input('SDG'));
        $query->where(function ($q) use ($sdgs) {
            foreach ($sdgs as $sdg) {
                $q->orWhereRaw("FIND_IN_SET(?, REPLACE(SDG, ' ', ''))", [$sdg]);
            }
        });
    }
}
public function filterFiles(Request $request)
{
    $announcements = Announcement::where('activation', 'Active')->get();
    $admins = Admin::all();

    if ($request->input('filter')) {
        $sortBy = $request->input('sort_by', 'rate');
        $query = Imrad::with('imradMetric')->where('status', 'published')->where('action', null);

        $this->applyFilters($request, $query);

        if ($sortBy === 'year') {
            $query->orderBy('publication_date', 'desc');
        }

        $imrads = $query->get();

        if($sortBy != 'year') {
            $imrads = $imrads->sortByDesc(function ($item) {
                return [$item->imradMetric ? $item->imradMetric->rates : 0];
            });
        }

        $currentPage = $request->input('page', 1);
            $perPage = 2;
            $currentItems = $imrads->slice(($currentPage - 1) * $perPage, $perPage)->values();

            $imrads = new LengthAwarePaginator($currentItems, $imrads->count(), $perPage, $currentPage, [
                'path' => $request->url(),
                'query' => $request->query(),
            ]);

        $noResults = false;
        $noAnnouncements = false;

        if ($announcements->isEmpty()) {
            $noAnnouncements = true;
        }

        // SDG Mapping
        $SDGMapping = [
            1 => 'No Poverty',
            2 => 'Zero Hunger',
            3 => 'Good Health and Well-being',
            4 => 'Quality Education',
            5 => 'Gender Equality',
            6 => 'Clean Water and Sanitation',
            7 => 'Affordable and Clean Energy',
            8 => 'Decent Work and Economic Growth',
            9 => 'Industry, Innovation, and Infrastructure',
            10 => 'Reduced Inequalities',
            11 => 'Sustainable Cities and Communities',
            12 => 'Responsible Consumption and Production',
            13 => 'Climate Action',
            14 => 'Life Below Water',
            15 => 'Life on Land',
            16 => 'Peace, Justice, and Strong Institutions',
            17 => 'Partnerships for the Goals',
        ];

        // Fetch authors, advisers, departments, years, and SDGs
        $authors = Imrad::select('author')->where('status', 'published')->where('action', null)->get();
        $advisers = Imrad::select('adviser')->where('status', 'published')->where('action', null)->get();
        $categories = Imrad::select('category')->where('status', 'published')->where('action', null)->distinct()->get();
        $departments = Imrad::select('department')->where('status', 'published')->where('action', null)->distinct()->get();
        $years = Imrad::select('publication_date')->where('status', 'published')->where('action', null)->distinct()->get();
        $SDGs = Imrad::select('SDG')->where('status', 'published')->where('action', null)->get();

        // Initialize arrays
        $SDGNO = [];
        $SDGList = [];
        $authorList = [];
        $adviserList = [];
        $categories = $categories->pluck('category')->toArray();
        $departmentList = $departments->pluck('department')->toArray();
        $yearList = [];

        // Process SDGs
        foreach ($SDGs as $SDG) {
            $sdgArray = explode(',', $SDG->SDG);
            foreach ($sdgArray as $sdgItem) {
                $trimmedName = trim($sdgItem);
                $sdgNumber = (int)$trimmedName;

                if (!in_array($sdgNumber, $SDGNO)) {
                    $SDGNO[] = $sdgNumber;
                    if (isset($SDGMapping[$sdgNumber])) {
                        $SDGList[$sdgNumber] = $SDGMapping[$sdgNumber];
                    }
                }
            }
        }

        sort($categories);
        sort($SDGList);

        // Process years
        foreach ($years as $year) {
            $year = substr($year->publication_date, -4);
            if (!in_array($year, $yearList)) {
                $yearList[] = $year;
            }
        }

        rsort($yearList);

        // Process authors
        foreach ($authors as $author) {
            $names = explode(',', $author->author);
            foreach ($names as $name) {
                $trimmedName = trim($name);
                if($trimmedName != 'R.M.' && $trimmedName != 'BSM' && $trimmedName != 'R.M') {
                    if (!in_array($trimmedName, $authorList)) {
                        $authorList[] = $trimmedName;
                    }
                }
            }
        }

        // Process advisers
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
        sort($authorList);

        $querySuggestions = '';
        $query = '';

        $imradList = Imrad::with('imradMetric')->where('status', 'published')->where('action', null)->get();

        return view('guest.guestLayout', compact('imrads', 'query', 'imradList' , 'categories', 'noResults', 'announcements', 'noAnnouncements', 'querySuggestions', 'admins', 'authorList', 'adviserList', 'departmentList', 'yearList', 'SDGList'));
    }
}

    public function viewFile(Imrad $imrad)
    {
        $admins = Admin::all();
        $announcements = Announcement::where('activation', 'Active')->get();
        $noAnnouncements = $announcements->isEmpty();

        return view('main_layouts.file', [
            'admins' => $admins,
            'imrad' => $imrad,
            'noAnnouncements' => $noAnnouncements
        ]);
    }
}
