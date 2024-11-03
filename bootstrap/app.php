<?php

use Illuminate\Foundation\Application;
use Illuminate\Foundation\Configuration\Exceptions;
use Illuminate\Foundation\Configuration\Middleware;
use App\Http\Middleware\UpdateSessionWithUserCode;
use App\Http\Middleware\CheckIfUserLoggedIn;
use App\Http\Middleware\SessionTimeout;
use App\Http\Middleware\SuperAdminVerified;
use App\Http\Middleware\AdminVerified;

return Application::configure(basePath: dirname(__DIR__))
    ->withRouting(
        web: __DIR__.'/../routes/web.php',
        commands: __DIR__.'/../routes/console.php',
        health: '/up',
    )

    ->withMiddleware(function (Middleware $middleware) {
        $middleware->use([
            UpdateSessionWithUserCode::class,
            SuperAdminVerified::class,
            AdminVerified::class,
        ]);
    })

    ->withExceptions(function (Exceptions $exceptions) {
        //
    })->create();
