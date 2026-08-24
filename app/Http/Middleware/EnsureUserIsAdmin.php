<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class EnsureUserIsAdmin
{
    /**
     * Handle an incoming request.
     *
     * @param  Closure(Request): (Response)  $next
     */
   public function handle(Request $request, Closure $next): Response
   {
     if (!auth()->check()) {
        return redirect()->route('login');
    }

     if (auth()->user()->user_type !== 1) {
            return redirect()->route('Products.index')->with('error', 'Unauthorized access! Admin only.');
        }

        return $next($request);
    }
}