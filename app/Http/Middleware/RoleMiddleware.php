<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Support\Facades\Auth;

class RoleMiddleware
{
    /**
     * Handle an incoming request.
     */
    public function handle($request, Closure $next, ...$roles)
    {
        // Pastikan user sudah login
        if (!Auth::check()) {
            return redirect('/admin/login');
        }

        $user = Auth::user();

        // Jika role user cocok dengan salah satu role dalam daftar
        if (in_array($user->role, $roles)) {
            return $next($request);
        }

        // Jika gagal → tampilkan 403
        abort(403, 'Unauthorized');
    }
}
