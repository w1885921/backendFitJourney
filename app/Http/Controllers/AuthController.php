<?php

namespace App\Http\Controllers;


use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Mail;
use App\Mail\VerificationMail;

class AuthController extends Controller
{
    public function register(Request $request)
    {
        $request->validate([
            'full_name' => 'required|string',
            'email' => 'required|email|unique:users',
            'password' => 'required|min:6',
            'date_of_birth' => 'required|date',
            'mobile_number' => 'required|string',
            'height' => 'nullable|numeric', 
            'weight' => 'nullable|numeric',
            'gender' => 'nullable|string',
        ]);

        $height = $request->height; // in meters
        $weight = $request->weight; // in kg

        $bmi = $weight / ($height * $height);
        $verificationCode = uniqid();

        $user = User::create([
            'full_name' => $request->full_name,
            'email' => $request->email,
            'password' => Hash::make($request->password),
            'date_of_birth' => $request->date_of_birth,
            'mobile_number' => $request->mobile_number,
            'height' => $request->height ? (float) $request->height : null,
            'weight' => $request->weight ? (float) $request->weight : null,
            'gender' => $request->gender,
            'bmi' => $bmi,
            'verification_code' => $verificationCode,
            'is_verified' => false,
        ]);

        $token = $user->createToken('auth_token')->plainTextToken;

        Mail::to($user->email)->send(new VerificationMail($user));
        return response()->json([
            'user' => $user,
            'token' => $token
        ], 201);
    }

    public function resendCode(Request $request)
    {
        $user = auth()->user();
        $verificationCode = uniqid();
        $user->verification_code = $verificationCode;
        $user->save();
        Mail::to($user->email)->send(new VerificationMail($user));

        
        return response()->json([
            'user' => $user,
        ], 201);
    }

    public function verify(Request $request)
    {
        try {
            $user = auth()->user();
        $request->validate(['verification_code' => 'required']);

        $user = User::where('email', $user->email)
                    ->where('verification_code', $request->verification_code)
                    ->first();

        if (!$user) {
            return response()->json(['message' => 'Invalid code'], 400);
        }

        $user->is_verified = true;
        $user->verification_code = null;
        $user->save();

        return response()->json([
            'message' => 'Email verified successfully',
            'user' => $user
        ], 200);
        } catch (\Throwable $th) {
            return response()->json([
                'message' => 'Email not verified',
                'user' => $user
            ], 500);
        }
    }

    public function login(Request $request)
    {
        $request->validate([
            'email' => 'required|email',
            'password' => 'required'
        ]);

        $user = User::where('email', $request->email)->first();

        if (!$user || !Hash::check($request->password, $user->password)) {
            return response()->json([
                'message' => 'Invalid credentials'
            ], 401);
        }

        $token = $user->createToken('auth_token')->plainTextToken;
        return response()->json([
            'user' => $user,
            'token' => $token
        ]);
    }
}
