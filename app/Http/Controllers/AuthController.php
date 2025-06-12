<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use App\Models\User;

class AuthController extends Controller
{
    public function showLoginForm()
    {
        return view('auth.login');
    }

    public function login(Request $request)
    {
        $credentials = $request->validate([
            'username' => ['required'],
            'password' => ['required'],
        ]);

        $user = User::where('username', $credentials['username'])->first();

        // Cek password menggunakan Hash::check
        if ($user && Hash::check($credentials['password'], $user->password)) {
            $token = $user->createToken('mobile')->plainTextToken;
            return response()->json([
                'token' => $token,
                'role' => $user->role,
                'user' => $user,
            ]);
        }

        // Jika gagal, tetap kembalikan JSON
        return response()->json([
            'error' => 'Username atau password salah.'
        ], 401);
    }

    public function logout(Request $request)
    {
        Auth::logout();
        $request->session()->invalidate();
        $request->session()->regenerateToken();
        return redirect('/login');
    }
}
