<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\User;
use PragmaRX\Google2FAQRCode\Google2FA;

class TwoFAController extends Controller
{
    public function setup()
    {
        $user = auth()->user();

        $google2fa = app(Google2FA::class);

        $secret = $user->google2fa_secret;

        $qr = $google2fa->getQRCodeInline(
            config('app.name'),
            $user->email,
            $user->google2fa_secret
        );

        $otpauth = $google2fa->getQRCodeUrl(
            config('app.name'),
            $user->email,
            $secret
        );

        return view('2fa.setup', compact('qr', 'secret', 'otpauth'));
    }

    public function enable(Request $request)
    {
        $request->validate(['otp' => 'required']);

        $user = auth()->user();
        $google2fa = app(Google2FA::class);

        $valid = $google2fa->verifyKey(
            $user->google2fa_secret,
            $request->otp
        );

        if ($valid) {
            $user->update(['google2fa_enabled' => true]);
            return redirect(route('dashboard'))->with('success', '2FA aktif');
        }

        return back()->with('error', 'Kode salah');
    }

    public function verifyForm()
    {
        return view('2fa.verify');
    }

    public function verify(Request $request)
    {
        $request->validate(['otp' => 'required']);

        $user = User::find(session('2fa:user:id'));

        $google2fa = app(Google2FA::class);

        if ($google2fa->verifyKey($user->google2fa_secret, $request->otp)) {
            Auth::login($user);
            session()->forget('2fa:user:id');
            return redirect('/dashboard');
        }

        return back()->with('error', 'OTP salah');
    }
}