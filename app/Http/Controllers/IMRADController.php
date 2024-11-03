<?php

namespace App\Http\Controllers;

use App\Models\Imrad;
use App\Models\ImradMetric;
use App\Models\TempFile;
use App\Models\Archive;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Smalot\PdfParser\Parser;

use Symfony\Component\Process\Exception\ProcessFailedException;
use Symfony\Component\Process\Process;
use Illuminate\Support\Facades\Log;
use Illuminate\Validation\Rule;



class IMRADController extends Controller
{

    public function view(Request $request)
    {
        $filter_type = $request->input('filter_type');

        if ($filter_type === 'published') {
            $query = Imrad::query();

            $this->applyFilters($request, $query);

            $imrads = $query->get();
            $archives = Imrad::where('status', 'archive')->where('action', null)->get();
            $tempfiles = TempFile::all();

            return view('admin.admin_page.IMRAD.imrad', compact('imrads', 'archives', 'tempfiles'));
        }

        if ($filter_type === 'archive') {
            $query = Imrad::query();

            // Apply filters if any
            $this->applyFilters($request, $query);

            $archives = $query->get();
            $imrads = Imrad::where('status', 'published')->where('action', null)->get();
            $tempfiles = TempFile::all();

            return view('admin.admin_page.IMRAD.imrad', compact('imrads', 'archives', 'tempfiles'));
        }

        if ($filter_type === 'draft') {
            $query = TempFile::query();

            $this->applyFilters($request, $query);

            $tempfiles = $query->get();
            $archives = Imrad::where('status', 'archive')->where('action', null)->get();
            $imrads = Imrad::where('status', 'published')->where('action', null)->get();

            return view('admin.admin_page.IMRAD.imrad', compact('imrads', 'archives', 'tempfiles'));
        }

        // Handle other filter types if needed
        $imrads = Imrad::where('status', 'published')->where('action', null)->get();
        $archives = Imrad::where('status', 'archive')->where('action', null)->get();
        $tempfiles = TempFile::all();
        return view('admin.admin_page.IMRAD.imrad', compact('imrads', 'archives', 'tempfiles'));
    }

    protected function applyFilters(Request $request, $query)
    {
        if ($request->filled('author')) {
            $query->where('author', 'like', '%' . $request->author . '%');
        }
        if ($request->filled('adviser')) {
            $query->where('adviser', 'like', '%' . $request->adviser . '%');
        }
        if ($request->filled('department')) {
            $query->where('department', 'like', '%' . $request->department . '%');
        }
        if ($request->filled('publication_month')) {
            $query->where('publication_date', 'like', '%' . $request->publication_month . '%');
        }
        if ($request->filled('publication_year')) {
            $query->where('publication_date', 'like', '%' . $request->publication_year . '%');
        }
        if ($request->filled('location')) {
            $query->where('location', 'like', '%' . $request->location . '%');
        }
        if ($request->filled('SDG')) {
            $query->where('SDG', 'like', '%' . $request->SDG . '%');
        }
    }

    public function archive(Imrad $imrad)
    {

        $imrad->update([
            'status' => 'archive',
        ]);

        // $archive->save();

        return redirect()->route('admin.imrad')->with('success', 'File moved to archive successfully.');
    }

    public function return(Imrad $archive)
    {

        $archive->update([
            'status' => 'published',
        ]);

        return redirect()->route('admin.imrad')->with('success', 'File published successfully.');
    }

    public function searchImrad(Request $request)
    {
        $query = $request->input('query_imrad');

        $imrads = DB::table('imrads')
            ->select(
                'id',
                'department',
                'author',
                'adviser',
                'title',
                'abstract',
                'keywords',
                'awards',
                'SDG',
                'publication_date',
                'publisher',
                'location',
                'pdf_file'
            )
            ->where(function ($q) use ($query) {
                $q->where('department', 'like', '%' . $query . '%')
                    ->orWhere('author', 'like', '%' . $query . '%')
                    ->orWhere('adviser', 'like', '%' . $query . '%')
                    ->orWhere('title', 'like', '%' . $query . '%')
                    ->orWhere('abstract', 'like', '%' . $query . '%')
                    ->orWhere('keywords', 'like', '%' . $query . '%')
                    ->orWhere('awards', 'like', '%' . $query . '%')
                    ->orWhere('SDG', 'like', '%' . $query . '%')
                    ->orWhere('publication_date', 'like', '%' . $query . '%')
                    ->orWhere('publisher', 'like', '%' . $query . '%')
                    ->orWhere('location', 'like', '%' . $query . '%')
                    ->orWhere('pdf_file', 'like', '%' . $query . '%');
            })
            ->get();

        $imrads = $imrads->map(function ($item) use ($query) {
            $queryLower = strtolower($query);
            $item->occurrences = (
                substr_count(strtolower($item->department), $queryLower) +
                substr_count(strtolower($item->author), $queryLower) +
                substr_count(strtolower($item->adviser), $queryLower) +
                substr_count(strtolower($item->title), $queryLower) +
                substr_count(strtolower($item->abstract), $queryLower) +
                substr_count(strtolower($item->keywords), $queryLower) +
                substr_count(strtolower($item->awards), $queryLower) +
                substr_count(strtolower($item->publication_date), $queryLower) +
                substr_count(strtolower($item->publisher), $queryLower) +
                substr_count(strtolower($item->location), $queryLower) +
                substr_count(strtolower($item->pdf_file), $queryLower)
            );
            return $item;
        });


        $imrads = $imrads->sortByDesc('occurrences');

        return response()->json($imrads);
    }

    public function searchTemp(Request $request)
    {
        $query = $request->input('query_temp');

        $temp = DB::table('temp_files')
            ->select(
                'id',
                'department',
                'author',
                'adviser',
                'title',
                'abstract',
                'keywords',
                'awards',
                'SDG',
                'publication_date',
                'publisher',
                'location',
                'pdf_file'
            )
            ->where(function ($q) use ($query) {
                $q->where('department', 'like', '%' . $query . '%')
                    ->orWhere('author', 'like', '%' . $query . '%')
                    ->orWhere('adviser', 'like', '%' . $query . '%')
                    ->orWhere('title', 'like', '%' . $query . '%')
                    ->orWhere('abstract', 'like', '%' . $query . '%')
                    ->orWhere('keywords', 'like', '%' . $query . '%')
                    ->orWhere('awards', 'like', '%' . $query . '%')
                    ->orWhere('SDG', 'like', '%' . $query . '%')
                    ->orWhere('publication_date', 'like', '%' . $query . '%')
                    ->orWhere('publisher', 'like', '%' . $query . '%')
                    ->orWhere('location', 'like', '%' . $query . '%')
                    ->orWhere('pdf_file', 'like', '%' . $query . '%');
            })
            ->get();

        $temp = $temp->map(function ($item) use ($query) {
            $queryLower = strtolower($query);
            $item->occurrences = (
                substr_count(strtolower($item->department), $queryLower) +
                substr_count(strtolower($item->author), $queryLower) +
                substr_count(strtolower($item->adviser), $queryLower) +
                substr_count(strtolower($item->title), $queryLower) +
                substr_count(strtolower($item->abstract), $queryLower) +
                substr_count(strtolower($item->keywords), $queryLower) +
                substr_count(strtolower($item->awards), $queryLower) +
                substr_count(strtolower($item->publication_date), $queryLower) +
                substr_count(strtolower($item->publisher), $queryLower) +
                substr_count(strtolower($item->location), $queryLower) +
                substr_count(strtolower($item->pdf_file), $queryLower)
            );
            return $item;
        });


        $temp = $temp->sortByDesc('occurrences');

        return response()->json($temp);
    }

    public function searchArchive(Request $request)
    {
        $query = $request->input('query_archive');

        $archive = DB::table('archives')
            ->select(
                'id',
                'department',
                'author',
                'adviser',
                'title',
                'abstract',
                'keywords',
                'awards',
                'SDG',
                'publication_date',
                'publisher',
                'location',
                'pdf_file'
            )
            ->where(function ($q) use ($query) {
                $q->where('department', 'like', '%' . $query . '%')
                    ->orWhere('author', 'like', '%' . $query . '%')
                    ->orWhere('adviser', 'like', '%' . $query . '%')
                    ->orWhere('title', 'like', '%' . $query . '%')
                    ->orWhere('abstract', 'like', '%' . $query . '%')
                    ->orWhere('keywords', 'like', '%' . $query . '%')
                    ->orWhere('awards', 'like', '%' . $query . '%')
                    ->orWhere('SDG', 'like', '%' . $query . '%')
                    ->orWhere('publication_date', 'like', '%' . $query . '%')
                    ->orWhere('publisher', 'like', '%' . $query . '%')
                    ->orWhere('location', 'like', '%' . $query . '%')
                    ->orWhere('pdf_file', 'like', '%' . $query . '%');
            })
            ->get();

        $archive = $archive->map(function ($item) use ($query) {
            $queryLower = strtolower($query);
            $item->occurrences = (
                substr_count(strtolower($item->department), $queryLower) +
                substr_count(strtolower($item->author), $queryLower) +
                substr_count(strtolower($item->adviser), $queryLower) +
                substr_count(strtolower($item->title), $queryLower) +
                substr_count(strtolower($item->abstract), $queryLower) +
                substr_count(strtolower($item->keywords), $queryLower) +
                substr_count(strtolower($item->awards), $queryLower) +
                substr_count(strtolower($item->publication_date), $queryLower) +
                substr_count(strtolower($item->publisher), $queryLower) +
                substr_count(strtolower($item->location), $queryLower) +
                substr_count(strtolower($item->pdf_file), $queryLower)
            );
            return $item;
        });


        $archive = $archive->sortByDesc('occurrences');

        return response()->json($archive);
    }

    public function create(TempFile $tempFile)
    {
        return view('admin.admin_page.IMRAD.imradCreate', ['article' => $tempFile]);
    }

    public function store(Request $request, Imrad $imrad)
    {
        $data = $request->validate([
            'id' => 'required|string|exists:temp_files,id',
            'title' => [
                'required',
                'string',

                Rule::unique('imrads')->where(function ($query) {
                    return $query->where('action', null);
                }),
            ],
            'author'  => 'required|string|max:255',
            'adviser' => 'nullable|string|max:255',
            'department' => 'required|string|max:255',
            'abstract' => 'required|string',
            'publisher' => 'nullable|string',
            'publication_date'  => 'required|string',
            'keywords' => 'nullable|string',
            'location' => 'nullable|string|unique:location,location',
            'SDG' => 'nullable|string',
            'volume' => 'nullable|string',
            'issue' => 'nullable|string',
        ]);

        $tempFile = TempFile::find($data['id']);
            if ($tempFile) {
                $pdf_file = $tempFile->pdf_file;
                $filePath = storage_path('app/' . $pdf_file);

                if ($pdf_file && file_exists($filePath)) {
                    $destinationPath = storage_path('app/public/pdf/' . basename($pdf_file));

                    if (rename($filePath, $destinationPath)) {
                        $tempFile->delete();
                    } else {
                        return back()->with('error', 'Failed to move the file to the pdf folder.');
                    }
                } else {
                    $tempFile->delete();
                }
            }

            $pdfPath = null;

            if ($tempFile && $tempFile->pdf_file) {
                $pdf_file = $tempFile->pdf_file;
                $pdfPath = 'public/pdf/' . basename($pdf_file);
            }

            // Create the new IMRAD record
            $imrad = Imrad::create([
                'title' => $data['title'],
                'author'  => $data['author'],
                'adviser' => $data['adviser'] ?? null,
                'department' => $data['department'] ?? null,
                'abstract' => $data['abstract'],
                'publisher' => $data['publisher'] ?? null,
                'publication_date'  => $data['publication_date']  ?? null,
                'keywords' => $data['keywords'] ??  null,
                'location' => $data['location']  ?? null,
                'SDG' => $data['SDG']  ?? null,
                'volume' => $data['volume']  ?? null,
                'issue' => $data['issue']  ?? null,
                'awards' => $data['awards']  ?? null,
                'pdf_file' => $pdfPath,
            ]);

            ImradMetric::create([
                'imradID' => $imrad->id,
                'rating' => 0,
                'no_click' => 0,
                'no_saved' => 0,
                'no_download' => 0,
            ]);

            return redirect()->route('admin.imrad')->with('success', 'Imrad created successfully.');

        // Proceed with temp file and PDF handling logic

    }

    public function edit(Imrad $imrad)
    {
        return view('admin.admin_page.IMRAD.imradEdit', ['imrad' => $imrad]);
    }

    public function editTemp(TempFile $tempfile)
    {
            return $this->create($tempfile);
    }

    public function update(Request $request, Imrad $imrad)
    {
        $data = $request->validate([
            'title' => 'required|string',
            'author'  => 'required|string|max:255',
            'adviser' => 'nullable|string|max:255',
            'department' => 'required|string|max:255',
            'abstract' => 'required|string',
            'publisher' => 'nullable|string',
            'publication_date'  => 'required|string',
            'keywords' => 'nullable|string',
            'location' => 'nullable|string',
            'SDG' => 'nullable|string',
            'volume' => 'nullable|string',
            'issue' => 'nullable|string',
            'pdf_file' => 'nullable|file|mimes:pdf',
        ]);

        $pdfPath = $imrad->pdf_file;
        if ($request->hasFile('pdf_file')) {
            $file = $request->file('pdf_file');
            $filename = $file->getClientOriginalName();
            $destinationPath = storage_path('app\public\pdf');

            if (file_exists($destinationPath . '/' . $filename)) {
                $pdfPath = $file->storeAs($pdfPath);
            } else {

                if ($pdfPath && file_exists(storage_path('app/' . $pdfPath))) {
                    unlink(storage_path('app/' . $pdfPath));
                }

                $pdfPath = $file->storeAs('public/pdf', $filename);
            }
        }

        $imrad->update([
            'title' => $data['title'],
            'author'  => $data['author'],
            'adviser' => $data['adviser'],
            'department' => $data['department'],
            'abstract' => $data['abstract'],
            'publisher' => $data['publisher'],
            'publication_date'  => $data['publication_date'],
            'keywords' => $data['keywords'],
            'location' => $data['location'],
            'SDG' => $data['SDG'],
            'volume' => $data['volume'],
            'issue' => $data['issue'],
            'pdf_file' => $pdfPath,
        ]);

        return redirect()->route('admin.imrad')->with('success', 'Imrad updated successfully.');
    }

    public function destroy(Imrad $imrad)
    {


        $imrad->update([
            'action' => 'deleted',
            'deleted_time' => now(),
            'delete_by' => auth()->user()->user_code,
            'permanent_delete' => now()->addDays(30),
            'created_at' => now(),
            'updated_at' => now(),
        ]);

        return redirect()->route('admin.imrad')->with('success', 'The file have 30 days to deleted');
    }

    public function destroyTemp(TempFile $temp)
    {

        $pdf_file = $temp->pdf_file;
        $filePath = storage_path('app/' . $pdf_file);

        if ($pdf_file && file_exists($filePath)) {
            unlink($filePath);
        }

        $temp->delete();

        return redirect()->route('admin.imrad')->with('success', 'File deleted successfully.');

    }


    public function destroyArhive(Imrad $archive)
    {

        $archive->update([
            'action' => 'deleted',
            'deleted_time' => now(),
            'delete_by' => auth()->user()->user_code,
            'permanent_delete' => now()->addDays(30),
            'created_at' => now(),
            'updated_at' => now(),
        ]);

        return redirect()->route('admin.imrad')->with('success', 'The file have 30 days to deleted');
    }

        public function pdfscan(Request $request)
    {
        // Validate the incoming request
        $data = $request->validate([
            'file' => 'required|mimes:pdf',
        ]);

        // Get the uploaded file
        $file = $request->file('file');

        // Create a new TempFile entry to get the `id` before saving the file
        $tempData = [
            'publisher' => null, // Placeholder, as you'll update this later
            'title' => null,
            'author' => null,
            'adviser' => null,
            'department' => null,
            'abstract' => null,
            'publication_date' => null,
            'keywords' => null,
            'SDG' => null,
            'issue' => null,
            'volume' => null,
            'pdf_file' => null,
        ];

        $temp = TempFile::create($tempData);

        $originalName = pathinfo($file->getClientOriginalName(), PATHINFO_FILENAME);
        $extension = $file->getClientOriginalExtension();

        $filename = $originalName . '_' . $temp->id . '.' . $extension;

        $destinationPath = 'public/temp';

        $filePath = $file->storeAs($destinationPath, $filename);
        $pdfPath = storage_path('app/' . $filePath);

        $pythonExecutable = 'C:\Users\tsear\AppData\Local\Programs\Python\Python312\python.exe';
        $pythonScriptPath = 'C:\xampp\htdocs\Capstone_System\public\storage\scripts\pdfscan.py';

        $command = [
            $pythonExecutable,
            $pythonScriptPath,
            $pdfPath
        ];

        Log::info('Executing command: ' . implode(' ', $command));

        $process = new Process($command);
        $process->setTimeout(null);

        try {
            $process->mustRun();
            $output = $process->getOutput();

            // Extract relevant information from the output
            $title = $this->extractTitle($output);
            $adviser = $this->extractAdviserName($output);
            $department = $this->extractDepartment($output);
            $abstract = $this->extractAbstract($output);
            $authors = $this->extractAuthors($output);
            $keywords = $this->extractKeywords($output);
            $SDG = $this->extractSDG($output);
            $date = $this->extractDate($output);
            $issue = $this->extractIssue($output);
            $publisher = $this->extractPublisher($output);
            $volume = $this->extractVol($output);

            // Ensure UTF-8 encoding for all extracted data
            $title = $this->ensureUtf8Encoding($title);
            $adviser = $this->ensureUtf8Encoding($adviser);
            $department = $this->ensureUtf8Encoding($department);
            $abstract = $this->ensureUtf8Encoding($abstract);
            $authors = $this->ensureUtf8Encoding($authors);
            $keywords = $this->ensureUtf8Encoding($keywords);
            $SDG = $this->ensureUtf8Encoding($SDG);
            $date = $this->ensureUtf8Encoding($date);
            $issue = $this->ensureUtf8Encoding($issue);
            $volume = $this->ensureUtf8Encoding($volume);
            $publisher = $this->ensureUtf8Encoding($publisher);


            $temp->update([
                'publisher' => $publisher,
                'title' => $title,
                'author' => $authors,
                'adviser' => $adviser,
                'department' => $department,
                'abstract' => $abstract,
                'publication_date' => $date,
                'keywords' => $keywords,
                'SDG' => $SDG,
                'issue' => $issue,
                'volume' => $volume,
                'pdf_file' => $filePath,
            ]);

            return $this->create($temp);

        } catch (ProcessFailedException $exception) {
            // Handle the process failure
            Log::error('Process failed: ' . $exception->getMessage());
            return redirect()->back()->with('error', 'Failed to process the PDF file.');
        }
    }


    private function ensureUtf8Encoding(?string $data): string
    {
        if (is_null($data)) {
            return '';
        }

        if (mb_check_encoding($data, 'UTF-8')) {
            return $data;
        }

        return mb_convert_encoding($data, 'UTF-8', 'ISO-8859-1');
    }

    private function extractTitle($text)
    {

        $lines = preg_split('/\r\n|\r|\n/', $text);
        $title = '';
        $inAuthorsSection = false;

        $volumePattern = '/^(SORSOGON STATE UNIVERSITY PUBLICATION AND KNOWLEDGE MANAGEMENT UNIT|THESIS MANAGEMENT SYSTEM Issue \d+ Volume \d+)/i';
        $middleInitialPattern = '/RESEARCHERS/';

        foreach ($lines as $line) {
            $trimmedLine = trim($line);

            if (stripos($trimmedLine, 'RESEARCHERS') !== false) {
                $inAuthorsSection = true;
                break;
            }
            if (preg_match($volumePattern, $trimmedLine)) {
                $titleFound = true;
                continue;
            }

            if (!$inAuthorsSection && !preg_match($middleInitialPattern, $trimmedLine)) {
                $title .= $trimmedLine . ' ';
            }
        }

        $title = trim($title);
        return $title ?? '';
    }

    private function extractPublisher($text)
    {
        $lines = preg_split('/\r\n|\r|\n/', $text);
        $lines[0] = str_replace('PUBLICATION AND KNOWLEDGE MANAGEMENT UNIT', '', $lines[0]);
        $lines[0] = trim($lines[0]);
        return $lines[0] ?? '';
    }

    private function extractSDG($text)
    {
        // Collected by numbers of SDG
        $collectedContent = [];
        preg_match_all('/Sustainable Development Goals:\s*(.*?)(?=\n\n|\Z)/is', $text, $matches);

        $collectedContent = $matches[1];

        $numbers = [];
        foreach ($collectedContent as $content) {
            preg_match_all('/\d+/', $content, $contentNumbers);
            $numbers = array_merge($numbers, $contentNumbers[0]);
        }

        return implode(", ", $numbers);

        $collectedContent = [];
        preg_match_all('/Sustainable Development Goals:\s*(.*?)(?=\n\n|\Z)/is', $text, $matches);

        $collectedContent = $matches[1];

        $sdgDetails = [];
        foreach ($collectedContent as $content) {
            preg_match_all('/(\d+)\s*([A-Za-z\s,]+)/', $content, $sdgMatches);
            foreach ($sdgMatches[1] as $index => $number) {
                $sdgDetails[] = $number . ' ' . trim($sdgMatches[2][$index]);
            }
        }

        return implode(", ", $sdgDetails);

        // $collectedContent = [];
        // preg_match_all('/Sustainable Development Goals:\s*(.*?)(?=\n\n|\Z)/is', $text, $matches);

        // // Collect all matched content after each instance
        // $collectedContent = $matches[1];

        // // Step 2: Extract only SDG names, removing numbers and newlines
        // $sdgNames = [];
        // foreach ($collectedContent as $content) {
        //     // Remove numbers and trim whitespace from each line
        //     $cleanedContent = preg_replace('/\d+/', '', $content);  // Remove numbers
        //     $cleanedContent = preg_replace('/\r\n|\r|\n/', ' ', $cleanedContent);  // Replace line breaks with spaces
        //     $sdgNames[] = trim($cleanedContent); // Trim any surrounding whitespace
        // }

        // // Convert SDG names into a comma-separated string
        // return implode(", ", $sdgNames);
    }

    private function extractIssue($text)
    {
        preg_match('/Issue\s*(\d+)\s*Volume\s*(\d+)/i', $text, $matches);
        $issueVolume = '';
    if (!empty($matches)) {
        $issueVolume = $matches[1];
    }

    $issueVolume = preg_replace('/\r\n|\r|\n/', ' ', trim($issueVolume));

    return $issueVolume ?? '';

    }

    private function extractVol($text)
    {
        preg_match('/Issue\s*(\d+)\s*Volume\s*(\d+)/i', $text, $matches);
        $issueVolume = '';
    if (!empty($matches)) {
        $issueVolume = $matches[2];

    }

    $issueVolume = preg_replace('/\r\n|\r|\n/', ' ', trim($issueVolume));

    return $issueVolume ?? '';

    }

    private function extractDepartment($text)
    {
        // preg_match('/Sorsogon State University,\s*([\w\s]+?)(?=\s*\n|,|$)\s*(January|February|March|April|May|June|July|August|September|October|November|December)/i', $text, $matches);
        // $department = $matches[1] ?? '';
        // $department = preg_replace('/\r\n|\r|\n/', ' ', trim($department));
        // return $department;

        // $start = 'Sorsogon State University,';
        // $months = 'January|February|March|April|May|June|July|August|September|October|November|December';

        // $pattern = '/'. preg_quote($start, '/') .'\s*([\w\s\-&,]+?)\s*(?=\b(?:' . $months . ')\b)/i';
        // preg_match($pattern, $text, $matches);
        // $department = isset($matches[1]) ? trim(preg_replace('/\s+/', ' ', $matches[1])) : '';

        // return $department;

        preg_match('/Sorsogon State University,\s*(.*?)(?=\n\s*(January|February|March|April|May|June|July|August|September|October|November|December|\w+:))/is', $text, $matches);

        $department = $matches[1] ?? '';
        $department = preg_replace('/\r\n|\r|\n/', ' ', $department);

        return $department;

    }

    private function extractDate($text)
    {
        // preg_match('/Sorsogon State University,\s*Department of [\w\s]+?\s*(January|February|March|April|May|June|July|August|September|October|November|December)\s+(\d{1,2}),\s+(\d{4})\s*Abstract/i', $text, $matches);

        // $date = $matches[1].' '.$matches[2].', '.$matches[3] ?? '';

        // $date = preg_replace('/\r\n|\r|\n/', ' ', trim($date));

        // return $date;

        // preg_match('/Sorsogon State University,\s*(January|February|March|April|May|June|July|August|September|October|November|December)\s+(\d{1,2}),\s+(\d{4})\s*SORSOGON STATE UNIVERSITY/i', $text, $matches);

        // $date = $matches[3] ?? '';

        // $date = preg_replace('/\r\n|\r|\n/', ' ', trim($date));

        // return $date;

        // preg_match('/Sorsogon State University,\s*(.*?)(?=\n\s*(January|February|March|April|May|June|July|August|September|October|November|December|\w+:))/is', $text, $matches);

        // $department = $matches[1] ?? '';
        // $department = preg_replace('/\r\n|\r|\n/', ' ', $department);

        // return $department;

        // $collectedContent = [];
        // preg_match_all('/Sorsogon State University,\s*(.*?)(?=\n\n|\Z)/is', $text, $matches);
        //
        // // Collect all matched content after each instance
        // $collectedContent = $matches[1];

        // // Step 2: Extract only SDG names, removing numbers and newlines
        // $sdgNames = [];
        // foreach ($collectedContent as $content) {
        //     // Remove numbers and trim whitespace from each line
        //     $cleanedContent = preg_replace('/\d+/', '', $content);  // Remove numbers
        //     $cleanedContent = preg_replace('/\r\n|\r|\n/', ' ', $cleanedContent);  // Replace line breaks with spaces
        //     $sdgNames[] = trim($cleanedContent); // Trim any surrounding whitespace
        // }

        // // Convert SDG names into a comma-separated string
        // return implode(", ", $sdgNames);

        // preg_match('/Sorsogon State University,\s*(.*?)(?=\n\s*(SORSOGON STATE UNIVERSITY|\w+:))/is', $text, $matches);

        // $abstract = $matches[1] ?? '';
        // $abstract = preg_replace('/\r\n|\r|\n/', ' ', $abstract);

        // return $abstract;

        preg_match('/Sorsogon State University,\s*.*?.*?(\w+\s+\d{4})/is', $text, $matches);

    // Extracting the date from the captured group
        $date = $matches[1] ?? '';

        // Clean up any new line characters if present
        $date = preg_replace('/\r\n|\r|\n/', ' ', trim($date));

        return $date;

    }

    private function extractAbstract($text)
    {

        preg_match('/Abstract\s*(.*?)(?=\n\s*(Keywords|Introduction|Methods|Results|Discussion|Conclusion|\w+:))/is', $text, $matches);

        $abstract = $matches[1] ?? '';
        $abstract = preg_replace('/\r\n|\r|\n/', ' ', $abstract);

        return $abstract;
    }

    private function extractAuthors($text)
{

    $authors = [];
    $startParsing = false;
    $lines = explode("\n", $text);

    foreach ($lines as $line) {
        $trimmedLine = trim($line);

        if (preg_match('/RESEARCHERS/', $trimmedLine)) {
            $startParsing = true;
            continue;
        }

        if (stripos($trimmedLine, 'ADVISER') !== false) {
            break;
        }

        if ($startParsing) {
            $authors[] = $trimmedLine;
        }
    }

    return implode(", ", $authors);
}

    private function extractKeywords($text)
    {
        preg_match('/Keywords:\s*(.*?)\s*Sustainable Development Goals:/is', $text, $matches);

    if (!empty($matches[1])) {

        $keywords = preg_replace('/\s+/', ' ', trim($matches[1]));
        $keywords = preg_replace(['/([a-z])([A-Z])/', '/\,(?!\s)/', '/\;(?!\s)/'], ['$1 $2', ', ', '; '], $keywords);

        return $keywords;
    }

    return '';
    }

    private function extractAdviserName($text)
    {

        preg_match('/ADVISER\s*(.*?)\s*Sorsogon State University,/is', $text, $matches);

        if (!empty($matches[1])) {

            $keywords = preg_replace('/\s+/', ' ', trim($matches[1]));
            $keywords = preg_replace(['/([a-z])([A-Z])/', '/\,(?!\s)/', '/\;(?!\s)/'], ['$1 $2', ', ', '; '], $keywords);

            return $keywords;
        }

        return '';

        // $adviserPattern = '/\nAdviser\s*$/m';
        // $abstractPattern = '/\nAbstract\s*$/m';

        // $adviserPos = $abstractPos = false;
        // if (preg_match($adviserPattern, $text, $adviserMatch, PREG_OFFSET_CAPTURE)) {
        //     $adviserPos = $adviserMatch[0][1];
        // }
        // if (preg_match($abstractPattern, $text, $abstractMatch, PREG_OFFSET_CAPTURE)) {
        //     $abstractPos = $abstractMatch[0][1];
        // }

        // if ($adviserPos !== false && $abstractPos !== false && $abstractPos > $adviserPos) {

        //     $betweenText = substr($text, $adviserPos, $abstractPos - $adviserPos);

        //     $lines = preg_split('/\r\n|\r|\n/', $betweenText);

        //     foreach ($lines as $line) {
        //         $trimmedLine = trim($line);
        //         if (!empty($trimmedLine) && strpos($trimmedLine, '.') !== false) {
        //             $trimmedLine = preg_replace(['/([a-z])([A-Z])/', '/\.(?!\s)/'], ['$1 $2', '. '], $trimmedLine);
        //             return $trimmedLine;
        //         }
        //     }
        // }

        // return '';


    }

    public function imradview(Imrad $imrad) {

        $authorString = Imrad::where('id', $imrad->id)->pluck('author')->first();
        $authorsArray = explode(', ', $authorString);

        $SDG_list = Imrad::where('id', $imrad->id)->pluck('SDG')->first();
        $SDG_array = explode(', ', $SDG_list);

        return view('admin.admin_page.IMRAD.imrad-view', compact('imrad', 'authorsArray', 'SDG_array'));
    }

}
