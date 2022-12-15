<?php

namespace App\Http\Controllers;

use App\Mail\VerifyEmail;
use App\Models\Email;
use App\Models\User;
use Illuminate\Auth\Events\Registered;
use Illuminate\Auth\Events\Verified;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Str;

class EmailController extends Controller
{
    public function store(Request $request): JsonResponse
    {
        $email =  Email::create([
            'email'    => $request->email,
            'user_id' => $request->user_id,
            'token' => Str::random(60)
        ]);

        $user= User::findOrFail($request->user_id);

        Mail::to($request->primary)->send(new VerifyEmail($email));


        return response()->json([
            "message" => "Email created successfully!",
            "success" => true
        ]);
    }

    public function emailVerify($token): JsonResponse
    {
        $verifiedUser = Email::where('token', $token)->first();


        if ($verifiedUser->markEmailAsVerified()) {
            event(new Verified($verifiedUser));
        }

        return response()->json([
            "message" => "Email verified successfully!",
            "success" => true
        ]);
        return response($token);
    }

    public function getUserEmail($id): JsonResponse
    {
        $user = User::with('emails')->where('id', '=', $id)->get();

        return response()->json($user);
    }

    public function destroy($id): JsonResponse
    {
        $userEmail = Email::find($id);
        $userEmail->delete();
        return response()->json('Email removed Successfully');
    }
}
