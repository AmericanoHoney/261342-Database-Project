<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\User;

class AuthController extends Controller
{
    public function showLogin() {
        return view('login');
    }

    public function login(Request $request) {
        $request->validate([
            'email' => 'required|email',
            'password' => 'required',
        ]);

        $credentials = $request->only('email', 'password');

        if(Auth::attempt($credentials)) {
            $request->session()->regenerate();
            return redirect()->route('home');
        }

        $user = User::where('email', $request->email)->first();
        if(!$user){
            return back()->with('error', 'This Email is not registered');
        }

        return back()->with('error', 'Incorrect Password');
    }

    public function home() {
        return view('home'); // หน้า home ของคุณ
    }

    public function showSignup() {
        return view('signup'); // หน้า signup
    }
}
