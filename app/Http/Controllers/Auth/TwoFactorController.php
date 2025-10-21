<?php
namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\Mail;
use App\Mail\TwoFactorCodeMail;
use Illuminate\Support\Facades\Log;

class TwoFactorController extends Controller
{
    public function index()
    {
        return view('auth.2fa');
    }

    public function verify(Request $request)
    {
        $request->validate(['code' => 'required|digits:6']);

        $userId = session('2fa:user:id');
        if (!$userId) {
            return redirect()->route('login')->withErrors(['email' => 'Session expired. Please login again.']);
        }

        $cached = Cache::get('2fa_code_' . $userId);
        if (!$cached || (string)$cached !== (string)$request->code) {
            return back()->withErrors(['code' => 'Invalid or expired verification code.']);
        }

        // code matches — log user in and cleanup
        $user = \App\Models\User::find($userId);
        if (!$user) return redirect()->route('login')->withErrors(['email' => 'User not found.']);

        // Clear the cached code
        Cache::forget('2fa_code_' . $userId);

        Auth::login($user);
        session()->forget('2fa:user:id');

        $intended = session()->pull('2fa:intended', route('admin.dashboard'));
        return redirect()->intended($intended);
    }

    public function resend(Request $request)
    {
        $userId = session('2fa:user:id');
        if (!$userId) {
            return redirect()->route('login')->withErrors(['email' => 'Session expired. Please login again.']);
        }

        $user = \App\Models\User::find($userId);
        if (!$user) return redirect()->route('login')->withErrors(['email' => 'User not found.']);

    $code = random_int(100000, 999999);
    // Set 2FA code TTL to 2 minutes to match UI/email
    Cache::put('2fa_code_' . $userId, $code, now()->addMinutes(2));

        try {
            Mail::to($user->email)->send(new TwoFactorCodeMail($code));
        } catch (\Throwable $e) {
            Log::error('2FA resend mail failed: ' . $e->getMessage());
        }

        return back()->with('status', 'A new verification code was sent to your email.');
    }
}
