<?php

namespace App\Services;

use App\Enums\UserType;
use App\Models\User;
use Illuminate\Support\Facades\Auth;

class WebAuthService
{
    /**
     * Register a new regular user.
     */
    public function register(array $data): User
    {
        $data['user_type'] = UserType::USER->value;

        return User::create($data);
    }

    /**
     * Attempt to authenticate a user.
     */
    public function attemptLogin(array $credentials): bool
    {
        return Auth::attempt($credentials);
    }

    /**
     * Log out the authenticated user.
     */
    public function logout(): void
    {
        Auth::logout();
    }
}
