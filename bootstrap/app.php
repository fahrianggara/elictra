<?php

use App\Http\Middleware\CheckRole;
use App\Http\Middleware\PreventBackHistory;
use App\Http\Middleware\RedirectIfAuthenticated;
use Illuminate\Foundation\Application;
use Illuminate\Foundation\Configuration\Exceptions;
use Illuminate\Foundation\Configuration\Middleware;
use Illuminate\Support\Facades\Route;

return Application::configure(basePath: dirname(__DIR__))
    ->withRouting(
        commands: __DIR__.'/../routes/console.php',
        health: '/up',
        then: function() {
            Route::middleware(['web', 'auth', 'check.role:admin'])
                ->prefix('admin')
                ->group(base_path('routes/admin.php'));

            Route::middleware(['web', 'auth', 'check.role:petugas'])
                ->prefix('petugas')
                ->group(base_path('routes/officer.php'));

            Route::middleware(['web', 'auth', 'check.role:pelanggan'])
                ->prefix('pelanggan')
                ->group(base_path('routes/customer.php'));

            Route::middleware(['web'])
                ->group(base_path('routes/web.php'));
        }
    )
    ->withMiddleware(function (Middleware $middleware) {
        $middleware->alias([
            'prevent.back.history' => PreventBackHistory::class,
            'check.role' => CheckRole::class,
            'guest' => RedirectIfAuthenticated::class,
        ]);
    })
    ->withExceptions(function (Exceptions $exceptions) {
        //
    })->create();
