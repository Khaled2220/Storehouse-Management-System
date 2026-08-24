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
        //$request->validate([
          //  'full_name' => ['required','string'],
           // 'email' => ['required','unique:users'],
           // 'password' => ['required','min:6','max:20']
      //  ]);

        $user = User::create([
            'full_name' => $request->full_name,
            'email' => $request->email,
            'password' => Hash::make($request->password),
          //'password'=>$request->password,
            'user_type' => 2,
         //'user_type' => ['nullable', 'in:0,1'],
        
        ]);
        return redirect('/');
        //return redirect()->action([AuthController::class, 'login']);
          // return redirect('/login')->with('success', 'Registration successful. Please log in.');
        //return redirect('/login');
    }
    
    public function showlogin()
    {
    return view('login');
    }
    
    public function login(LoginRequest $request)
    {
        $credentials = $request->only('email','password');
        //validate([
          //  'email' => ['required', 'string', 'email'],
            //'password' => ['required', 'string']
        //]);

  //dd(Auth::attempt($credentials));
       if (Auth::attempt($credentials)) {
        //dd('ssss');
            $request->session()->regenerate();
           return redirect()->route('Products.index'); 
           
        }
        //dd('fffff');
          return back()->withErrors(['email' => 'Invalid email or password']);
     //return redirect()->route('Products.index');

    }
}    