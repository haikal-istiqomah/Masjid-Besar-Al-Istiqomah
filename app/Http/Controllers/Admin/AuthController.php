<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class AuthController extends Controller
{   
    //Method menampilkan form login admin
    public function showLoginForm()
    {
        return view('admin.login');
    }

    //Method login admin
    public function login(Request $request)
    {
        $request->validate([
            'email' => ['required','email'],
            'password' => ['required'],
        ]);

        if (Auth::attempt([
            'email' => $request->email,
            'password' => $request->password,
        ])) {
            $user = Auth::user();

            if (!in_array($user->role, ['admin', 'bendahara'])) {
                Auth::logout();
                return back()->withErrors(['email' => 'Anda tidak memiliki akses admin.']);
            }

            return redirect()->route('admin.dashboard');
        }

        return back()->withErrors(['email' => 'Email atau password salah.']);
    }

    //Method logout admin
    public function logout(Request $request)
    {
        auth()->logout();

        $request->session()->invalidate();
        $request->session()->regenerateToken();

        return redirect()->route('admin.login');
    }
}
