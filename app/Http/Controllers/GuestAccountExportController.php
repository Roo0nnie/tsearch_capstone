<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\GuestAccount;
// use App\Models\InvalidFaculty;
use PDF;
use Maatwebsite\Excel\Facades\Excel;
use Maatwebsite\Excel\Concerns\Exportable;
use Maatwebsite\Excel\Concerns\FromView;
use Maatwebsite\Excel\Concerns\ShouldAutoSize;

use App\Exports\GuestDataExport;

class GuestAccountExportController extends Controller
{
    public function viewPdf()
    {
        $data = GuestAccount::all();
        $pdf = PDF::loadView('admin.admin_page.user_view', compact('data'))->setPaper('a4', 'Portrait');

        return $pdf->stream('user_pdf.pdf');
    }

    public function downloadPdf()
    {
        $data = GuestAccount::all();
        $pdf = PDF::loadView('admin.admin_page.user_view', compact('data'))->setPaper('a4', 'Portrait');

        return $pdf->download('user_pdf.pdf');
    }

    public function ActiveViewPdf()
    {
        $data = GuestAccount::where('status', 'online')->get();
        $pdf = PDF::loadView('admin.admin_page.user_view', compact('data'))->setPaper('a4', 'Portrait');

        return $pdf->stream('user_pdf.pdf');
    }

    public function ActiveDownloadPdf()
    {
        $data = GuestAccount::where('status', 'online')->get();
        $pdf = PDF::loadView('admin.admin_page.user_view', compact('data'))->setPaper('a4', 'Portrait');

        return $pdf->download('user_pdf.pdf');
    }

    public function InactiveViewPdf()
    {
        $data = GuestAccount::where('status','offline')->get();
        $pdf = PDF::loadView('admin.admin_page.user_view', compact('data'))->setPaper('a4', 'Portrait');

        return $pdf->stream('user_pdf.pdf');
    }

    public function InactiveDownloadPdf()
    {
        $data = GuestAccount::where('status','offline')->get();
        $pdf = PDF::loadView('admin.admin_page.user_view', compact('data'))->setPaper('a4', 'Portrait');

        return $pdf->download('user_pdf.pdf');
    }

    public function BlockedViewPdf()
    {
        $data = GuestAccount::where('account_status','blocked')->get();
        $pdf = PDF::loadView('admin.admin_page.user_view', compact('data'))->setPaper('a4', 'Portrait');

        return $pdf->stream('user_pdf.pdf');
    }

    public function BlockedDownloadPdf()
    {
        $data = GuestAccount::where('account_status','blocked')->get();
        $pdf = PDF::loadView('admin.admin_page.user_view', compact('data'))->setPaper('a4', 'Portrait');

        return $pdf->download('user_pdf.pdf');
    }

    public function InvalidViewPdf()
    {
        $data = InvalidFaculty::all();
        $pdf = PDF::loadView('admin.admin_page.user_view', compact('data'))->setPaper('a4', 'Portrait');

        return $pdf->stream('user_pdf.pdf');
    }

    public function InvalidDownloadPdf()
    {
        $data = InvalidFaculty::all();
        $pdf = PDF::loadView('admin.admin_page.user_view', compact('data'))->setPaper('a4', 'Portrait');

        return $pdf->download('user_pdf.pdf');
    }


    public function exportExcel()
    {
        $user = GuestAccount::select('id', 'name', 'user_code', 'email', 'phone', 'updated_at')->get();
        return Excel::download(new GuestDataExport($user), 'guest_pdf.xlsx');
    }

    public function exportExcelOnline()
    {
        $user = GuestAccount::select('id', 'name', 'user_code', 'email', 'phone', 'updated_at')->where('status', 'online')->get();
        return Excel::download(new GuestDataExport($user), 'guest_online_pdf.xlsx');
    }

    public function exportExcelOffline()
    {
        $user = GuestAccount::select('id', 'name', 'user_code', 'email', 'phone', 'updated_at')->where('status', 'offline')->get();
        return Excel::download(new GuestDataExport($user), 'guest_offline_pdf.xlsx');
    }

    public function exportExcelBlocked()
    {
        $user = GuestAccount::select('id', 'name', 'user_code', 'email', 'phone', 'updated_at')->where('account_status', 'blocked')->get();
        return Excel::download(new GuestDataExport($user), 'guest_blocked_pdf.xlsx');
    }

}
