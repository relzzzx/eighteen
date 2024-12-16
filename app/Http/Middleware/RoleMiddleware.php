<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;
use Illuminate\Support\Facades\Auth;

class RoleMiddleware
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next, ...$roles): Response
    {
        // Cek apakah user sudah login
        if (!Auth::check()) {
            abort(403, 'You must be logged in to access this resource.');
        }

        $userRole = Auth::user()->role;

        // Cek apakah role sesuai
        if (!$userRole || !in_array($userRole, $roles)) {
            abort(403, 'You do not have the required permissions to access this resource.');
        }

        return $next($request);
    }
}
