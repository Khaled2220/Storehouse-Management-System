<?php

namespace App\Http\Middleware;

use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;
use Closure;

class EnsureUserIsAdmin
{
    public function handle(Request $request, Closure $next): Response
    {
        $user = $request->user();

        if (! $user) {
            return redirect()->route('login');
        }
        if (! $user->isAdmin()) {
            return redirect()
                ->route('products.index')
                ->with('error', 'Unauthorized access! Admin only.');
        }
        return $next($request);
    }
}
