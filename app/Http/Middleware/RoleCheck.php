<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;

class RoleCheck
{
    /**
     * Handle an incoming request.
     *
     * @param Request  $request
     * @param \Closure $next
     * @param string   $userType
     *
     * @return mixed
     */
    public function handle(Request $request, Closure $next, string $userType)
    {
        if (optional(auth()->user())->user_type !== $userType) {
            return response()->json(['code' => 403], 403);
        }

        return $next($request);
    }
}
