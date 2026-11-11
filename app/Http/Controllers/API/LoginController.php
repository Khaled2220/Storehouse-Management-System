<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use App\Http\Requests\LoginRequest;
use App\Http\Resources\UserResource;
use App\Services\ApiAuthService;

class LoginController extends Controller
{
    public function __construct(private ApiAuthService $authService)
    {
        //
    }

    public function login(LoginRequest $request)
    {
        $result = $this->authService->login($request->validated());

        if (! $result) {
            return response()->json([
                'status' => false,
                'message' => 'Invalid email or password',
            ], 401);
        }
        return response()->json([
            'status' => true,
            'message' => 'Login successful',
            'access_token' => $result['access_token'],
            'token_type' => $result['token_type'],
            'user' => new UserResource($result['user']),
        ], 200);
    }
}
