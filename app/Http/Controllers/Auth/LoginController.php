<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Mail\OtpMail;
use App\Mail\StatusNotificationMail;
use App\Models\User;
use App\Models\UserSession;
use App\Providers\RouteServiceProvider;
use Carbon\Carbon;
use Illuminate\Foundation\Auth\AuthenticatesUsers;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Mail;

class LoginController extends Controller
{
    /*
    |--------------------------------------------------------------------------
    | Login Controller
    |--------------------------------------------------------------------------
    |
    | This controller handles authenticating users for the application and
    | redirecting them to your home screen. The controller uses a trait
    | to conveniently provide its functionality to your applications.
    |
    */

    use AuthenticatesUsers;

    /**
     * Where to redirect users after login.
     *
     * @var string
     */
    protected $redirectTo = RouteServiceProvider::HOME;

    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('guest')->except('logout');
    }

    /**
     * Log the user out of the application.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\RedirectResponse|\Illuminate\Http\JsonResponse
     */
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

        if ($response = $this->loggedOut($request)) {
            return $response;
        }

        return $request->wantsJson()
            ? new JsonResponse([], 204)
            : redirect('/');
    }

    /**
     * Logout the user
     */
    protected function loggedOut(Request $request)
    {
        return redirect()->route('login');
    }

    /**
     * Validate credentials
     */
    protected function credentials(Request $request)
    {
        return [
            'email'    => request()->email,
            'password' => request()->password,
            'status'   => 1
        ];
    }

    /**
     * Handle a login request to the application.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\RedirectResponse|\Illuminate\Http\Response|\Illuminate\Http\JsonResponse
     *
     * @throws \Illuminate\Validation\ValidationException
     */
    public function login(Request $request)
    {
        // Validate login input
        $request->validate([
            'email'    => 'required|email',
            'password' => 'required|string',
        ]);

        // Find user
        $user = User::where('email', $request->email)->first();
        if (!$user) {
            session()->flash('error', 'Oops! Email or Password Mismatch');
            return redirect()->route('login');
        }

        // Email verification check
        if (is_null($user->email_verified_at)) {
            session()->flash('error', 'Please verify your email before logging in.');
            return redirect()->route('login');
        }

        // Account status checks
        if ($user->is_active == 0) {
            session()->flash('error', 'Account Inactive');
            return redirect()->route('login');
        }


        // Old session cleanup
        $oldSessions = $user->sessions->where('expire_at', '<', now());
        foreach ($oldSessions as $session) {
            $session->delete();
        }

        // Attempt login
        if (
            method_exists($this, 'hasTooManyLoginAttempts') &&
            $this->hasTooManyLoginAttempts($request)
        ) {
            $this->fireLockoutEvent($request);
            return $this->sendLockoutResponse($request);
        }

        if ($this->attemptLogin($request)) {
            if ($request->hasSession()) {
                $request->session()->put('auth.password_confirmed_at', time());
            }


            $currentDateTime = \Carbon\Carbon::now();
            $sessionExpireDateTime = $currentDateTime->addMinutes(env('SESSION_LIFETIME', 120));
            $sessionId = session()->getId();
            session()->put('sessionId', $sessionId);

            if ($user->allow_sessions) {
                if ($userSession = \App\Models\UserSession::where('user_id', $user->id)->first()) {
                    $userSession->update([
                        'user_id' => $user->id,
                        'session_id' => $sessionId,
                        'expire_at' => $sessionExpireDateTime
                    ]);
                } else {
                    \App\Models\UserSession::create([
                        'user_id' => $user->id,
                        'session_id' => $sessionId,
                        'expire_at' => $sessionExpireDateTime
                    ]);
                }
            } else {
                \App\Models\UserSession::create([
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
}
