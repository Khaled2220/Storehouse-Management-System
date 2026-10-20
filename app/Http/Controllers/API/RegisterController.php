<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\User;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\File;
use App\Http\Requests\RegisterRequest;

class RegisterController extends Controller
{
      //public function showRegister()
 // {
 // return view('register');
 // }
    public function register(RegisterRequest $request)
    {
         //  $validator = Validator::make($request->all(), [
          //  'full_name' => ['required', 'string'],
          //  'email' => ['required', 'email', 'unique:users,email'],
         //   'password' => ['required', 'min:6', 'max:20']
       // ]);
       //  if ($validator->fails()) {
         //   return response()->json([
            //    'status' => false,
            //    'message' => 'Validation error',
          //      'errors' => $validator->errors()
        //    ], 422);
      //  }

        $validated = $request->validated();
        $user = User::create([
            'full_name' => $request->full_name,
            'email' => $request->email,
            'password' => Hash::make($request->password),
            'user_type' => 2, 
        ]);

        $token = $user->createToken('AuthToken')->plainTextToken;
            return response()->json([
              'status' => true,
              'message' => 'User registered successfully!',
              'token' => $token,
              'user' => $user
            ], 201); 
    }
}


