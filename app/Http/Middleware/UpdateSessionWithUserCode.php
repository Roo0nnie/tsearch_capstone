<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use App\Http\Controllers\LogHistoryController;


class UpdateSessionWithUserCode
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle($request, Closure $next)
    {

        $response = $next($request);
        $sessionId = $request->session()->getId();
        if (Auth::check()) {
            $user = Auth::user();
            $userCode = $user->user_code;
            $userType = $user->type;

            DB::table('sessions')->where('id', $sessionId)->update([
                'user_code' => $userCode,
                'user_type' => $userType,
                'user_id' => $user->id,
            ]);
        } else {
            DB::table('sessions')->where('id', $sessionId)->update([
                'user_code' => null,
                'user_type' => null,
            ]);
        }

        $controller = new LogHistoryController();
        $controller->logLogin($request, $sessionId);

        return $response;
    }
}
