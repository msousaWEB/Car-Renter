<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class AuthController extends Controller
{
    public function login(Request $request) {
        $login = $request->all(['email', 'password']);
        $token = auth('api')->attempt($login);

        if($token) {
            return response()->json(['token' => $token]);
        } else {
            return response()->json(['error' => 'Login inválido'], 403);
        }

        dd($token);

        return 'login';
    }

    public function logout() {
        return 'logout';
    }

    public function refresh() {
        return 'refresh';
    }

    public function me() {
        return response()->json(auth()->user());
    }
}
