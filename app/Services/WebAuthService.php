<?php

namespace App\Services;

use App\Models\User;
use Illuminate\Support\Facades\Auth;
use App\Enums\UserType;
use Illuminate\Http\Request;

class WebAuthService
{
    /**
     * Create a new class instance.
     */
    public function __construct()
    {
        //
    }

     /**
     * Register a new regular user.
     */
    public function register(array $data): User
    {
        $data['user_type'] = UserType::USER->value;

        return User::create($data);
    }

    public function attemptLogin(array $credentials): bool
    {
        return Auth::attempt($credentials);
    }

    public function logout(Request $request): void
    {
        Auth::logout();

        $request->session()->invalidate();

        $request->session()->regenerateToken();
    }
}
