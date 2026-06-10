<?php

namespace App\Http\Middleware;

use App\Services\Auth\AccountResolver;
use Closure;
use Illuminate\Http\Request;

class EnsureRole
{
    public function handle(Request $request, Closure $next, string ...$roles)
    {
        if (!app(AccountResolver::class)->hasAnyRole($roles)) {
            abort(403);
        }

        return $next($request);
    }
}
