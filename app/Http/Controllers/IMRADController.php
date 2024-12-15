<?php

namespace App\Http\Controllers;

use App\Models\Imrad;
use App\Models\ImradMetric;
use App\Models\TempFile;
use App\Models\Archive;
use App\Models\SetDeleteDate;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Smalot\PdfParser\Parser;

use Symfony\Component\Process\Exception\ProcessFailedException;
use Symfony\Component\Process\Process;
use Illuminate\Support\Facades\Log;
use Illuminate\Validation\Rule;
use Illuminate\Support\Facades\Http;



class IMRADController extends Controller
{

    public function file_published(Request $request)
    {
        $filter_type = $request->input('filter_type');

        $authors = Imrad::select('author')->get();
        $advisers = Imrad::select('adviser')->get();
        $departments = Imrad::select('department')->distinct()->get();
        $years = Imrad::select('publication_date')->distinct()->get();

        $adviserList = [];
        $departmentList = $departments->pluck('department')->toArray();
        $yearList = [];



        foreach ($years as $year) {
            $year = substr($year->publication_date, -4);
            if (!in_array($year, $yearList)) {
                $yearList[] = $year;
            }
        }

        rsort($yearList);


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

        if ($filter_type === 'published') {
            $query = Imrad::query();

            $this->applyFilters($request, $query);

            $imrads = $query->where('status', 'published')->where('action', null)->get();
            $archives = Imrad::where('status', 'archive')->where('action', null)->get();
            $tempfiles = TempFile::all();

            return view('admin.admin_page.IMRAD.filePublished', compact('imrads', 'archives', 'tempfiles', 'yearList', 'adviserList', 'departmentList'));
        }

        if ($filter_type === 'archive') {
            $query = Imrad::query();

            $this->applyFilters($request, $query);

            $archives = $query->where('status', 'archive')->get();
            $imrads = Imrad::where('status', 'published')->where('action', null)->get();
            $tempfiles = TempFile::all();

            return view('admin.admin_page.IMRAD.filePublished', compact('imrads', 'archives', 'tempfiles', 'yearList', 'adviserList', 'departmentList'));
        }

        if ($filter_type === 'draft') {
            $query = TempFile::query();

            $this->applyFilters($request, $query);

            $tempfiles = $query->get();
            $archives = Imrad::where('status', 'archive')->where('action', null)->get();
            $imrads = Imrad::where('status', 'published')->where('action', null)->get();

            return view('admin.admin_page.IMRAD.filePublished', compact('imrads', 'archives', 'tempfiles', 'yearList', 'adviserList', 'departmentList'));
        }

        // Handle other filter types if needed
        $imrads = Imrad::where('status', 'published')->where('action', null)->get();
        $archives = Imrad::where('status', 'archive')->where('action', null)->get();
        $tempfiles = TempFile::all();
        return view('admin.admin_page.IMRAD.filePublished', compact('imrads', 'archives', 'tempfiles', 'yearList', 'adviserList', 'departmentList'));
    }

    public function file_archived(Request $request)
    {
        $filter_type = $request->input('filter_type');

        $authors = Imrad::select('author')->get();
        $advisers = Imrad::select('adviser')->get();
        $departments = Imrad::select('department')->distinct()->get();
        $years = Imrad::select('publication_date')->distinct()->get();

        $adviserList = [];
        $departmentList = $departments->pluck('department')->toArray();
        $yearList = [];



        foreach ($years as $year) {
            $year = substr($year->publication_date, -4);
            if (!in_array($year, $yearList)) {
                $yearList[] = $year;
            }
        }

        rsort($yearList);


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

        if ($filter_type === 'published') {
            $query = Imrad::query();

            $this->applyFilters($request, $query);

            $imrads = $query->where('status', 'published')->where('action', null)->get();
            $archives = Imrad::where('status', 'archive')->where('action', null)->get();
            $tempfiles = TempFile::all();

            return view('admin.admin_page.IMRAD.fileArchived', compact('imrads', 'archives', 'tempfiles', 'yearList', 'adviserList', 'departmentList'));
        }

        if ($filter_type === 'archive') {
            $query = Imrad::query();

            $this->applyFilters($request, $query);

            $archives = $query->where('status', 'archive')->get();
            $imrads = Imrad::where('status', 'published')->where('action', null)->get();
            $tempfiles = TempFile::all();

            return view('admin.admin_page.IMRAD.fileArchived', compact('imrads', 'archives', 'tempfiles', 'yearList', 'adviserList', 'departmentList'));
        }

        if ($filter_type === 'draft') {
            $query = TempFile::query();

            $this->applyFilters($request, $query);

            $tempfiles = $query->get();
            $archives = Imrad::where('status', 'archive')->where('action', null)->get();
            $imrads = Imrad::where('status', 'published')->where('action', null)->get();

            return view('admin.admin_page.IMRAD.fileArchived', compact('imrads', 'archives', 'tempfiles', 'yearList', 'adviserList', 'departmentList'));
        }

        // Handle other filter types if needed
        $imrads = Imrad::where('status', 'published')->where('action', null)->get();
        $archives = Imrad::where('status', 'archive')->where('action', null)->get();
        $tempfiles = TempFile::all();
        return view('admin.admin_page.IMRAD.fileArchived', compact('imrads', 'archives', 'tempfiles', 'yearList', 'adviserList', 'departmentList'));
    }

    public function file_draft(Request $request)
    {
        $filter_type = $request->input('filter_type');

        $authors = Imrad::select('author')->get();
        $advisers = Imrad::select('adviser')->get();
        $departments = Imrad::select('department')->distinct()->get();
        $years = Imrad::select('publication_date')->distinct()->get();

        $adviserList = [];
        $departmentList = $departments->pluck('department')->toArray();
        $yearList = [];



        foreach ($years as $year) {
            $year = substr($year->publication_date, -4);
            if (!in_array($year, $yearList)) {
                $yearList[] = $year;
            }
        }

        rsort($yearList);


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

        if ($filter_type === 'published') {
            $query = Imrad::query();

            $this->applyFilters($request, $query);

            $imrads = $query->where('status', 'published')->where('action', null)->get();
            $archives = Imrad::where('status', 'archive')->where('action', null)->get();
            $tempfiles = TempFile::all();

            return view('admin.admin_page.IMRAD.fileDraft', compact('imrads', 'archives', 'tempfiles', 'yearList', 'adviserList', 'departmentList'));
        }

        if ($filter_type === 'archive') {
            $query = Imrad::query();

            $this->applyFilters($request, $query);

            $archives = $query->where('status', 'archive')->get();
            $imrads = Imrad::where('status', 'published')->where('action', null)->get();
            $tempfiles = TempFile::all();

            return view('admin.admin_page.IMRAD.fileDraft', compact('imrads', 'archives', 'tempfiles', 'yearList', 'adviserList', 'departmentList'));
        }

        if ($filter_type === 'draft') {
            $query = TempFile::query();

            $this->applyFilters($request, $query);

            $tempfiles = $query->get();
            $archives = Imrad::where('status', 'archive')->where('action', null)->get();
            $imrads = Imrad::where('status', 'published')->where('action', null)->get();

            return view('admin.admin_page.IMRAD.fileDraft', compact('imrads', 'archives', 'tempfiles', 'yearList', 'adviserList', 'departmentList'));
        }

        // Handle other filter types if needed
        $imrads = Imrad::where('status', 'published')->where('action', null)->get();
        $archives = Imrad::where('status', 'archive')->where('action', null)->get();
        $tempfiles = TempFile::all();
        return view('admin.admin_page.IMRAD.fileDraft', compact('imrads', 'archives', 'tempfiles', 'yearList', 'adviserList', 'departmentList'));
    }

    protected function applyFilters(Request $request, $query)
    {
        if ($request->filled('adviser')) {
            $advisers = $request->input('adviser');
            $query->where(function ($q) use ($advisers) {
                foreach ($advisers as $adviser) {
                    $q->orWhereRaw("FIND_IN_SET(?, adviser)", [$adviser]);
                }
            });
        }

        if($request->filled('category')) {
            $categories = $request->input('category');
            $query->whereIn('category', $categories);
        }

        $startYear = $request->input('start_year')[0] ?? null;
        $endYear = $request->input('end_year')[0] ?? null;

        if ($startYear && !$endYear) {
            $query->where('publication_date', '>=', $startYear);
        } elseif ($endYear && !$startYear) {
            $query->where('publication_date', '<=', $endYear);
        } elseif ($startYear && $endYear) {
            if ($startYear === $endYear) {
                $query->where('publication_date', $startYear);
            } else {
                $query->whereBetween('publication_date', [$startYear, $endYear]);
            }
        }

        if ($request->filled('department')) {
            $departments = $request->input('department');
            $query->whereIn('department', $departments);
        }

        // Filter by SDGs
        if ($request->filled('sdg')) {
            $sdgs = array_map('trim', $request->input('sdg'));
            $query->where(function ($q) use ($sdgs) {
                foreach ($sdgs as $sdg) {
                    $q->orWhereRaw("FIND_IN_SET(?, REPLACE(SDG, ' ', ''))", [$sdg]);
                }
            });
        }
    }

    public function archive(Imrad $imrad)
    {

        $imrad->update([
            'status' => 'archive',
        ]);

        return back()->with('success', 'File has been archived successfully.');
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
            'location' => [
                'nullable',
                'string',
                Rule::unique('imrads')->whereNotNull('location')
            ],
            'SDG' => 'nullable|string',
            'category' => 'required|string|in:Technology,Midwifery,Engineering,Architecture,Accountancy,Other',
            'volume' => 'nullable|string',
            'issue' => 'nullable|string',
        ]);


        $tempFile = TempFile::find($data['id']);
        $pdfPath = $tempFile->pdf_file;
        $tempFile->delete();

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
                'category' => $data['category'],
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

            return redirect()->route('admin.file.published')->with('success', 'File created successfully.');
    }

    public function manual_create(Request $request)
    {
    $data = $request->validate([
        'title' => [
            'required',
            'string',
            Rule::unique('imrads')->where(function ($query) {
                return $query->where('action', null);
            }),
        ],
        'author'  => 'required|string|max:255',
        'adviser' => 'required|string|max:255',
        'department' => 'required|string|max:255',
        'publication_date' => 'required|date_format:Y|before_or_equal:' . date('Y'),
        'abstract' => 'required|string',
        'publisher' => 'required|string',
        'author'  => 'required|string|max:255',
        'keywords' => 'required|string',
        'category' => 'required|string|in:Technology,Midwifery,Engineering,Architecture,Accountancy,Other',
        'location' => [
            'nullable',
            'string',
            Rule::unique('imrads')->whereNotNull('location')
        ],
        'SDG' => 'nullable|string|regex:/^\d+(,\s?\d+)*$/',
        'volume' => 'nullable|string',
        'issue' => 'nullable|string',
        'file' => 'required|mimes:pdf|max:5120',
    ],[
        'title.required' => 'The title field is mandatory.',
        'author.required' => 'Please specify at least one author.',
        'publication_date.date_format' => 'The publication date must be a valid year (e.g., 2022).',
        'SDG.regex' => 'Social Development Goals must be a comma-separated list of numbers (e.g., 1, 2, 3).',
        'file.mimes' => 'The file must be a PDF, DOC, or DOCX format.',
        'file.max' => 'The file size cannot exceed 10MB.',
    ]);

    if (!$request->hasFile('file') || !$request->file('file')->isValid()) {
        return redirect()->back()->withErrors(['file' => 'Invalid file uploaded.']);
    }

    $file = $request->file('file');
    $originalName = pathinfo($file->getClientOriginalName(), PATHINFO_FILENAME);
    $extension = $file->getClientOriginalExtension();
    $filename = $originalName . '_' . time() . '.' . $extension;
    $destinationPath = public_path('assets/pdf/');

    if (!is_dir($destinationPath)) {
        mkdir($destinationPath, 0755, true);
    }

    $file->move($destinationPath, $filename);
    $filePath = $destinationPath . $filename;

    try {
        $imrad = Imrad::create([
            'title' => $data['title'],
            'author' => $data['author'],
            'adviser' => $data['adviser'],
            'department' => $data['department'],
            'abstract' => $data['abstract'],
            'publisher' => $data['publisher'],
            'publication_date' => $data['publication_date'],
            'keywords' => $data['keywords'],
            'location' => $data['location'] ?? null,
            'category' => $data['category'],
            'SDG' => $data['SDG'],
            'volume' => $data['volume'] ?? null,
            'issue' => $data['issue'] ?? null,
            'pdf_file' => $filename,
        ]);

        ImradMetric::create([
            'imradID' => $imrad->id,
            'rating' => 0,
            'no_click' => 0,
            'no_saved' => 0,
            'no_download' => 0,
        ]);

        return redirect()->route('admin.file.published')->with('success', 'File created successfully.');
    } catch (\Exception $e) {

        return redirect()->back()->withErrors(['message' => 'Failed to create record. ' . $e->getMessage()]);
    }
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
            'location' => [
            'nullable',
            'string',
            Rule::unique('imrads')->ignore($imrad->id)->whereNotNull('location')
             ],
            'SDG' => 'nullable|string',
            'category' => 'required|string|in:Technology,Midwifery,Engineering,Architecture,Accountancy,Other',
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
            'location' => $data['location'] ?? null,
            'category' => $data['category'],
            'SDG' => $data['SDG'],
            'volume' => $data['volume'],
            'issue' => $data['issue'],
            'pdf_file' => $pdfPath,
        ]);

        return redirect()->route('admin.file.published')->with('success', 'File updated successfully.');
    }

    public function destroy(Imrad $imrad)
    {

        $deleted_date = SetDeleteDate::first();
        $imrad->update([
            'action' => 'deleted',
            'deleted_time' => now(),
            'delete_by' => auth()->user()->name,
            'permanent_delete' => now()->addSeconds($deleted_date->delete_date),
            'created_at' => now(),
            'updated_at' => now(),
        ]);

        return back()->with('success', 'The file will be permanently deleted in ' .$deleted_date->delete_date. ' days. Use the DELETE button in the Trash Bin to proceed.');
    }

    // public function destroyTemp(TempFile $temp)
    // {

    //     $pdf_file = $temp->pdf_file;
    //     $destinationPath = public_path('assets/pdf/');
    //     $filePath = $destinationPath . $pdf_file;

    //     if ($pdf_file) {
    //         if (file_exists($filePath)) {
    //             if (unlink($filePath)) {
    //                 \Log::info("Deleted temporary file: " . $filePath);
    //             } else {
    //                 return redirect()->route('admin.file.archived')->with('error', 'Failed to delete the file. Please try again.');
    //             }
    //         } else {
    //             return redirect()->route('admin.file.archived')->with('error', 'File not found.');
    //         }
    //     } else {
    //         foreach (glob($destinationPath . "/*_" . $temp->id . ".*") as $existingFile) {
    //             if (file_exists($existingFile)) {
    //                 unlink($existingFile);
    //             }
    //         }
    //     }

    //     $temp->delete();

    //     return back()->with('success', 'File deleted successfully.');

    // }


    // public function destroyArhive(Imrad $archive)
    // {
    //     $deleted_date = SetDeleteDate::first();

    //     $archive->update([
    //         'action' => 'deleted',
    //         'deleted_time' => now(),
    //         'delete_by' => auth()->user()->name,
    //         'permanent_delete' => now()->addDays($deleted_date->delete_date),
    //         'created_at' => now(),
    //         'updated_at' => now(),
    //     ]);

    //     return back()->with('success', 'The file will be permanently deleted in ' .$deleted_date->delete_date. ' days. Use the DELETE button in the Trash Bin to proceed.');
    // }

        public function pdfscan(Request $request)
    {

        $data = $request->validate([
            'file' => 'required|mimes:pdf|max:5120',
        ]);

        $file = $request->file('file');

        $tempData = [
            'publisher' => null,
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

        $destinationPath = public_path('assets/pdf/');
        $file->move($destinationPath, $filename);
        $filePath = $destinationPath . $filename;

        try {

            $fileResource = fopen($filePath, 'r');
            $response = Http::attach('file', $fileResource, $filename)
                ->post('https://python-extracter-2.onrender.com/extract_pdf');

            fclose($fileResource);

            if ($response->ok()) {
                $extractedData = $response->json();
                foreach ($extractedData as $key => $value) {

                $title = $this->extractTitle($value);
                $adviser = $this->extractAdviserName($value);
                $department = $this->extractDepartment($value);
                $abstract = $this->extractAbstract($value);
                $authors = $this->extractAuthors($value);
                $keywords = $this->extractKeywords($value);
                $SDG = $this->extractSDG($value);
                $date = $this->extractDate($value);
                $issue = $this->extractIssue($value);
                $publisher = $this->extractPublisher($value);
                $volume = $this->extractVol($value);

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

                if(empty($title) || empty($adviser) || empty($department) || empty($abstract) || empty($authors) || empty($keywords) || empty($SDG) || empty($date) || empty($issue) || empty($volume) || empty($publisher)) {

                    $this->errorFile($temp);
                    return back()->with('error_format', 'Incorrect file format, check this format for you reference: ');
                }

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
                    'pdf_file' => $filename,
                ]);

                return $this->create($temp);

                }
            } else {
                $this->errorFile($temp);
                Log::error('Python API extraction failed: ' . $response->body());
                return back()->with('error', 'Failed to extract PDF content. Make sure you have strong internet connection and try again.');
            }

        } catch (\Exception $exception) {
            $this->errorFile($temp);
            Log::error('Error processing PDF: ' . $exception->getMessage());
            return back()->with('error', 'Failed to extract PDF content. Make sure you have strong internet connection and try again.');
        }
    }

    public function errorFile(TempFile $temp)
    {

        $pdf_file = $temp->pdf_file;
        $destinationPath = public_path('assets/pdf/');
        $filePath = $destinationPath . $pdf_file;

        if ($pdf_file) {
            if (file_exists($filePath)) {
                if (unlink($filePath)) {
                    \Log::info("Deleted temporary file: " . $filePath);
                } else {
                    return redirect()->route('admin.file.draft')->with('error', 'Failed to delete the file. Please try again.');
                }
            } else {
                return redirect()->route('admin.file.draft')->with('error', 'File not found.');
            }
        } else {
            foreach (glob($destinationPath . "/*_" . $temp->id . ".*") as $existingFile) {
                if (file_exists($existingFile)) {
                    unlink($existingFile);
                }
            }
        }
        $temp->delete();
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

        $removePatterns = [
            '/SORSOGONSTATEUNIVERSITY PUBLICATIONANDKNOWLEDGEMANAGEMENTUNIT/i',
            '/THESISMANAGEMENTSYSTEM Issue\d+Volume\d+/i'
        ];

        $title = preg_replace($removePatterns, '', $title);

        $title = trim($title);

        return $title ?? '';
    }

    private function extractPublisher($text)
    {
        $lines = preg_split('/\r\n|\r|\n/', $text);

        $lines[0] = str_replace('PUBLICATION AND KNOWLEDGE MANAGEMENT UNIT', '', $lines[0]);
        $lines[0] = str_replace('PUBLICATIONANDKNOWLEDGEMANAGEMENTUNIT', '', $lines[0]);
        if(preg_match('/^SORSOGONSTATEUNIVERSITY/', $lines[0])) {
            $lines[0] = 'SORSOGON STATE UNIVERSITY';
        }

        $lines[0] = trim($lines[0]);
        return $lines[0] ?? '';
    }

    private function extractSDG($text)
    {
        // Collected by numbers of SDG
        $collectedContent = [];
        $pattern = '/Sustainable\s*Development\s*Goals:\s*(.*?)(?=\n\n|\Z)/is';
        preg_match_all($pattern, $text, $matches);

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
        preg_match('/Sorsogon State University,\s*(.*?)\s+(\d{4})/is', $text, $matches);

        $department = $matches[1] ?? '';
        $department = preg_replace('/\r\n|\r|\n/', ' ', $department);

        return $department;

    }

    private function extractDate($text)
    {
        preg_match('/Sorsogon State University,\s*.*?.*?(\d{4})/is', $text, $matches);

        $date = $matches[1] ?? '';

        $date = preg_replace('/\r\n|\r|\n/', ' ', trim($date));

        return $date;

    }

    private function extractAbstract($text)
    {

        preg_match(
            '/Abstract\s*(.*?)(?=\n\s*(Keywords|Introduction|Methods|Results|Discussion|Conclusion|\w+:))/is',
            $text,
            $matches
        );

        $abstract = $matches[1]?? '';
        $removePatterns = [
            '/SORSOGON STATE UNIVERSITY PUBLICATION AND KNOWLEDGE MANAGEMENT UNIT/i',
            '/THESIS MANAGEMENT SYSTEM Issue \d+ Volume \d+/i'
        ];

        $abstract = preg_replace($removePatterns, '', $abstract);
        $abstract = preg_replace('/\r\n|\r|\n/', '', $abstract);
        $abstract = preg_replace('/\s+/', ' ', trim($abstract));
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
        preg_match('/Keywords:\s*(.*?)\s*Sustainable\s*Development\s*Goals:/is', $text, $matches);

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


    }

    public function imradview(Imrad $imrad) {

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

        $authorString = Imrad::where('id', $imrad->id)->pluck('author')->first();
        preg_match_all('/[A-Za-z.\s]+, R\.M\., BSM/', $authorString, $matches);
        $authorsArray = $matches[0];
        if(empty($authorsArray)) {
            $authorsArray = explode(', ', $authorString);
        }

        $SDGs = Imrad::select('SDG')->where('id', $imrad->id)->get();
        $SDGNO = [];
        $SDGList = [];

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


        return view('admin.admin_page.IMRAD.imrad-view', compact('imrad', 'authorsArray', 'SDGList'));
    }

    public function imradviewtemp(Tempfile $tempfile) {
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

        $imrad = $tempfile;

        $authorString = Tempfile::where('id', $tempfile->id)->pluck('author')->first();
        preg_match_all('/[A-Za-z.\s]+, R\.M\., BSM/', $authorString, $matches);
        $authorsArray = $matches[0];
        if(empty($authorsArray)) {
            $authorsArray = explode(', ', $authorString);
        }


        $SDGs = Tempfile::select('SDG')->where('id', $tempfile->id)->get();
        $SDGNO = [];
        $SDGList = [];

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

        return view('admin.admin_page.IMRAD.imrad-view', compact('imrad', 'authorsArray', 'SDGList'));

    }

    public function manual_add() {
        return view('admin.admin_page.IMRAD.imradCreateManual');
    }

    public function bulkDelete(Request $request)
{
    $deleted_date = SetDeleteDate::first();
    $ids = $request->input('ids', []);

    if (!is_array($ids) || empty($ids)) {
        return response()->json(['message' => 'No items selected for deletion'], 400);
    }

    try {
        $files = Imrad::whereIn('id', $ids)->get();

        foreach ($files as $file) {
            $file->update([
                'action' => 'deleted',
                'deleted_time' => now(),
                'delete_by' => auth()->user()->name,
                'permanent_delete' => now()->addDays($deleted_date->delete_date),
            ]);
        }

        return response()->json(['message' => 'Selected items deleted successfully']);
    } catch (\Exception $e) {
        return response()->json(['message' => 'Error deleting items: ' . $e->getMessage()], 500);
    }
}

    public function bulkArchive(Request $request)
    {
        $ids = $request->input('ids', []);

        if (!is_array($ids) || empty($ids)) {
            return response()->json(['message' => 'No items selected for archiving'], 400);
        }

        try {
            $files = Imrad::whereIn('id', $ids)->get();

            foreach ($files as $file) {
                $file->update([
                    'status' => 'archive',
                ]);
            }

            return response()->json(['message' => 'Selected items archived successfully']);
        } catch (\Exception $e) {
            return response()->json(['message' => 'Error deleting items: ' . $e->getMessage()], 500);
        }
    }

    public function bulkPublished(Request $request)
    {
        $ids = $request->input('ids', []);

        if (!is_array($ids) || empty($ids)) {
            return response()->json(['message' => 'No items selected for archiving'], 400);
        }

        try {
            $files = Imrad::whereIn('id', $ids)->get();

            foreach ($files as $file) {
                $file->update([
                    'status' => 'published',
                ]);
            }

            return response()->json(['message' => 'Selected items archived successfully']);
        } catch (\Exception $e) {
            return response()->json(['message' => 'Error deleting items: ' . $e->getMessage()], 500);
        }
    }

    public function bulkDeleteDraft(Request $request)
    {
        $ids = $request->input('ids', []);

        if (!is_array($ids) || empty($ids)) {
            return response()->json(['message' => 'No items selected for deletion'], 400);
        }

        try {
            TempFile::whereIn('id', $ids)->each(function ($file) {
                $filePath = public_path('assets/pdf/' . $file->pdf_file);
                if (file_exists($filePath)) {
                    @unlink($filePath);
                }
                $file->delete();
            });

            return response()->json(['message' => 'Selected items deleted successfully']);
        } catch (\Exception $e) {
            return response()->json(['message' => 'Error deleting items: ' . $e->getMessage()], 500);
        }
    }



}
