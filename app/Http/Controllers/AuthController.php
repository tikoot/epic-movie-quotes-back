<?php

namespace App\Http\Controllers;

use App\Http\Requests\RegisterUserRequest;
use App\Http\Requests\StorePostRequest;
use App\Models\User;
use Illuminate\Auth\Events\Registered;
use Illuminate\Auth\Events\Verified;
use Illuminate\Http\JsonResponse;
use Carbon\Carbon;
use Firebase\JWT\JWT;
use Illuminate\Http\Request;

class AuthController extends Controller
{
    public function register(RegisterUserRequest $request): JsonResponse
    {
        $user = User::create([
            'username' => $request->username,
            'email'    => $request->email,
            'password' => $request->password,
        ]);

        event(new Registered($user));

        return response()->json('User successfuly registered!', 200);
    }

    public function verify(Request $request): JsonResponse
    {
        $user = User::findOrFail($request->id);

        if ($user->markEmailAsVerified()) {
            event(new Verified($user));
        }

        return response()->json([
            "message" => "Email verified successfully!",
            "success" => true
        ]);
    }

    public function login(StorePostRequest $request): JsonResponse
    {
        $login= $request->email;

        $fieldType = filter_var($login, FILTER_VALIDATE_EMAIL) ? 'email' : 'username';

        $authenticated = auth()->attempt(
            [
                $fieldType => $login,
                'password' => $request->password,
            ]
        );

        if (!$authenticated) {
            return response()->json('wrong email or password', 401);
        }

        $payload = [
            'exp' => Carbon::now()->addMinutes(50)->timestamp,
            'uid' => User::where('email', '=', request()->email)
            ->orWhere('username', '=', request()->email)
            ->first()->id,
        ];

        $jwt = JWT::encode($payload, config('auth.jwt_secret'), 'HS256');

        $cookie = cookie("access_token", $jwt, 50, '/', config('auth.front_end_top_level_domain'), true, true, false, 'Strict');

        return response()->json('success', 200)->withCookie($cookie);
    }

    public function me(): JsonResponse
    {
        return response()->json(
            [
                'message' => 'authenticated successfully',
                'user' => jwtUser()
            ],
            200
        );
    }

    public function logout(): JsonResponse
    {
        $cookie = cookie("access_token", '', 0, '/', config('auth.front_end_top_level_domain'), true, true, false, 'Strict');

        return response()->json('success', 200)->withCookie($cookie);
    }
}
