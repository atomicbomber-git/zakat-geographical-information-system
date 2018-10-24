<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Support\Facades\Auth;

class RedirectIfAuthenticated
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @param  string|null  $guard
     * @return mixed
     */
    public function handle($request, Closure $next, $guard = null)
    {
        if (Auth::guard($guard)->check()) {
            switch (auth()->user()->type) {
                case 'ADMINISTRATOR':
                    return redirect()->route('collector.index');
                case 'COLLECTOR':
                    return redirect()->route('collector.report.index', auth()->user()->collector);
            }
        }

        return $next($request);
    }
}
