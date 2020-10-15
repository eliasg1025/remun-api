<?php

namespace App\Http\Middleware;

use App\Services\JwtAuthService;
use Closure;

class ApiAuthenticate
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
        $token = $request->header('Authorization');

        if (!$token) {
            return response()->json([
                'message' => 'Token no existe o inválido'
            ], 401);
        }
        $check = JwtAuthService::checkToken($token, true);

        if (!$check) {
            return response()->json([
                'message' => 'No autorizado'
            ], 401);
        }
        $request->attributes->add(['user' => $check]);
        return $next($request);
    }
}
