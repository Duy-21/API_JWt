<?php

namespace App\Http\Middleware;

use Closure;
use JWTAuth;

class JwtVerify
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
        try {
            $user = JWTAuth::parseToken()->authenticate();
            if (!$user) {
                return response()->json([], 401);
            }
        } catch (\Throwable $e) {
            return response()->json(['code' => 401, 'status' => 'Authorization Token not found']);
        }
        return $next($request);
    }
}
