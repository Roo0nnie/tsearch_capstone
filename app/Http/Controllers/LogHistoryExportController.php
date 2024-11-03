<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\LogHistory;
// use App\Models\InvalidFaculty;
use PDF;
use Excel;
use App\Exports\LogHistoryExport;
use Maatwebsite\Excel\Concerns\Exportable;
use Maatwebsite\Excel\Concerns\FromView;
use Maatwebsite\Excel\Concerns\ShouldAutoSize;


class LogHistoryExportController extends Controller
{
    public function viewPdf()
    {
        $data = LogHistory::all();
        $pdf = PDF::loadView('admin.admin_page.log_history.logHistoryExportPdf', compact('data'))->setPaper('a4', 'Portrait');

        return $pdf->stream('LogHistory.pdf');
    }

    public function downloadPdf()
    {
        $data = LogHistory::all();
        $pdf = PDF::loadView('admin.admin_page.log_history.logHistoryExportPdf', compact('data'))->setPaper('a4', 'Portrait');

        return $pdf->download('LogHistory.pdf');
    }


    public function exportExcel()
    {
        $logHistory = LogHistory::select('id', 'user_code', 'name', 'user_type', 'login','logout', 'updated_at')->get();

        return Excel::download(new LogHistoryExport($logHistory), 'logHistory.xlsx');
    }

}
