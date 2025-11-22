<?php

namespace App\Http\Middleware;

use Closure;
use Symfony\Component\HttpFoundation\BinaryFileResponse;
use Symfony\Component\HttpFoundation\StreamedResponse;

class NoCache
{
    public function handle($request, Closure $next)
    {
        $response = $next($request);

        // JANGAN tambahkan header cache jika responnya adalah download file (Excel/PDF/Gambar)
        if ($response instanceof BinaryFileResponse || $response instanceof StreamedResponse) {
            return $response;
        }

        // Hanya tambahkan header jika method header() tersedia
        if (method_exists($response, 'header')) {
            $response->header('Cache-Control', 'no-store, no-cache, must-revalidate, max-age=0')
                     ->header('Pragma', 'no-cache')
                     ->header('Expires', 'Sat, 01 Jan 2000 00:00:00 GMT');
        }

        return $response;
    }
}