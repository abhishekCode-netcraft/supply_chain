<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Models\UserSession;
use Carbon\Carbon;
use Illuminate\Support\Facades\Storage;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Mail;
use App\Mail\RegisterOtpMail;
use App\Mail\WelcomeMail;
use Illuminate\Http\Request;
use Illuminate\Support\Str;

class UserController extends Controller
{

    public function __invoke($file)
    {
        abort_if(auth()->guest(), Response::HTTP_FORBIDDEN);
    }
    /**
     * Initiate the class instance
     *
     * @return void
     */
    function __construct() {}

    public function index(Request $request)
    {
        $q = User::query()->orderBy('id', 'desc');

        // Optional: simple search
        if ($request->filled('search')) {
            $s = $request->search;
            $q->where(function ($w) use ($s) {
                $w->where('name', 'like', "%$s%")
                    ->orWhere('email', 'like', "%$s%")
                    ->orWhere('mobile', 'like', "%$s%");
            });
        }

        $users = $q->paginate(10)->withQueryString();

        return view('user.index', compact('users'));
    }

    public function generateOTP($n)
    {
        $generator = "1357902468";
        $result = "";

        for ($i = 1; $i <= $n; $i++) {
            $result .= substr($generator, rand() % strlen($generator), 1);
        }

        // Returning the result
        return $result;
    }

    public function registerOTP()
    {
        $otp = $this->generateOTP(6);

        session()->flash('otp', $otp);

        Mail::to('abhishek86478@gmail.com')->send(new RegisterOtpMail($otp, request()->name));

        session()->flash('success', __('OTP Send to Admin'));

        return view('auth.enter-otp', ['register' => true]);
    }


    public function register(Request $request)
    {

        $request->validate([

            'name' => 'required|string|max:255',
            'email' => 'required|email|unique:users,email',
            'mobile' => 'required|digits_between:8,15',
            'whatsapp' => 'nullable|digits_between:8,15',
            'password' => 'required|string|min:6|confirmed',
            'alternate_no' => 'nullable|digits_between:8,15',
            'business_name' => 'required|string|max:255',
            'business_address' => 'required|string|max:500',
            'business_email' => 'nullable|email|max:255',
            'business_phone' => 'nullable|digits_between:8,15',

            'personal_upload' => 'nullable',
            'business_upload' => 'nullable',
        ]);

        $personalFilePath = null;
        if ($request->hasFile('personal_upload')) {
            $personalFilePath = $request->file('personal_upload')->store('uploads/personal', 'public');
        }

        $businessFilePath = null;
        if ($request->hasFile('business_upload')) {
            $businessFilePath = $request->file('business_upload')->store('uploads/business', 'public');
        }
        $verificationCode = Str::random(40); // unique code

        session()->put('register_data', [
            'name' => $request->name,
            'email' => $request->email,
            'mobile' => $request->mobile,
            'whatsapp_no' => $request->whatsapp,
            'password' => Hash::make($request->password),
            'alternate_no' => $request->alternate_no,
            'business_name' => $request->business_name,
            'business_address' => $request->business_address,
            'business_email' => $request->business_email,
            'business_phone' => $request->business_phone,
            'personal_upload' => $personalFilePath,
            'business_upload' => $businessFilePath,
            'verification_code' => $verificationCode,
        ]);
        // send verification link

        Mail::to($request->email)->send(new \App\Mail\VerifyEmailCode((object)[
            'name' => $request->name,
            'email_verification_code' => $verificationCode,
        ]));
      return redirect()->route('login')
        ->with('success', 'Registration initiated! Please check your email to verify.');
    }

    public function verifyEmail($code)
    {
        $data = session()->get('register_data');

        if (!$data || $data['verification_code'] !== $code) {
            return redirect()->route('login')->with('error', 'Invalid or expired verification link.');
        }

        // ab yahi user create hoga
        $user = User::create([
            'name' => $data['name'],
            'email' => $data['email'],
            'mobile' => $data['mobile'],
            'whatsapp_no' => $data['whatsapp_no'],
            'password' => $data['password'],
            'alternate_no' => $data['alternate_no'],
            'business_name' => $data['business_name'],
            'business_address' => $data['business_address'],
            'business_email' => $data['business_email'],
            'business_phone' => $data['business_phone'],
            'personal_upload' => $data['personal_upload'],
            'business_upload' => $data['business_upload'],
            'email_verified_at' => now(),
            'is_active' => false,
            'email_verification_code' => null
        ]);

        // ek hi bar use karne ke liye session clear
        session()->forget('register_data');

        return redirect()->route('login')->with('success', 'Your email has been verified! Please wait for admin approval.');
    }

    public function store(Request $request)
    {
        $request->validate([
            'name'             => 'required|string|max:255',
            'email'            => 'required|email|unique:users,email',
            'mobile'           => 'required|digits_between:8,15',
            'whatsapp'         => 'nullable|digits_between:8,15',
            'password'         => 'required|string|min:6|confirmed',
            'alternate_no'     => 'nullable|digits_between:8,15',
            'business_name'    => 'required|string|max:255',
            'business_address' => 'required|string|max:500',
            'business_email'   => 'nullable|email|max:255',
            'business_phone'   => 'nullable|digits_between:8,15',
            'personal_upload'  => 'nullable|file',
            'business_upload'  => 'nullable|file',

        ]);

        $personalFilePath = $request->hasFile('personal_upload')
            ? $request->file('personal_upload')->store('uploads/personal', 'public')
            : null;

        $businessFilePath = $request->hasFile('business_upload')
            ? $request->file('business_upload')->store('uploads/business', 'public')
            : null;

        $verificationCode = Str::random(40);

        $user = User::create([
            'name'                     => $request->name,
            'email'                    => $request->email,
            'mobile'                   => $request->mobile,
            'whatsapp_no'              => $request->whatsapp,
            'password'                 => Hash::make($request->password),
            'alternate_no'             => $request->alternate_no,
            'business_name'            => $request->business_name,
            'business_address'         => $request->business_address,
            'business_email'           => $request->business_email,
            'business_phone'           => $request->business_phone,
            'personal_upload'          => $personalFilePath,
            'business_upload'          => $businessFilePath,
            'email_verification_code'  => $verificationCode,
            'email_verified_at'        => null,
            'is_active' => 1,
        ]);

        // Send email verification button to user:
        Mail::to($user->email)->send(new \App\Mail\VerifyEmailCode($user));

        return redirect()->route('users.index')->with('success', 'User created & verification email sent.');
    }

    public function create()
    {
        return view('user.create');
    }

    public function updateStatus(Request $request, User $user)
    {
        $request->validate([
            'is_active' => 'required|boolean',
        ]);

        $prev = $user->is_active;

        $user->is_active = $request->boolean('is_active');
        $user->save();

        if ($prev != $user->is_active) {

            if ($user->is_active) {
                $this->sendStatusMail($user);
                return back()->with('success', 'Status updated and welcome mail sent to user.');
            } else {
                return back()->with('success', 'Status updated to inactive.');
            }
        }
    }

    protected function sendStatusMail(User $user): void
    {
        if ($user->is_active) {
            Mail::to($user->email)->send(new WelcomeMail($user));
        }
    }

    public function destroy(User $user)
    {

        if ($user->personal_upload) {
            Storage::disk('public')->delete($user->personal_upload);
        }
        if ($user->business_upload) {
            Storage::disk('public')->delete($user->business_upload);
        }

        $user->delete();
        return redirect()->route('users.index')->with('success', 'User deleted successfully.');
    }

    public function edit(User $user)
    {
        return view('user.edit', compact('user'));
    }

    public function update(Request $request, User $user)
    {
        $request->validate([
            'name'             => 'required|string|max:255',
            'email'            => 'required|email|unique:users,email,' . $user->id,
            'mobile'           => 'required|digits_between:8,15',
            'whatsapp'         => 'nullable|digits_between:8,15',
            'password'         => 'nullable|string|min:6|confirmed',
            'alternate_no'     => 'nullable|digits_between:8,15',
            'business_name'    => 'required|string|max:255',
            'business_address' => 'required|string|max:500',
            'business_email'   => 'nullable|email|max:255',
            'business_phone'   => 'nullable|digits_between:8,15',
            'personal_upload'  => 'nullable|file',
            'business_upload'  => 'nullable|file',
            'order_date'       => 'nullable|numeric',

        ]);


        if ($request->hasFile('personal_upload')) {
            if ($user->personal_upload) {
                Storage::disk('public')->delete($user->personal_upload);
            }
            $user->personal_upload = $request->file('personal_upload')->store('uploads/personal', 'public');
        }

        if ($request->hasFile('business_upload')) {
            if ($user->business_upload) {
                Storage::disk('public')->delete($user->business_upload);
            }
            $user->business_upload = $request->file('business_upload')->store('uploads/business', 'public');
        }

        // basic fields
        $user->name             = $request->name;
        $user->email            = $request->email;
        $user->mobile           = $request->mobile;
        $user->whatsapp_no      = $request->whatsapp;
        if ($request->filled('password')) {
            $user->password = Hash::make($request->password);
        }
        $user->alternate_no     = $request->alternate_no;
        $user->business_name    = $request->business_name;
        $user->business_address = $request->business_address;
        $user->business_email   = $request->business_email;
        $user->business_phone   = $request->business_phone;
        $user->order_date = $request->order_date;

        $user->save();
        return redirect()->route('users.index')->with('success', 'User updated successfully.');
    }

    public function verified()
    {
        $users = User::orderBy('id', 'asc')
            ->paginate(request()->users);

        return view('accounts.users.approved', compact('users'));
    }

    public function setSessionId()
    {
        $sessionId = UserSession::where('user_id', auth()->user()->id)
            ->orderBy('id', 'DESC')
            ->first();

        $currentDateTime = Carbon::now();
        $sessionExpireDateTime = $currentDateTime->addMinutes(env('SESSION_LIFETIME'));

        $sessionId->update([
            'expire_at' => $sessionExpireDateTime
        ]);

        session()->put('session_id', $sessionId->session_id);

        return true;
    }

    /**
     * Sessions Delete
     */
    public function deleteSessionId($id)
    {
        UserSession::where('session_id', $id)->delete();

        if (request()->ajax()) {
            return response()->json([
                'status' => true
            ]);
        }

        session()->flash('success', 'Session Deleted Succesfully');

        return redirect()->back();
    }
}
