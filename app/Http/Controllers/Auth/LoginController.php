<?php
// app/Http/Controllers/Auth/LoginController.php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class LoginController extends Controller
{
    /**
     * Show the login form.
     */
    public function create()
    {
        return view('auth.login');
    }

    /**
     * Handle an authentication attempt.
     */
    public function store(Request $request)
    {
        $credentials = $request->validate([
            'email' => ['required', 'email'],
            'password' => ['required'],
        ]);

        if (Auth::attempt($credentials)) {
            $user = Auth::user();

            // generate 2FA code and send via email, then require verification
            $code = random_int(100000, 999999);
            \Illuminate\Support\Facades\Cache::put('2fa_code_' . $user->id, $code, now()->addMinutes(10));

            // Send email with the code
            try {
                \Illuminate\Support\Facades\Mail::to($user->email)->send(new \App\Mail\TwoFactorCodeMail($code));
            } catch (\Exception $e) {
                // If mail fails, still continue but log the exception
                \Log::error('Failed to send 2FA email: ' . $e->getMessage());
            }

            // Logout the user for now and store pending 2FA user id in session
            $intended = session()->pull('url.intended', route('admin.dashboard'));
            Auth::logout();
            session(['2fa:user:id' => $user->id, '2fa:intended' => $intended]);

            return redirect()->route('2fa.index')->with('status', 'A verification code was sent to your email.');
        }

        return back()->withErrors([
            'email' => 'The provided credentials do not match our records.',
        ])->onlyInput('email');
    }

    /**
     * Log the user out of the application.
     */
    public function destroy(Request $request)
    {
        Auth::logout();
        $request->session()->invalidate();
        $request->session()->regenerateToken();
        return redirect('/');
    }
}
