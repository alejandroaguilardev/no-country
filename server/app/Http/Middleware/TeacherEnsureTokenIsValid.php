<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;
use Tymon\JWTAuth\Exceptions\TokenExpiredException;
use Tymon\JWTAuth\Exceptions\TokenInvalidException;
use Tymon\JWTAuth\Facades\JWTAuth;

class TeacherEnsureTokenIsValid
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */

     private $roles =["admin" => 1, "teacher" => 2];

    public function handle(Request $request, Closure $next): Response
    {
        $authorizedRoles = array_keys($this->roles);  
        try {
            $user = JWTAuth::parseToken()->authenticate();
            if (!in_array($user->role_id, array_values($this->roles))) {
                return response()->json(['error' => 'No estás autorizado autorizado debes ser un ' . implode(', ', $authorizedRoles)], 401);
            }
        }catch (TokenExpiredException $e) {
            return response()->json(['error' => 'Token Expirado'], 401);
        } catch (TokenInvalidException $e) {
            return response()->json(['error' => 'Token Invalidado'], 401);
        } catch (\Throwable $e) {
                return response()->json(['error' => 'No estás autorizado autorizado debes ser un ' . implode(', ', $authorizedRoles) ], 401);
        }

        return $next($request);
    }
}