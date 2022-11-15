<?php

namespace App\Http\Controllers;

use App\Http\Requests\RegisterUserRequest;
use App\Models\User;
use Illuminate\Auth\Events\Registered;
use Illuminate\Auth\Events\Verified;
use Illuminate\Http\JsonResponse;
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
}
