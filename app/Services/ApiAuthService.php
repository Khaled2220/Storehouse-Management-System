<?php

namespace App\Services;

use App\Models\User;
use Illuminate\Support\Facades\Hash;

class ApiAuthService
{
    public function __construct(private WebAuthService $webAuthService) 
    {
        //
    }

    public function register(array $data): array
    {
        $user = $this->webAuthService->register($data);

        $token = $user->createToken('AuthToken')->plainTextToken;

        return [
            'token' => $token,
            'user' => $user,
        ];
    }

    public function login(array $data): ?array
    {
        $user = User::where('email', $data['email'])->first();

        if (!$user || !Hash::check($data['password'], $user->password)) {
            return null;
        }

        $token = $user->createToken('auth_token')->plainTextToken;

        return [
            'access_token' => $token,
            'token_type' => 'Bearer',
            'user' => $user,
        ];
    }
}
