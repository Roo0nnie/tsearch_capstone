<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;
use Illuminate\Support\Facades\DB;
use App\Http\Controllers\LogHistoryController;
use App\Services\Auth\AccountResolver;


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
        $accountResolver = app(AccountResolver::class);
        $user = $accountResolver->user();

        if ($user) {
            $userCode = $user->user_code ?? $user->email ?? null;
            $userType = $accountResolver->roleName($user);

            DB::table('sessions')->where('id', $sessionId)->update([
                'user_code' => $userCode,
                'user_type' => $userType,
                'user_id' => $user->getAuthIdentifier(),
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
