<?php

namespace App\Http\Middleware;

use Closure;
use Exception;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;
use Tymon\JWTAuth\Exceptions\TokenExpiredException;
use Tymon\JWTAuth\Exceptions\TokenInvalidException;
use Tymon\JWTAuth\Facades\JWTAuth;

class JWTMiddleware
{
    /**
     * Handle an incoming request.
     *
     * @param Closure(Request): (Response) $next
     */
    public function handle(Request $request, Closure $next): Response
    {
        try {
            $user = JWTAuth::parseToken()->authenticate();
            return response()->json(['status' => 'success', 'user' => $user]);
        } catch (Exception $e) {
            if ($e instanceof TokenInvalidException){
                return response()->json(['status' => 'error' ,'message' => 'Token is Invalid', 'user' => null],422);
            }else if ($e instanceof TokenExpiredException){
                return response()->json(['status' => 'error' ,'message' => 'Token is Expired', 'user' => null],422);
            }else{
                return response()->json(['status' => 'error' ,'message' => 'Authorization Token not found', 'user' => null],422);
            }
        }
    }
}
