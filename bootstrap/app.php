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
        // Konfigurasi pengecualian CSRF
        $middleware->validateCsrfTokens(except: [
            '/midtrans/notification',
        ]);

        // DAFTARKAN ALIAS MIDDLEWARE DI SINI
        $middleware->alias([
            'role' => \App\Http\Middleware\RoleMiddleware::class,
            'no.cache' => \App\Http\Middleware\NoCache::class, // <-- Baris ini yang kurang
        ]);
    })
    ->withExceptions(function (Exceptions $exceptions): void {
        //
    })->create();