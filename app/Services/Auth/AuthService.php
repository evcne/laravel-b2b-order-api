<?php

namespace App\Services\Auth;

use App\Repositories\Auth\AuthRepositoryInterface;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Auth;
use Illuminate\Http\JsonResponse;
use Illuminate\Support\Facades\Log;
use App\Helpers\Helper;

class AuthService implements AuthServiceInterface
{
    public function __construct(
        private AuthRepositoryInterface $authRepository
    ) {}

    public function login(array $credentials): JsonResponse
    {
        $user = $this->authRepository->findByEmail($credentials['email']);

        if (!$user || !Hash::check($credentials['password'], $user->password)) {
            //return response()->json(['message' => 'E-posta veya şifre hatalı.'], 401);

            return response()->json(
                Helper::gelfOutput(null, false, Helper::AUTH_FAILED_TEXT, Helper::A001)
            );            
        }

        $token = $user->createToken('auth_token')->plainTextToken;

        return response()->json([
            'success'=>  true,
            'message' => Helper::AUTH_SUCCESS_TEXT,
            'token' => $token,
            'token_type' => 'Bearer',
            'code' => Helper::A000,
        ]);         
        
    }

    public function register(array $data): JsonResponse
    {
        $data['password'] = bcrypt($data['password']);

        $user = $this->authRepository->create($data);
        $token = $user->createToken('auth_token')->plainTextToken;

        return response()->json([
            'success'=>  true,
            'message' => Helper::CREATE_SUCCESS_TEXT,
            'token' => $token,
            'token_type' => 'Bearer',
            'code' => Helper::C000,
            'user' => $user
        ]); 
    }

    public function logout(): JsonResponse
    {
        try {
            auth()->user()->currentAccessToken()->delete();

            return response()->json(
                Helper::gelfOutput(null, true, Helper::AUTH_LOGOUT_SUCCESS_TEXT, Helper::A000),
                200
            );
        } catch (\Exception $e) {
            return response()->json(
                Helper::gelfOutput(null, false, Helper::AUTH_LOGOUT_FAILED_TEXT, Helper::A001),
                500
            );
        }
    }
}
