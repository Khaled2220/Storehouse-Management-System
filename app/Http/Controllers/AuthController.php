<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use App\Http\Requests\RegisterRequest;
use App\Http\Requests\LoginRequest; 


class AuthController extends Controller
{
/**
     * Display a listing of the resource.
     */
    public function index()
    {
        return view('login');
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        //
    }

    public function showRegister()
    {
        return view('register');
    }

    public function register(RegisterRequest $request)
    {
        $user = User::create([
            'full_name' => $request->full_name,
            'email' => $request->email,
            'password' => Hash::make($request->password),
            'user_type' => 2,

         //'password'=>$request->password,
         //'user_type' => ['nullable', 'in:0,1'],
        
        ]);
        return redirect('/');
    }
    
    public function showlogin()
    {
        return view('login');
    }
    
    public function login(LoginRequest $request)
    {
       $credentials = $request->only('email','password');

       if (Auth::attempt($credentials)) {
        //dd('ssss');

        $request->session()->regenerate();
        return redirect()->route('Products.index'); 
           
        }
        //dd('fffff');
        
        return back()->withErrors(['email' => 'Invalid email or password']);
    }
}    