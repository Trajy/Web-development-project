<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\User;

class AuthController extends Controller
{

    public function register(Request $resquest) {
        $values = $resquest->only('name', 'email', 'password');
        $values['type'] = str_contains(url()->current(), 'employer') ? 'employer' : 'employee';
        $user = User::create($values);
        if(!$user) {
            abort(418, 'Register Fail');
        }
        return $user;
    }

    public function login(Request $request) {
        $user = User::where('email', $request->email)->where('password', $request->password)->first();
        if(!$user) {
            abort(401, 'Invalid Credentials');
        }
        $token = $user->createToken('auth_token', [$user->type]);
        return response()->json(['token' => $token->plainTextToken, 'client_type' => $user->type]);
    }

    public function logout()
    {
        auth()->user()->currentAccessToken()->delete();
    }

    public function user()
    {
        return auth()->user();
    }

}
