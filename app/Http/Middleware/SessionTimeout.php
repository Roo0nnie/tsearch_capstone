<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Session;
use App\Models\LogHistory;

class SessionTimeout
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next): Response
    {
         $timeout = config('session.lifetime') * 300000;

        if (Session::has('last_activity')) {
            $inactiveTime = time() - Session::get('last_activity');

            if ($inactiveTime > $timeout) {
                $this->logLogout();
                Auth::logout();
                Session::flush();
                return redirect()->route('login')->withErrors(['message' => 'You have been logged out due to inactivity.']);
            }
        }

        Session::put('last_activity', time());

        return $next($request);
    }

    protected function logLogout()
    {
        $sessionId = session()->getId();

        LogHistory::where('session_id', $sessionId)
            ->whereNull('logout')
            ->update(['logout' => now()]);
    }
}
