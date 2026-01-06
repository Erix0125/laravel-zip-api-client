<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Session;

class ApiTokenMiddleware
{
    /**
     * Handle an incoming request.
     */
    public function handle(Request $request, Closure $next)
    {
        // Check if user has valid API token in session
        if (!Session::has('api_token') || !Session::has('user')) {
            return redirect()->route('login');
        }

        return $next($request);
    }
}
