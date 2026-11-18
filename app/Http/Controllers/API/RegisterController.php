<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use App\Http\Requests\RegisterRequest;
use App\Http\Resources\UserResource;
use App\Services\ApiAuthService;
use Illuminate\Http\JsonResponse;

class RegisterController extends Controller
{
    public function __construct(private ApiAuthService $authService)
    {
        //
    }

    public function register(RegisterRequest $request): JsonResponse
    {
        $result = $this->authService->register($request->validated());

        return response()->json([
            'status' => true,
            'message' => 'User registered successfully!',
            'access_token' => $result['access_token'],
            'token_type' => $result['token_type'],
            'user' => new UserResource($result['user']),
        ], 201);
    }
}
