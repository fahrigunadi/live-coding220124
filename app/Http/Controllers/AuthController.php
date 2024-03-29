<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class AuthController extends Controller
{
    public function login()
    {
        return view('login');
    }

    public function doLogin(Request $request)
    {
        $credentials = $request->validate([
            'email' => 'required',
            'password' => 'required',
        ]);

        if (Auth::attempt($credentials)) {
            $request->session()->regenerate();

            return to_route('items.index');
        } else {
            return back()->withErrors([
                'email' => 'Wrong email or password',
            ]);
        }
    }

    public function logout(Request $request)
    {
        Auth::logout();

        $request->session()->regenerate();

        return to_route('login');
    }
}
