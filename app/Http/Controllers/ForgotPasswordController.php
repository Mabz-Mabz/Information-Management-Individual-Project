<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Password;
use Illuminate\Support\Facades\Log;

class ForgotPasswordController extends Controller
{
    public function showForm()
    {
        Log::debug("============= ForgotPasswordController: Show Form ================");
        return view('auth.forgot-password');
    }

    public function sendResetLink(Request $request)
    {
        Log::debug("============= ForgotPasswordController: Send Reset Link ================");

        $request->validate([
            'email' => ['required', 'email'],
        ]);

        $status = Password::sendResetLink(
            $request->only('email')
        );

        if ($status === Password::RESET_LINK_SENT) {
            Log::info("Password reset link sent to: " . $request->email);
            return back()->with('status', __($status));
        }

        Log::warning("Password reset failed for: " . $request->email);
        return back()->withErrors(['email' => __($status)]);
    }
}
