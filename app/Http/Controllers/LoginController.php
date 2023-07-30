<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class LoginController extends Controller
{
    public function login(Request $request)
    {
        $credentials = $request->only('email', 'password');

        if (Auth::guard('teacher')->attempt($credentials)) {
            return redirect()->intended('/teacher/dashboard');
        }

        if (Auth::guard('student')->attempt($credentials)) {
            return redirect()->intended('/student/dashboard');
        }

        if (Auth::guard('superadmin')->attempt($credentials)) {
            return redirect()->intended('/principal/dashboard');
        }

        return back()->withErrors([
            'email' => 'El email o la contraseña son incorrectos',
        ])->withInput();
    }

    public function logout(Request $request)
    {
        Auth::guard('teacher')->logout();
        Auth::guard('student')->logout();
        Auth::guard('superadmin')->logout();

        $request->session()->invalidate();

        $request->session()->regenerateToken();

        return redirect('/');
    }
}
