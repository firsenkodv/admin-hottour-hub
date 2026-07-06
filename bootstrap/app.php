<?php

use Illuminate\Foundation\Application;
use Illuminate\Foundation\Configuration\Exceptions;
use Illuminate\Foundation\Configuration\Middleware;

return Application::configure(basePath: dirname(__DIR__))
    ->withRouting(
        web: __DIR__.'/../routes/web.php',
        commands: __DIR__.'/../routes/console.php',
        health: '/up',
    )
    ->withMiddleware(function (Middleware $middleware): void {
        // Identity API (Этап 3) и Content-sync (Этап 4) — серверные вызовы между
        // сайтами и hub'ом, авторизуются подписью, а не браузерной сессией.
        $middleware->validateCsrfTokens(except: ['identity/*', 'api/sync/*']);
    })
    ->withExceptions(function (Exceptions $exceptions): void {
        //
    })->create();
