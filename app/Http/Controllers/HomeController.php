<?php

namespace App\Http\Controllers;

use App\Models\Announcement;
use App\Models\Imrad;
use App\Models\User;
use App\Models\Rating;
use App\Models\ImradMetric;

use App\Models\Preference;
use Illuminate\Http\Request;

use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Pagination\LengthAwarePaginator;

use App\Services\SpellCheckerService;
use Illuminate\Support\Facades\Log;
use PhpSpellcheck\Spellchecker\Aspell;


class HomeController extends Controller
{

    protected $spellCheckerService;

    public function __construct(SpellCheckerService $spellCheckerService)
    {
        $this->spellCheckerService = $spellCheckerService;
    }

    public function autoCorrectText(string $text): string
    {
        if (empty($text)) {
            return $text;
        }

        // Escape text to ensure it's safe for shell execution
        $escapedText = escapeshellarg($text);

        // Command to run Aspell in WSL
        $command = "echo $escapedText | wsl aspell -a";

        // Execute the command and capture the output
        $output = shell_exec($command);

        // Log the output for debugging
        \Log::info('Aspell output: ' . $output);

        // Process the output to extract suggestions
        return $this->processAspellOutput($output, $text);
    }

    // =================== If execute, will redirect to home along with user data ==========================
    public function index(Request $request)
    {

        $announcements = Announcement::where('activation', 'Active')->get();
        $query = $request->input('query', '');

        if (!is_string($query)) {
            $query = '';
        }

        $querySuggestions = $this->spellCheckerService->autoCorrectText($query);


        $noResults = false;
        $noAnnouncements = false;

        $user_code = Auth::user()->user_code;
        $userPreferences = Preference::where('user_code', $user_code)->first();

        $preferredAuthors = $userPreferences ? explode(',', $userPreferences->authors) : [];
        $preferredAdvisers = $userPreferences ? explode(',', $userPreferences->advisers) : [];
        $preferredDepartments = $userPreferences ? explode(',', $userPreferences->departments) : [];

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

            // Count occurrences of the query in each record
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
            // Fetch all Imrad records if no query is provided
            $imrads = Imrad::with('imradMetric')->where('status', 'published')->where('action', null)->get();

            // Add user preference weight to each record
            $imrads = $imrads->map(function ($item) use ($preferredAuthors, $preferredAdvisers, $preferredDepartments) {
                $preferenceScore = 0;

                // Add weights if authors, advisers, or departments match user preferences
                if (in_array(trim($item->author), $preferredAuthors)) {
                    $preferenceScore += 5;
                }
                if (in_array(trim($item->adviser), $preferredAdvisers)) {
                    $preferenceScore += 3;
                }
                if (in_array(trim($item->department), $preferredDepartments)) {
                    $preferenceScore += 2;
                }

                // Add preferenceScore attribute to item
                $item->preferenceScore = $preferenceScore;
                return $item;
            });

            // Sort by user preferences first, then by rating and occurrences
            $imrads = $imrads->sortByDesc(function ($item) {
                return [$item->preferenceScore, $item->imradMetric ? $item->imradMetric->rates : 0];
            });

            // Paginate the results
            $currentPage = $request->input('page', 1);
            $perPage = 10;
            $currentItems = $imrads->slice(($currentPage - 1) * $perPage, $perPage)->values();

            $imrads = new LengthAwarePaginator($currentItems, $imrads->count(), $perPage, $currentPage, [
                'path' => $request->url(),
                'query' => $request->query(),
            ]);
        }

        if ($announcements->isEmpty()) {
            $noAnnouncements = true;
        }

        return view('home', compact('imrads', 'noResults', 'announcements', 'noAnnouncements', 'query', 'querySuggestions'));
    }


    public function viewFile(Imrad $imrad)
    {

        $announcements = Announcement::where('activation', 'Activate')->get();
        $noAnnouncements = $announcements->isEmpty();

        $user_code = Auth::user()->user_code;
        $rating = Rating::where('metric_id', $imrad->id)
            ->where('user_code', $user_code)
            ->first();

        return view('main_layouts.file', [
            'announcements' => $announcements,
            'imrad' => $imrad,
            'noAnnouncements' => $noAnnouncements,
            'rating' => $rating ? $rating->rating : null
        ]);
    }
}
