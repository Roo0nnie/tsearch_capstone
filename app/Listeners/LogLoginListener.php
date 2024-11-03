<?php

namespace App\Listeners;

use App\Http\Controllers\LogHistoryController;
use Illuminate\Auth\Events\Login;
use Illuminate\Support\Facades\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class LogLoginListener
{
    /**
     * Handle the login event.
     *
     * @param  \Illuminate\Auth\Events\Login  $event
     * @return void
     */
    public function handle(Login $event)
    {

        $sessionId = session()->getId();

        if (Auth::check()) {
            $user = Auth::user();
            $userCode = $user->user_code;

            DB::table('sessions')->where('id', $sessionId)->update([
                'user_code' => $userCode,
                'user_id' => $user->id,
            ]);
        } else {
            DB::table('sessions')->where('id', $sessionId)->update([
                'user_code' => null,
                'user_type' => null,
            ]);
        }

        $controller = new LogHistoryController();
        $controller->logLogin(Request::capture(), $sessionId);
    }
}
