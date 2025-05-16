<?php

namespace App\Http\Controllers;

use App\Http\Requests\LoginRequest;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Password;
use Illuminate\Support\Str;

class AuthController extends Controller
{
    public static function index()
    {
        return view('auth.login');
    }

    public static function login(LoginRequest $request)
    {
        $credentials = $request->validated();

        if (auth()->attempt($credentials)) {
            return redirect(route('tasks.index'));
        }

        return redirect()->back()->withErrors([
            'email' => 'The provided credentials do not match our records.',
        ]);
    }

    public static function logout()
    {
        Auth::guard('web')->logout();
        return redirect(route('auth.index'));
    }


    public static function forgot_password()
    {
        return view('auth.forgot_password_mail');
    }

    public static function send_reset_token(Request $request)
    {
        $request->validate(['email' => 'required|email',]);

        $status = Password::sendResetLink(
            $request->only('email')
        );

        return $status === Password::RESET_LINK_SENT
            ? back()->with('status', __($status))
            : back()->withErrors(['email' => __($status)]);
    }

    public static function new_password(string $token)
    {
        return view('auth.forgot_password', ['token' => $token]);
    }

    public static function reset_password(Request $request)
    {
        $request->validate([
            'token' => 'required',
            'email' => 'required|email',
            'password' => 'required|confirmed|min:8',
        ]);

        $status = Password::reset(
            $request->only('email', 'password', 'password_confirmation', 'token'),

            function (User $user, string $password) {
                $user->forceFill([
                    'password' => Hash::make($password),
                ])->setRememberToken(Str::random(60));

                $user->save();
            }
        );

        return $status === Password::PASSWORD_RESET
                ? redirect()->route('auth.index')->with('status', __($status))
                : back()->withErrors(['email' => [__($status)]]);
    }
}