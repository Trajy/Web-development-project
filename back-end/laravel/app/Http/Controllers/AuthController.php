<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\User;

class AuthController extends Controller
{

    public function register(Request $resquest) {
        $user = User::create($resquest->only('name', 'email', 'password'));
        if(!$user) {
            abort(418, 'Register Fail');
        }
        return response()->json($user);
    }

    public function login(Request $request) {
        $user = User::where('email', $request->email)->where('password', $request->password)->first();
        if(!$user) {
            abort(401, 'Invalid Credentials');
        }
        $token = $user->createToken('auth_token');
        return response()->json(['token' => $token->plainTextToken]);
    }

    public function logout()
    {
        return $this->user()->currentAccessToken()->delete();
    }

}
