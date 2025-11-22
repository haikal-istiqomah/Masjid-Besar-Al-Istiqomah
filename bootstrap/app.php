<?php

use Illuminate\Foundation\Application;
use Illuminate\Foundation\Configuration\Exceptions;
use Illuminate\Foundation\Configuration\Middleware;
use Symfony\Component\HttpKernel\Exception\HttpException; // Tambahkan ini
use Illuminate\Http\Request; // Tambahkan ini

return Application::configure(basePath: dirname(__DIR__))
    ->withRouting(
        web: __DIR__.'/../routes/web.php',
        commands: __DIR__.'/../routes/console.php',
        health: '/up',
    )
    ->withMiddleware(function (Middleware $middleware): void {
        $middleware->validateCsrfTokens(except: [
            '/midtrans/notification',
        ]);
        
        $middleware->alias([
            'role' => \App\Http\Middleware\RoleMiddleware::class,
            'no.cache' => \App\Http\Middleware\NoCache::class,
        ]);

        // Mengarahkan user yang belum login ke halaman admin login
        $middleware->redirectGuestsTo(function (Request $request) {
            return route('admin.login');
        });
    })
    ->withExceptions(function (Exceptions $exceptions): void {
        // TAMBAHKAN KODE INI UNTUK MENANGANI ERROR 419
        $exceptions->render(function (HttpException $e, Request $request) {
            if ($e->getStatusCode() === 419) {
                return redirect()->route('admin.login')
                    ->withErrors(['email' => 'Sesi Anda telah berakhir. Silakan login kembali.']);
            }
        });
    })->create();