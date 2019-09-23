<?php

namespace App\Http\Middleware;

use Closure;

class EnsureUserIsVerified
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @return mixed
     */
    public function handle($request, Closure $next)
    {
        if ($request->user()) {
            $request->user()->is_verified ?: abort(403, "You haven't been verified.");
        }

        return $next($request);
    }
}
