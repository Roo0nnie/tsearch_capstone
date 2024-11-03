<?php

namespace App\Listeners;

use App\Http\Controllers\LogHistoryController;
use Illuminate\Auth\Events\Logout;
use Illuminate\Support\Facades\Request;

class LogLogoutListener
{
    /**
     * Handle the logout event.
     *
     * @param  \Illuminate\Auth\Events\Logout  $event
     * @return void
     */
    public function handle(Logout $event)
    {
        $request = Request::capture();

        $logcontroller = new LogHistoryController();
        $logcontroller->logLogout($request);

    }

    /**
     * Create the event listener.
     */
    public function __construct()
    {
        //
    }
}
