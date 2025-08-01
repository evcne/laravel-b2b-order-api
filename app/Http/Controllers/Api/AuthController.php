<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Requests\RegisterRequest;
use App\Http\Requests\LoginRequest;
use App\Models\User;
use Illuminate\Support\Facades\Hash;
use Illuminate\Http\Request;
use App\Services\Auth\AuthServiceInterface;
use Illuminate\Http\JsonResponse;


class AuthController extends Controller
{
    /*public function register(RegisterRequest $request)
    {
        $data = $request->validated();

        $user = User::create([
            'name' => $data['name'],
            'email' => $data['email'],
            'password' => Hash::make($data['password']),
            'role' => $data['role'] ?? 'customer',
        ]);

        $token = $user->createToken('auth_token')->plainTextToken;

        return response()->json([
            'message' => 'Kayıt başarılı',
            'token' => $token,
            'user' => $user,
        ], 201);
    }

    public function login(LoginRequest $request)
    {
        $data = $request->validated();

        $user = User::where('email', $data['email'])->first();

        if (!$user || !Hash::check($data['password'], $user->password)) {
            return response()->json(['message' => 'Geçersiz bilgiler'], 401);
        }

        $token = $user->createToken('auth_token')->plainTextToken;

        return response()->json([
            'message' => 'Giriş başarılı',
            'token' => $token,
            'user' => $user,
        ]);
    }

    public function logout(Request $request)
    {
        $request->user()->currentAccessToken()->delete();

        return response()->json(['message' => 'Çıkış yapıldı']);
    }*/

    
    public function __construct(
        private AuthServiceInterface $authService
    ) {}

    public function login(Request $request): JsonResponse
    {
        $data = $request->only('email', 'password');
        return $this->authService->login($data);
    }

    public function register(Request $request): JsonResponse
    {
        $data = $request->only('name', 'email', 'password');
        return $this->authService->register($data);
    }

    public function logout(Request $request): JsonResponse
    {
        return $this->authService->logout();
    }
}
