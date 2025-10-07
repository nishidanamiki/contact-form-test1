<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Requests\RegisterRequest;
use App\Http\Requests\LoginRequest;
use Illuminate\Support\Facades\Auth;

class AuthController extends Controller
{
    public function showLoginForm()
    {
        return view('auth.login');
    }

    public function showRegisterForm()
    {
        return view('auth.register');
    }

    public function login(LoginRequest $request)
    {
        if (Auth::attempt($request->only('email', 'password'))) {
            $request->session()->regenerate();
            return redirect('/admin');
        }
    }

    public function register(RegisterRequest $request)
    {
        $validated = User::create([
            'name' => $validated['name'],
            'email' => $validated['email'],
            'password' => $HASH::make($validated['password']),
        ]);
        Auth::login($user);
        return redirect()->route('admin');
    }

    public function logout(Request $request)
    {
        // ログアウト処理
        return redirect()->route('login');
    }
}
