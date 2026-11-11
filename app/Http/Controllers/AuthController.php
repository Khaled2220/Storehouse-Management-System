<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Requests\LoginRequest;
use App\Http\Requests\RegisterRequest;
use App\Services\WebAuthService;

class AuthController extends Controller
{
    public function __construct(private WebAuthService $authService)
    {
        //
    }

    public function showRegister()
    {
        return view('register');
    }

    public function register(RegisterRequest $request)
    {
        $this->authService->register(
            $request->validated()
        );

        return redirect()->route('login');
    }

    public function showLogin()
    {
        return view('login');
    }

    public function login(LoginRequest $request)
    {
        $authenticated = $this->authService->attemptLogin(
            $request->validated()
        );
        
        if (! $authenticated) {
            return back()
                ->withErrors([
                    'email' => 'Invalid email or password',
                ])
                ->onlyInput('email');
        }
        $request->session()->regenerate();

        return redirect()->route('products.index');
    }

    public function logout(Request $request)
    {
        $this->authService->logout($request);

        return redirect()->route('login');
    }
}
