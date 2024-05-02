<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Validation\ValidationException;

class AuthenticationController extends Controller
{
    public function issueToken(Request $request): JsonResponse
    {
        $request->validate([
            'email' => 'required|email',
            'password' => 'required',
        ]);

        if (Auth::attempt($request->only('email', 'password'))) {
            $user = User::where('email', $request->email)->first();

            $token = $user->createToken(
                'media-upload-token',
                ['media-upload'],
                now()->addHour()
            );

            return response()->json([
                'data' => [
                    'token' => $token->plainTextToken,
                    'expires_at' => $token->accessToken->created_at->addHour()->toDateTimeString(),
                ],
            ]);
        }

        throw ValidationException::withMessages([
            'email' => ['The provided credentials are incorrect.'],
        ]);
    }
}
