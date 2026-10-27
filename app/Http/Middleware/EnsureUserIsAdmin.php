<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class EnsureUserIsAdmin
{
    public function handle(Request $request, Closure $next): Response
    {
        if (!auth()->check()) {
            return redirect()->route('login');
        }

        if ((int) auth()->user()->user_type !== 1) {
            return redirect()
                ->route('Products.index')
                ->with('error', 'Unauthorized access! Admin only.');
        }

        return $next($request);
    }
}
