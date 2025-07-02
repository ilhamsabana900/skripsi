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

        if ($user) {
            if ($user->role === 'admin') {
                // Cek password admin secara manual (plain text)
                if ($credentials['password'] === $user->password) {
                    if ($request->expectsJson()) {
                        // Jika request dari API/mobile, kembalikan JSON
                        $token = $user->createToken('mobile')->plainTextToken;
                        return response()->json([
                            'token' => $token,
                            'role' => $user->role,
                            'user' => $user,
                        ]);
                    } else {
                        // Jika request dari web, login dan redirect ke dashboard
                        Auth::login($user);
                        return redirect('/dashboard');
                    }
                }
            } else {
                // Role lain tetap pakai bcrypt
                if (Hash::check($credentials['password'], $user->password)) {
                    if ($request->expectsJson()) {
                        $token = $user->createToken('mobile')->plainTextToken;

                        // Ambil siswa_id dan nis jika user adalah siswa
                        $siswa = $user->siswa; // Pastikan relasi user -> siswa sudah ada di model User
                        $guru = $user->guru;   // Ambil relasi guru jika ada

                        // Eager load relasi guru dan user
                        $userWithRelations = User::with(['guru.user'])->find($user->id);

                        return response()->json([
                            'token' => $token,
                            'role' => $user->role,
                            'user' => $userWithRelations,
                            'siswa_id' => $siswa ? $siswa->id : null,
                            'nis' => $siswa ? $siswa->nis : null,
                        ]);
                    } else {
                        Auth::login($user);
                        return redirect('/dashboard');
                    }
                }
            }
        }

        // Jika gagal, kembalikan sesuai tipe request
        if ($request->expectsJson()) {
            return response()->json([
                'error' => 'Username atau password salah.'
            ], 401);
        } else {
            return back()->withErrors([
                'login' => 'Username atau password salah.'
            ]);
        }
    }

    public function logout(Request $request)
    {
        Auth::logout();
        $request->session()->invalidate();
        $request->session()->regenerateToken();
        return redirect('/login');
    }

    
}
