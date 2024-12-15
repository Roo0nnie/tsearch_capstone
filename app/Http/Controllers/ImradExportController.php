<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Imrad;
use App\Models\GuestAccount;
use App\Models\TempFile;
use App\Models\LogHistory;
use PDF;
use Maatwebsite\Excel\Facades\Excel;
use Maatwebsite\Excel\Concerns\Exportable;
use Maatwebsite\Excel\Concerns\FromView;
use Maatwebsite\Excel\Concerns\ShouldAutoSize;
use App\Exports\FileDataExport;
use App\Exports\FileDraftExport;
use App\Exports\SDGDataExport;
use App\Exports\RateDataExport;
use Intervention\Image\Facades\Image;

class ImradExportController extends Controller
{

    public function downloadlogFile(Request $request)
    {
        $ids = $request->query('ids', []);
        $logs = LogHistory::whereIn('id', $ids)->get();

        $pdf = PDF::loadView('admin.admin_page.log_history.logHistoryExportPdf', [
            'logs' => $logs
        ])
        ->setPaper('a4', 'portrait')
        ->setOptions([
            'defaultFont' => 'Arial',
            'isHtml5ParserEnabled' => true,
            'isRemoteEnabled' => true,
            'margin-left' => 5,
            'margin-right' => 5,
            'margin-top' => 7,
            'margin-bottom' => 7,
        ]);

        return $pdf->download('Deleted_Users.pdf');
    }

    public function downloadDeletedFileFile(Request $request)
    {
        $ids = $request->query('ids', []);
        $files = Imrad::whereIn('id', $ids)->where('action', 'deleted')->get();

        $pdf = PDF::loadView('admin.admin_page.filtered_file_deleted', [
            'files' => $files
        ])
        ->setPaper('a4', 'portrait')
        ->setOptions([
            'defaultFont' => 'Arial',
            'isHtml5ParserEnabled' => true,
            'isRemoteEnabled' => true,
            'margin-left' => 5,
            'margin-right' => 5,
            'margin-top' => 7,
            'margin-bottom' => 7,
        ]);

        return $pdf->download('Deleted_Users.pdf');
    }

    public function downloadDeletedUserFile(Request $request)
    {
        $ids = $request->query('ids', []);
        $users = GuestAccount::whereIn('id', $ids)->where('action', 'deleted')->get();

        $pdf = PDF::loadView('admin.admin_page.filtered_user_deleted', [
            'users' => $users
        ])
        ->setPaper('a4', 'portrait')
        ->setOptions([
            'defaultFont' => 'Arial',
            'isHtml5ParserEnabled' => true,
            'isRemoteEnabled' => true,
            'margin-left' => 5,
            'margin-right' => 5,
            'margin-top' => 7,
            'margin-bottom' => 7,
        ]);

        return $pdf->download('Deleted_Users.pdf');
    }

    public function downloadUserFile(Request $request)
    {
        $ids = $request->query('ids', []);
        $users = GuestAccount::whereIn('id', $ids)->get();

        $pdf = PDF::loadView('admin.admin_page.filtered_user', [
            'users' => $users
        ])
        ->setPaper('a4', 'portrait')
        ->setOptions([
            'defaultFont' => 'Arial',
            'isHtml5ParserEnabled' => true,
            'isRemoteEnabled' => true,
            'margin-left' => 5,
            'margin-right' => 5,
            'margin-top' => 7,
            'margin-bottom' => 7,
        ]);

        return $pdf->download('User_List.pdf');
    }
    public function downloadListFile(Request $request)
    {
        $ids = $request->query('ids', []);
        $imrads = Imrad::whereIn('id', $ids)->get();

        $pdf = PDF::loadView('admin.admin_page.filtered_filed', [
            'imrads' => $imrads
        ])
        ->setPaper('a4', 'Landscape')
        ->setOptions([
            'defaultFont' => 'Arial',
            'isHtml5ParserEnabled' => true,
            'isRemoteEnabled' => true,
            'margin-left' => 5,
            'margin-right' => 5,
            'margin-top' => 7,
            'margin-bottom' => 7,
        ]);

        return $pdf->download('filtered_data.pdf');
    }

    public function downloadListExcel(Request $request)
    {
        $ids = $request->query('ids', []);
        $imrads = Imrad::whereIn('id', $ids)->get();
        return Excel::download(new FileDataExport($imrads), 'File.xlsx');
    }

    // Report for SDG
    public function downloadSDGFile(Request $request)
    {
        $ids = $request->query('ids', []);
        $imrads = Imrad::whereIn('id', $ids)->get();

        $pdf = PDF::loadView('admin.admin_page.filtered_sdg', [
            'imrads' => $imrads
        ])
        ->setPaper('a4', 'Landscape')
        ->setOptions([
            'defaultFont' => 'Arial',
            'isHtml5ParserEnabled' => true,
            'isRemoteEnabled' => true,
            'margin-left' => 5,
            'margin-right' => 5,
            'margin-top' => 7,
            'margin-bottom' => 7,
        ]);

        return $pdf->download('filtered_data.pdf');
    }

    public function downloadSDGExcel(Request $request)
    {
        $ids = $request->query('ids', []);
        $imrads = Imrad::whereIn('id', $ids)->get();
        return Excel::download(new SDGDataExport($imrads), 'File.xlsx');
    }

    // Report for SDG
    public function downloadRateFile(Request $request)
    {
        $ids = $request->query('ids', []);
        $ids = array_map('intval', $ids);

        $imrads = Imrad::with('imradMetric')
            ->whereIn('id', $ids)
            ->whereHas('imradMetric', function ($query) {
                $query->whereNotNull('rates');
            })
            ->get();

        $pdf = PDF::loadView('admin.admin_page.filtered_rate', [
            'imrads' => $imrads
        ])
            ->setPaper('a4', 'Landscape')
            ->setOptions([
                'defaultFont' => 'Arial',
                'isHtml5ParserEnabled' => true,
                'isRemoteEnabled' => true,
                'margin-left' => 5,
                'margin-right' => 5,
                'margin-top' => 7,
                'margin-bottom' => 7,
            ]);

        return $pdf->download('filtered_data.pdf');
    }

    public function downloadRateExcel(Request $request)
    {
        $ids = $request->query('ids', []);
        $ids = array_map('intval', $ids);

        $imrads = Imrad::with('imradMetric')
        ->whereIn('id', $ids)
        ->whereHas('imradMetric', function ($query) {
            $query->whereNotNull('rates');
        })
        ->get();
        return Excel::download(new RateDataExport($imrads), 'File.xlsx');
    }

    public function downloadDraftFile(Request $request)
    {
        $ids = $request->query('ids', []);
        $imrads = TempFile::whereIn('id', $ids)->get();

        $pdf = PDF::loadView('admin.admin_page.filtered_filed', [
            'imrads' => $imrads
        ])
        ->setPaper('a4', 'Landscape')
        ->setOptions([
            'defaultFont' => 'Arial',
            'isHtml5ParserEnabled' => true,
            'isRemoteEnabled' => true,
            'margin-left' => 5,
            'margin-right' => 5,
            'margin-top' => 7,
            'margin-bottom' => 7,
        ]);

        return $pdf->download('filtered_data.pdf');
    }

    public function downloadDraftExcel(Request $request)
    {
        $ids = $request->query('ids', []);
        $imrads = Tempfile::whereIn('id', $ids)->get();
        return Excel::download(new FileDraftExport($imrads), 'File.xlsx');
    }
}
