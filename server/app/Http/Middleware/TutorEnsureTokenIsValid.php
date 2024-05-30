<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;
use Tymon\JWTAuth\Exceptions\TokenExpiredException;
use Tymon\JWTAuth\Exceptions\TokenInvalidException;
use Tymon\JWTAuth\Facades\JWTAuth;

class TutorEnsureTokenIsValid
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */

     private $roles =["admin"=>1, "tutor"=>3];

    public function handle(Request $request, Closure $next): Response
    {
        try {
            $user = JWTAuth::parseToken()->authenticate();
            if (!in_array($user->role_id, array_values($this->roles))) {
                return response()->json(['error' => 'No autorizado'], 401);
            }
        }catch (TokenExpiredException $e) {
            return response()->json(['error' => 'Token Expirado'], 401);
        } catch (TokenInvalidException $e) {
            return response()->json(['error' => 'Token Invalidado'], 401);
        } catch (\Throwable $e) {
            return response()->json(['error' => 'No autorizado'], 401);
        }

        return $next($request);
    }
}