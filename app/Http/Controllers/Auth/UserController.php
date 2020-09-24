<?php

namespace App\Http\Controllers\Auth;

use Auth;
use App\Http\Controllers\Controller;
use App\User;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;

class UserController extends Controller
{

    public function register()
    {
        $this->validate(request(), [
            'email' => ['required','email', 'unique:users'],
            'password' => ['required', 'confirmed'],
            'name' => ['required','string']
        ]);

        $data = request(['email', 'password', 'name']);

        $data['password'] = Hash::make($data['password']);

        $user = User::create($data);

        $token = $user->createToken('auth_sys');
        $accessToken = $token->accessToken;
        $res = [
            'status' => true,
            'message' => 'successful',
            'code' => 200,
            "data" => [
                'user' => $user,
                'token' => [
                    'access_token' => $accessToken,
                    'token_type' => 'Bearer',
                    'expires_at' => Carbon::parse(
                        $token->token->expires_at
                    )->toDateTimeString()
                ]
            ]
        ];

        return response()->json($res, 200);
    }
    
    public function login()
    {
        $credentials = request(['email', 'password']);


        if (!Auth::attempt($credentials)) {

            $res = [
                'status' => false,
                'code' => 401,
                'message' => 'Unauthorized',
                'description' => 'Wrong credentials'
            ];
            return response()->json($res, 401);
        }

        $user = request()->user();
        $token = $user->createToken('Personal Access Token');
        $accessToken = $token->accessToken;

        $res = [
            'status' => true,
            'code' => 200,
            'message' => 'Success',
            'user' => $user,
            'token' => [
                'access_token' => $accessToken,
                'token_type' => 'Bearer',
                'expires_at' => Carbon::parse(
                    $token->token->expires_at
                )->toDateTimeString()
            ]
        ];

        return response()->json($res, 200);
    }
}
