<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;
use App\Models\InvalidUser;
use PDF;
use Maatwebsite\Excel\Facades\Excel;
use Maatwebsite\Excel\Concerns\Exportable;
use Maatwebsite\Excel\Concerns\FromView;
use Maatwebsite\Excel\Concerns\ShouldAutoSize;

use App\Exports\UserDataExport;
use App\Exports\InvalidUserDataExport;

class UserExportController extends Controller
{
    public function viewPdf()
    {
        $data = User::all();
        $pdf = PDF::loadView('admin.admin_page.user_view', compact('data'))->setPaper('a4', 'Portrait');

        return $pdf->stream('user_pdf.pdf');
    }

    public function downloadPdf()
    {
        $data = User::all();
        $pdf = PDF::loadView('admin.admin_page.user_view', compact('data'))->setPaper('a4', 'Portrait');

        return $pdf->download('user_pdf.pdf');
    }

    public function ActiveViewPdf()
    {
        $data = User::where('status', 'online')->get();
        $pdf = PDF::loadView('admin.admin_page.user_view', compact('data'))->setPaper('a4', 'Portrait');

        return $pdf->stream('user_pdf.pdf');
    }

    public function ActiveDownloadPdf()
    {
        $data = User::where('status', 'online')->get();
        $pdf = PDF::loadView('admin.admin_page.user_view', compact('data'))->setPaper('a4', 'Portrait');

        return $pdf->download('user_pdf.pdf');
    }

    public function InactiveViewPdf()
    {
        $data = User::where('status','offline')->get();
        $pdf = PDF::loadView('admin.admin_page.user_view', compact('data'))->setPaper('a4', 'Portrait');

        return $pdf->stream('user_pdf.pdf');
    }

    public function InactiveDownloadPdf()
    {
        $data = User::where('status','offline')->get();
        $pdf = PDF::loadView('admin.admin_page.user_view', compact('data'))->setPaper('a4', 'Portrait');

        return $pdf->download('user_pdf.pdf');
    }

    public function InvalidViewPdf()
    {
        $data = InvalidUser::all();
        $pdf = PDF::loadView('admin.admin_page.invaliduser_view', compact('data'))->setPaper('a4', 'Portrait');

        return $pdf->stream('user_pdf.pdf');
    }

    public function InvalidDownloadPdf()
    {
        $data = InvalidUser::all();
        $pdf = PDF::loadView('admin.admin_page.invaliduser_view', compact('data'))->setPaper('a4', 'Portrait');
        return $pdf->download('user_pdf.pdf');
    }

    public function invalidUserExportExcel()
    {
        $user = InvalidUser::select('id', 'name', 'user_code', 'email', 'phone','error_message', 'updated_at')->get();
        return Excel::download(new InvalidUserDataExport($user), 'user_invalid_pdf.xlsx');
    }

    public function exportExcel()
    {
        $user = User::select('id', 'name', 'user_code', 'email', 'phone', 'updated_at')->get();
        return Excel::download(new UserDataExport($user), 'user_all_pdf.xlsx');
    }

    public function exportExcelOnline()
    {
        $user = User::select('id', 'name', 'user_code', 'email', 'phone', 'updated_at')->where('status', 'online')->get();
        return Excel::download(new UserDataExport($user), 'user_online_pdf.xlsx');
    }

    public function exportExcelOffline()
    {
        $user = User::select('id', 'name', 'user_code', 'email', 'phone', 'updated_at')->where('status', 'offline')->get();
        return Excel::download(new UserDataExport($user), 'user_offline_pdf.xlsx');
    }

}
