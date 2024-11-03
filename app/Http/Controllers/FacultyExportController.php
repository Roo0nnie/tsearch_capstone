<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Faculty;
use App\Models\InvalidFaculty;
use PDF;
use Maatwebsite\Excel\Facades\Excel;
use Maatwebsite\Excel\Concerns\Exportable;
use Maatwebsite\Excel\Concerns\FromView;
use Maatwebsite\Excel\Concerns\ShouldAutoSize;

use App\Exports\FacultyDataExport;
use App\Exports\InvalidFacultyDataExport;

class FacultyExportController extends Controller
{
    public function viewPdf()
    {
        $data = Faculty::all();
        $pdf = PDF::loadView('admin.admin_page.user_view', compact('data'))->setPaper('a4', 'Portrait');

        return $pdf->stream('user_pdf.pdf');
    }

    public function downloadPdf()
    {
        $data = Faculty::all();
        $pdf = PDF::loadView('admin.admin_page.user_view', compact('data'))->setPaper('a4', 'Portrait');

        return $pdf->download('user_pdf.pdf');
    }

    public function ActiveViewPdf()
    {
        $data = Faculty::where('status', 'online')->get();
        $pdf = PDF::loadView('admin.admin_page.user_view', compact('data'))->setPaper('a4', 'Portrait');

        return $pdf->stream('user_pdf.pdf');
    }

    public function ActiveDownloadPdf()
    {
        $data = Faculty::where('status', 'online')->get();
        $pdf = PDF::loadView('admin.admin_page.user_view', compact('data'))->setPaper('a4', 'Portrait');

        return $pdf->download('user_pdf.pdf');
    }

    public function InactiveViewPdf()
    {
        $data = Faculty::where('status','offline')->get();
        $pdf = PDF::loadView('admin.admin_page.user_view', compact('data'))->setPaper('a4', 'Portrait');

        return $pdf->stream('user_pdf.pdf');
    }

    public function InactiveDownloadPdf()
    {
        $data = Faculty::where('status','offline')->get();
        $pdf = PDF::loadView('admin.admin_page.user_view', compact('data'))->setPaper('a4', 'Portrait');

        return $pdf->download('user_pdf.pdf');
    }

    public function InvalidViewPdf()
    {
        $data = InvalidFaculty::all();
        $pdf = PDF::loadView('admin.admin_page.invaliduser_view', compact('data'))->setPaper('a4', 'Portrait');

        return $pdf->stream('user_pdf.pdf');
    }

    public function InvalidDownloadPdf()
    {
        $data = InvalidFaculty::all();
        $pdf = PDF::loadView('admin.admin_page.invaliduser_view', compact('data'))->setPaper('a4', 'Portrait');

        return $pdf->download('user_pdf.pdf');
    }

    public function invalidexportExcel()
    {
        $faculty = InvalidFaculty::select('id', 'name', 'user_code', 'email', 'phone','error_message', 'updated_at')->get();
        return Excel::download(new InvalidFacultyDataExport($faculty), 'faculty_invalid_data.xlsx');
    }


    public function exportExcel()
    {
        $faculty = Faculty::select('id', 'name', 'user_code', 'email', 'phone', 'updated_at')->get();
        return Excel::download(new FacultyDataExport($faculty), 'faculty_all_data.xlsx');
    }

    public function exportExcelOnline()
    {
        $faculty = Faculty::select('id', 'name', 'user_code', 'email', 'phone', 'updated_at')->where('status', 'online')->get();
        return Excel::download(new FacultyDataExport($faculty), 'faculty_online_data.xlsx');
    }

    public function exportExcelOffline()
    {
        $faculty = Faculty::select('id', 'name', 'user_code', 'email', 'phone', 'updated_at')->where('status', 'offline')->get();
        return Excel::download(new FacultyDataExport($faculty), 'faculty_offline_data.xlsx');
    }

    // ito nlng kulng
    public function exportExcelInvalid()
    {
        $invalidfaculty = InvalidFaculty::select('id', 'name', 'user_code', 'email', 'phone','error_message', 'updated_at')->get();
        return Excel::download(new FacultyDataExport($invalidfaculty), 'faculty_offline_data.xlsx');
    }
}
