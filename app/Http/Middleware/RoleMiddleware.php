<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;
use Auth;

class RoleMiddleware
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next, $roleId): Response
    {
        if (!Auth::check() || (!Auth::user()->officers->contains('role_id', 1) && !Auth::user()->officers->contains('role_id', $roleId))) {
            abort(403, 'Unauthorized');
        }

        return $next($request);
    }
}
