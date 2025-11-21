<?php

namespace App\Http\Middleware;

use Closure;

class NoCache
{
    public function handle($request, Closure $next)
    {
        $response = $next($request);

        // 1. Cek jika response adalah download file (Binary atau Streamed)
        // Jika iya, langsung kembalikan response tanpa utak-atik header cache
        if ($response instanceof BinaryFileResponse || $response instanceof StreamedResponse) {
            return $response;
        }
        // 2. Pastikan response memiliki method 'header' sebelum memanggilnya
        // (Ini pengaman tambahan agar tidak pernah error undefined method)
        if (method_exists($response, 'header')) {
            $response->header('Cache-Control', 'no-store, no-cache, must-revalidate, max-age=0')
                     ->header('Pragma', 'no-cache')
                     ->header('Expires', 'Sat, 01 Jan 2000 00:00:00 GMT');
        }

        return $response;
    }
}
