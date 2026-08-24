<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\User;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;

use App\Http\Requests\LoginRequest; 

class LoginController extends Controller
{
 // public function showlogin()
 // {
 // return view('login');
 // }
    
public function login(LoginRequest $request)
{
  //  $request->validate([
  //      'email' => 'required|email',
  //      'password' => 'required'
  //  ]);
    
    $validated = $request->validated();
    $user = User::where('email', $validated->email)->first();

    if (!$user || !Hash::check($validated->password, $user->password)) {
        return response()->json([
            'status' => false,
            'message' => 'Invalid email or password'
        ], 401);
    }

    $token = $user->createToken('auth_token')->plainTextToken;

    return response()->json([
        'status' => true,
        'message' => 'Login successful',
        'access_token' => $token,
        'token_type' => 'Bearer',
        'user' => $user
    ], 200);
}
}