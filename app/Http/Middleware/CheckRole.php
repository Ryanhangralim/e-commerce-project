<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Symfony\Component\HttpFoundation\Response;

class CheckRole
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next, ...$roles): Response
    {
        if (Auth::check()) {
            $userRole = Auth::user()->role->title;

            if (in_array($userRole, $roles)) {
                return $next($request);
            }
        }

        // Redirect to home page if user is not authenticated or does not have the required role
        return redirect('/')->with('error', 'You do not have access to this page.');
    }
}
