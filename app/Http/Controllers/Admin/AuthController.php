<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class AuthController extends Controller
{
    public function showLoginForm()
    {
        if (Auth::check()) {
            return redirect()->route('admin.dashboard');
        }
        return view('admin.login');
    }

    public function login(Request $request)
    {
        $input = $request->input('login') ?? $request->input('email');

        $request->validate([
            'password' => ['required'],
        ]);

        if (empty($input)) {
            return back()->withErrors([
                'login' => 'Email atau Username wajib diisi.',
                'email' => 'Email atau Username wajib diisi.',
            ])->withInput();
        }

        $remember = $request->boolean('remember');
        $password = $request->input('password');

        // Allow login using either email or name / username
        if (Auth::attempt(['email' => $input, 'password' => $password], $remember) ||
            Auth::attempt(['name' => $input, 'password' => $password], $remember)) {
            $request->session()->regenerate();
            return redirect()->intended(route('admin.dashboard'));
        }

        return back()->withErrors([
            'login' => 'Email / Username atau password yang Anda masukkan salah.',
            'email' => 'Email / Username atau password yang Anda masukkan salah.',
        ])->withInput();
    }

    public function logout(Request $request)
    {
        Auth::logout();
        $request->session()->invalidate();
        $request->session()->regenerateToken();
        return redirect()->route('admin.login');
    }
}
