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
        auth('api')->logout();
        return response()->json(['msg' => 'Deslogado com sucesso']);
    }

    public function refresh() {
        $token = auth('api')->refresh();
        return response()->json(['token' => $token]);
    }

    public function me() {
        return response()->json(auth()->user());
    }
}
