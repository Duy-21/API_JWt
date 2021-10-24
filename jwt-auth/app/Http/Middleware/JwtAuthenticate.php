<?php

namespace App\Http\Middleware;

use Illuminate\Auth\Middleware\Authenticate as Middleware;
use Closure;
use JWTAuth;

class JwtAuthenticate extends Middleware
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

        } catch (\Exception $e) {

                $newToken = JWTAuth::parseToken()->refresh();
                return response()->json([
                    'code' => 401, 
                    'status' => 'Authorization Token not found or expired',
                    'token' => $newToken
                ]);
        }

        return $next($request);
    }
}