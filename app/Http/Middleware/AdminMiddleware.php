<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class AdminMiddleware
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next): Response
    {
	    if (!auth()->user() || !auth()->user()->isAdmin()) {
		    // Redirect to a specific route or abort with a 403 error
		    return redirect('/')->with('error', 'You are not authorized to access this page.');
	    }

        return $next($request);
    }
}
