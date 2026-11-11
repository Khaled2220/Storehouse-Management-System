<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use App\Http\Requests\RegisterRequest;
use App\Http\Resources\UserResource;
use App\Services\ApiAuthService;

class RegisterController extends Controller
{
    public function __construct(private ApiAuthService $authService)
    {
        //
    }

    public function register(RegisterRequest $request)
    {
        $result = $this->authService->register(
            $request->validated()
        );
        return response()->json([
            'status' => true,
            'message' => 'User registered successfully!',
            'token' => $result['token'],
            'user' => new UserResource($result['user']),
        ], 201);
    }
}
