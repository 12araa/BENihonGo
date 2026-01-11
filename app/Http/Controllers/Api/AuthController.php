<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\Request;

class AuthController extends Controller
{
    // POST /api/login
    public function login(Request $request)
    {
        // Frontend kirim: { "email": "player@gmail.com", "password": "password123" }

        // MOCK: Kita tidak cek password beneran.
        // Pokoknya kalau ada emailnya, kita anggap login sukses.
        $user = User::where('email', $request->email)->first();

        if (!$user) {
            return response()->json(['message' => 'User tidak ditemukan'], 401);
        }

        // Return token palsu (dummy token)
        return response()->json([
            'success' => true,
            'message' => 'Login Berhasil (Mock)',
            'token' => 'dummy-token-xyz-123',
            'user' => [
                'id' => $user->id,
                'name' => $user->name,
                'email' => $user->email,
                'role' => $user->role,
            ]
        ]);
    }

    // POST /api/register
    public function register(Request $request)
    {
        // MOCK: Pura-pura sukses daftar
        return response()->json([
            'success' => true,
            'message' => 'Registrasi Berhasil! Silakan Login.',
        ]);
    }

    // POST /api/logout
    public function logout()
    {
        return response()->json([
            'success' => true,
            'message' => 'Logout Berhasil',
        ]);
    }
}
