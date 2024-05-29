<?php

namespace App\Http\Controllers\Auth;

use App\Domain\Errors\CatchException;
use App\Http\Controllers\Controller;
use App\Http\Requests\Auth\AuthLoginRequest;
use App\Repository\UserRepository;
use Tymon\JWTAuth\Facades\JWTAuth;

class AuthController extends Controller
{
    public function __construct(
        private readonly UserRepository $repository
    ) {}
    
    public function login(AuthLoginRequest $request)
    {
        try {
            $credentials = $request->only(['email', 'password']);
            if (!$token = auth()->attempt($credentials)) {
                return response()->json(['error' => 'Credenciales incorrectas'], 401);
            }
            return response()->json($this->respondWithToken($token));
        } catch (\Throwable $th) {
            $e = new CatchException($th);
            return response()->json($e->getMessage(), $e->getCode());
        }
    }

    public function userSession()
    {
        return response()->json($this->user());
    }

    public function logout()
    {
        auth()->logout(true);
        return response()->json(['message' => 'Cerró sesión exitosamente']);
    }

    public function refresh()
    {
        return response()->json($this->respondWithToken(JWTAuth::refresh()));
    }


    protected function respondWithToken( $token)
    {
        $expiresIn = JWTAuth::factory()->getTTL() * 60;
        $user = $this->user();
        return [
            'token' => $token,
            'token_type' => 'bearer',
            'expires_in' => $expiresIn,
            'profile'=> $user["profile"],
            'role' => $user["role"],
        ];
    }

    private function user()  {
        $user = auth()->user();
        $profile = $this->repository->getRecord($user->email);
        $profile = $profile->teacher;
        if($profile->tutor) {
            $profile = $profile->tutor;
        }
        return ["profile"=>$profile, "role"=> $user->role];
    }
}
