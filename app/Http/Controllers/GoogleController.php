<?php

namespace App\Http\Controllers;

use App\Models\SocialAcoount;
use App\Models\User;
use Carbon\Carbon;
use Exception;
use Firebase\JWT\JWT;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Laravel\Socialite\Facades\Socialite;
use Illuminate\Support\Str;

class GoogleController extends Controller
{
    public function redirectToProvider(): JsonResponse
    {
        $url =  Socialite::driver('google')->stateless()->redirect()->getTargetUrl();
        return response()->json(['url' => $url]);
    }

    public function handleProviderCallback(): JsonResponse
    {
        $user = Socialite::driver('google')->stateless()->user();

        $userFind = User::where('google_id', $user->id)->first();

        if (!$userFind) {
            $userFind = User::create([
            'username' => $user->name,
            'email'    => $user->email,
            'password' => $user->id,
            'google_id' => $user->id,
            'email_verified_at' =>  Carbon::now()->format('d-m-Y')
            ]);

            auth()->attempt(
                [
                    'email' => $user->email,
                    'password' => $user->id
                ]
            );


            $payload = [
                'exp' => Carbon::now()->addMinutes(30)->timestamp,
                'uid' => User::where('email', '=', $user->email)->first()->id,
            ];

            $jwt = JWT::encode($payload, config('auth.jwt_secret'), 'HS256');

            $cookie = cookie("access_token", $jwt, 30, '/', config('auth.front_end_top_level_domain'), true, true, false, 'Strict');

            return response()->json('success', 200)->withCookie($cookie);
        } else {
            auth()->attempt(
                [
                    'email' => $user->email,
                    'password' => $user->id
                ]
            );


            $payload = [
                'exp' => Carbon::now()->addSeconds(30)->timestamp,
                'uid' => User::where('email', '=', $user->email)->first()->id,
            ];

            $jwt = JWT::encode($payload, config('auth.jwt_secret'), 'HS256');

            $cookie = cookie("access_token", $jwt, 30, '/', config('auth.front_end_top_level_domain'), true, true, false, 'Strict');

            return response()->json('success', 200)->withCookie($cookie);
        }
        return response()->json('success', 200);
    }
}
