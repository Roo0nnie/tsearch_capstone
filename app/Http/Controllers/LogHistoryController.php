<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\LogHistory;
use App\Services\Auth\AccountResolver;
use Illuminate\Support\Facades\DB;

class LogHistoryController extends Controller
{
    /**
     * Log the login event.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return void
     */

    public function logLogin(Request $request, $sessionId)
    {

    $sessionId = $sessionId ?? session()->getId();

    $session = DB::table('sessions')->where('id', $sessionId)->first();

    $userCode = $session ? $session->user_code : null;
    if ($userCode !== null) {
        $sessionExists = LogHistory::where('session_id', $sessionId)->exists();

        if (!$sessionExists) {
            $accountResolver = app(AccountResolver::class);
            $account = $accountResolver->user();

            LogHistory::create([
                'session_id' => $sessionId,
                'user_code' => $userCode,
                'name' => $account->name ?? null,
                'user_type' => $accountResolver->roleName($account),
                'login' => now(),
                'logout' => null,
            ]);
        }
    }

    }

    public function logLogout(Request $request)
    {
        $sessionId = session()->getId();

        LogHistory::where('session_id', $sessionId)
            ->whereNull('logout')
            ->update(['logout' => now()]);
    }


public function view() {
    $logs = LogHistory::all();
    return view('admin.admin_page.log_history.logHistory', compact('logs'));
}

}






