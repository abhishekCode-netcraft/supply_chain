<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Mail\OtpMail;
use App\Models\User;
use App\Models\UserSession;
use App\Providers\RouteServiceProvider;
use Carbon\Carbon;
use Illuminate\Foundation\Auth\AuthenticatesUsers;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Hash;
class LoginController extends Controller
{
    use AuthenticatesUsers;

    protected $redirectTo = RouteServiceProvider::HOME;

    public function __construct()
    {
        $this->middleware('guest')->except('logout');
    }

    public function logout(Request $request)
    {
        if (($user = auth()->user()->sessions->where('expire_at', '<', now())->first())
            || (auth()->user()->allow_sessions
                && $user = auth()->user()->sessions->first())
            || (!auth()->user()->allow_sessions
                && $user = auth()->user()->sessions->where('session_id', session()->get('session_id'))->first())
        ) {
            $user->delete();
        }

        $this->guard()->logout();
        $request->session()->invalidate();
        $request->session()->regenerateToken();

        return redirect()->route('login');
    }

    protected function credentials(Request $request)
    {
        return [
            'email' => $request->email,
            'password' => $request->password,
            'status' => 1
        ];
    }

    public function login(Request $request)
    {
        $request->validate([
            'email' => 'required|email',
            'password' => 'required|string',
        ]);

        $user = User::where('email', $request->email)->first();
        if (!$user) {
            session()->flash('error', 'Oops! Email or Password Mismatch');
            return redirect()->route('login');
        }

        if (is_null($user->email_verified_at)) {
            session()->flash('error', 'Please verify your email before logging in.');
            return redirect()->route('login');
        }

        if ($user->is_active == 0) {
            session()->flash('error', 'Account Inactive');
            return redirect()->route('login');
        }

        // OTP feature check
        if ($user->otp_feature && !$request->otp_feature) {
            return $this->authenticateOTP($request);
        }

        $oldSessions = $user->sessions->where('expire_at', '<', now());
        foreach ($oldSessions as $session) {
            $session->delete();
        }

        if (
            method_exists($this, 'hasTooManyLoginAttempts') &&
            $this->hasTooManyLoginAttempts($request)
        ) {
            $this->fireLockoutEvent($request);
            return $this->sendLockoutResponse($request);
        }

        if ($request->otp) {
            $verifyOtp = User::where('email', $request->email)
                ->where('otp', $request->otp)
                ->first();

            if (!$verifyOtp) {
                session()->flash('success', 'Invalid OTP');
                return view('auth.enter-otp');
            }
        }

        if ($this->attemptLogin($request)) {
            if ($request->hasSession()) {
                $request->session()->put('auth.password_confirmed_at', time());
            }

            $currentDateTime = Carbon::now();
            $sessionExpireDateTime = $currentDateTime->addMinutes(env('SESSION_LIFETIME', 120));
            $sessionId = session()->getId();
            session()->put('sessionId', $sessionId);

            if ($user->allow_sessions) {
                if ($userSession = UserSession::where('user_id', $user->id)->first()) {
                    $userSession->update([
                        'user_id' => $user->id,
                        'session_id' => $sessionId,
                        'expire_at' => $sessionExpireDateTime
                    ]);
                } else {
                    UserSession::create([
                        'user_id' => $user->id,
                        'session_id' => $sessionId,
                        'expire_at' => $sessionExpireDateTime
                    ]);
                }
            } else {
                UserSession::create([
                    'user_id' => $user->id,
                    'session_id' => $sessionId,
                    'expire_at' => $sessionExpireDateTime
                ]);
            }

            return $this->sendLoginResponse($request);
        }

        $this->incrementLoginAttempts($request);
        return $this->sendFailedLoginResponse($request);
    }

    // Generate random OTP
    public function generateOTP($n = 6)
    {
        $digits = "1357902468";
        $otp = "";
        for ($i = 0; $i < $n; $i++) {
            $otp .= substr($digits, rand() % strlen($digits), 1);
        }
        return $otp;
    }

    // OTP authentication
    public function authenticateOTP(Request $request)
    {
        $user = User::where('email', $request->email)->first();

        if (!$user || !Hash::check($request->password, $user->password)) {
            session()->flash('error', 'Oops! Email or Password Mismatch');
            return redirect()->route('login');
        }

        $otp = $this->generateOTP(6);
        $user->update(['otp' => $otp]);

        Mail::to($user->email)->send(new OtpMail($otp, null, $user->name));
        
        session()->flash('success', 'Please check your email for the OTP.');

        return view('auth.enter-otp', ['email' => $user->email]);
    }
}
