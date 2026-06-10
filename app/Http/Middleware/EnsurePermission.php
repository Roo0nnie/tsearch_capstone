<?php

namespace App\Http\Middleware;

use App\Services\Auth\AccountResolver;
use Closure;
use Illuminate\Http\Request;

class EnsurePermission
{
    public function handle(Request $request, Closure $next, string ...$permissions)
    {
        if (!app(AccountResolver::class)->hasPermission($permissions)) {
            abort(403);
        }

        return $next($request);
    }
}
