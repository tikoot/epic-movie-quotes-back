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
}
