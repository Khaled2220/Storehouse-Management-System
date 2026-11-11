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

        return $this->formatAuthResponse($user);
    }

    public function login(array $data): ?array
    {
        $user = User::where('email', $data['email'])->first();

        if (! $user || ! Hash::check($data['password'], $user->password)) {
            return null;
        }

        return $this->formatAuthResponse($user);
    }

    private function formatAuthResponse(User $user): array
    {
        return [
            'access_token' => $user->createToken('auth_token')->plainTextToken,
            'token_type' => 'Bearer',
            'user' => $user,
        ];
    }
}
