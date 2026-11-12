<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class RoleMiddleware
{
    public function handle(Request $request, Closure $next, string $role): Response 
    {
        // 1. Cek udah login belum
        if (!auth()->check()) {
            return redirect('/login');
        }

        // 2. Cek apakah rolenya persis sama dengan yang diminta (misal: 'kurikulum')
        if (auth()->user()->role !== $role) {
            abort(403, 'Akses ditolak! Halaman ini khusus Kurikulum.');
        }

        return $next($request);
    }
}