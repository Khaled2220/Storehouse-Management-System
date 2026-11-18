<?php

namespace App\Http\Controllers;

use App\Http\Requests\LoginRequest;
use App\Http\Requests\RegisterRequest;
use App\Services\WebAuthService;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\View\View;

class AuthController extends Controller
{
    public function __construct(private WebAuthService $authService)
    {
        //
    }

    public function showRegister(): View
    {
        return view('register');
    }

    public function register(RegisterRequest $request): RedirectResponse
    {
        $this->authService->register($request->validated());

        return redirect()->route('login');
    }

    public function showLogin(): View
    {
        return view('login');
    }

    public function login(LoginRequest $request): RedirectResponse
    {
        if (! $this->authService->attemptLogin($request->validated())) {
            return back()
                ->withErrors([
                    'email' => 'Invalid email or password',
                ])
                ->onlyInput('email');
        }

        $request->session()->regenerate();

        return redirect()->route('products.index');
    }

    public function logout(Request $request): RedirectResponse
    {
        $this->authService->logout();

        $request->session()->invalidate();

        $request->session()->regenerateToken();

        return redirect()->route('login');
    }
}
