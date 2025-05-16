<?php

namespace App\Http\Controllers;

use Illuminate\Foundation\Auth\EmailVerificationRequest;
use Illuminate\Support\Facades\Auth;

class EmailController extends Controller
{
    public static function show()
    {
        return view('email.verify');
    }

    public static function verify(EmailVerificationRequest $request)
    {
        $request->fulfill();

        return redirect('/')->with('verified', 'Email verified successfully.');
    }

    public static function send()
    {
        // Assuming you have a user instance
        $user = Auth::user();

        if ($user->hasVerifiedEmail()) {
            return response()->json(['message' => 'Email already verified.'], 200);
        }

        $user->sendEmailVerificationNotification();

        return back()->with('message', 'Verification link sent');
    }
}
