<?php

namespace App\Http\Middleware;

use App\Enums\UserType;
use Closure;

class EnsureCollectorIsVerified
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
        $user = $request->user();

        if (!$user) {
            return $next($request);
        }

        if ($user->type != UserType::COLLECTOR) {
            return $next($request);
        }

        if (optional($user->collector)->is_verified) {
            return $next($request);
        }

        abort(403, "You haven't been verified yet.");
    }
}
