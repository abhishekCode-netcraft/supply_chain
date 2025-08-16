<?php

namespace App\Http\Controllers;

use App\Http\Requests\UserRequest;
use App\Mail\UserMail;
use App\Models\User;
use App\Models\UserSession;
use Carbon\Carbon;
use Illuminate\Support\Facades\Storage;

use Illuminate\Http\Response;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Spatie\Permission\Models\Role;
use Illuminate\Support\Facades\Mail;
use App\Models\UserListingCount;
use App\Mail\RegisterOtpMail;
use App\Mail\WelcomeMail;
use Illuminate\Http\Request;
use Illuminate\Support\Str;

use App\Mail\StatusNotificationMail;

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

    /**
     * Display a listing of the resource.
     */
    // public function index()
    // {
    //     $users = User::whereDoesntHave('roles', function ($query) {
    //         $query->where('name', 'Developer');
    //     })
    //         ->orderBy('id', 'asc')
    //         ->paginate(request()->get('users', 10));


    //     $allUser = User::whereDoesntHave('roles', function ($query) {
    //         $query->where('name', 'Developer');
    //     })->count();

    //     $active = User::whereDoesntHave('roles', function ($query) {
    //         $query->where('name', 'Developer');
    //     })
    //         ->where('status', 1)->count();

    //     $inactive = User::whereDoesntHave('roles', function ($query) {
    //         $query->where('name', 'Developer');
    //     })
    //         ->where('status', 0)->count();

    //     return view('accounts.users.index', compact('users', 'allUser', 'active', 'inactive'));
    // }

    /**
     * Show the form for creating a new resource.
     */
    // public function create()
    // {
    //     $roles = Role::get();

    //     return view('accounts.users.create', compact('roles'));
    // }
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

        return view('ManageUsers.index', compact('users'));
    }

    /**
     * Store a newly created resource in storage.
     */
    // public function store(UserRequest $request)
    // {
    //     User::create($request->validated())?->syncRoles(request()->input('roles'));

    //     Mail::to($request->email)->send(new UserMail($request->all()));

    //     session()->flash('success', __('User created successfully.'));

    //     return redirect()->route('users.index');
    // }

    /**
     * Generate Random Digits
     *
     * @return int
     */
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

    // public function register()
    // {
    //     if (session('otp') == request()->otp) {
    //         User::create(request()->all())?->syncRoles(request()->input('roles'));

    //         session()->flash('success', __('You have Registered Successfully...'));

    //         return redirect()->route('login');
    //     } else {
    //         session()->flash('success', __('Invalid OTP'));

    //         return view('auth.enter-otp', ['register' => true]);
    //     }
    // }


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

        $user = User::create([
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
            'is_active' => false,
            'email_verification_code' => $verificationCode
        ]);

        // send verification link

        Mail::to($user->email)->send(new \App\Mail\VerifyEmailCode($user));

        return redirect()->route('login')
            ->with('success', 'Registration successful! Please check your email to verify your account.');
    }


    public function verifyEmail($code)
    {

        $user = User::where('email_verification_code', $code)->first();

        if (!$user) {
            return redirect()->route('login')->with('error', 'Invalid or expired verification link.');
        }

        $user->update([
            'email_verified_at' => now(),
            'email_verification_code' => null
        ]);

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
        return view('ManageUsers.create');
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
        $this->sendStatusMail($user);
    }

    return back()->with('success', 'Status updated & mail sent (if changed).');
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
        return view('ManageUsers.edit', compact('user'));
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



    /**
     * Show the form for editing the specified resource.
     */
    // public function edit($id): \Illuminate\View\View
    // {
    //     $user = User::find($id);

    //     $roles = Role::get();

    //     return view('accounts.users.edit', compact('user', 'roles'));
    // }

    /**
     * Update the specified resource in storage.
     */
    // public function update(string $id)
    // {
    //     $user = User::find($id);

    //     $user->update(request()->all());

    //     if (request()->input('roles')) {
    //         $user->syncRoles(request()->input('roles'));
    //     }

    //     session()->flash('success', __('User updated successfully.'));

    //     return redirect()->route('users.index');
    // }

    /**
     * Remove the specified resource from storage.
     */
    // public function destroy(string $id)
    // {
    //     $user = User::find($id);

    //     $user?->delete();

    //     session()->flash('success', __('User delete successfully.'));

    //     return redirect()->route('users.index');
    // }

    /**
     * Get verified Users
     *
     * @return void
     */
    public function verified()
    {
        $users = User::orderBy('id', 'asc')
            ->paginate(request()->users);

        return view('accounts.users.approved', compact('users'));
    }

    /**
     * Update the Password
     *
     * @return void
     */
    // public function updatePassword()
    // {
    //     try {
    //         if (!request()->current) {
    //             return view('accounts.users.change-password');
    //         }

    //         $this->validate(request(), [
    //             'current' => 'required',
    //             'new'     => 'required',
    //         ]);

    //         $hashedPassword = Hash::make(request()->new);

    //         $user = Auth::user();

    //         // Check if the entered password matches the hashed password
    //         if (Hash::check(request()->current, $user->password)) {
    //             $user->update([
    //                 'password' => $hashedPassword,
    //                 'plain_password' => request()->new
    //             ]);

    //             session()->flash('success', __('Password updated successfully'));

    //             return redirect()->route('dashboard');
    //         }
    //         session()->flash('success', __('Please check your current password'));

    //         return redirect()->back();
    //     } catch (\Exception $e) {
    //         session()->flash('success', __('An error occurred on the server. Please try again later'));

    //         return redirect()->back();
    //     }
    // }

    /**
     * Edit Status
     *
     * @return void
     */
    // public function editStatus($id)
    // {
    //     $roles = Role::get();

    //     $user = User::find($id);

    //     return view('accounts.users.update', compact('roles', 'user'));
    // }

    /**
     * Update Status
     *
     * @return void
     */
    // public function updateStatus($id)
    // {
    //     $user = User::find($id);

    //     $status = $user->status;

    //     $user->update(request()->all());

    //     $user->syncRoles(request()->input('roles'));

    //     if (!$status) {
    //         Mail::to($user->email)->send(new WelcomeMail($user));

    //         Mail::to('abhishek86478@gmail.com')->send(new WelcomeMail($user));
    //     }

    //     if ($user->status == 2) {
    //         $subject = "Urgent: Your Account Has Been Suspended Due to Unusual Activities";
    //         $body = "We regret to inform you that your account has been Suspended due to unusual activities detected on our platform. This decision has been made to ensure the safety and integrity of our users and services.";
    //         Mail::to($user->email)->send(new StatusNotificationMail('SUSPEND', $subject, $body));
    //         Mail::to('abhishek86478@gmail.com')->send(new StatusNotificationMail('SUSPEND', $subject, $body));
    //     } else if ($user->status == 3) {
    //         $subject = "Important Notice: Your Account Has Been Permanently Blocked";
    //         $body = "We regret to inform you that your account has been permanently blocked due to unusual activities detected on our platform. This decision has been made to ensure the safety and integrity of our users and services. ";
    //         Mail::to($user->email)->send(new StatusNotificationMail('BLOCKED', $subject, $body));
    //         Mail::to('abhishek86478@gmail.com')->send(new StatusNotificationMail('BLOCKED', $subject, $body));
    //     }

    //     session()->flash('success', __('User updated successfully.'));

    //     return redirect()->route('verified.users');
    // }

    /**
     * Set Session
     *
     * @return void
     */
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

    public function userCounts()
    {
        // Initialize query for 'Created' status and group by user
        $countCreated = UserListingCount::with('user')
            ->selectRaw('user_id, sum(create_count) as total_created, sum(approved_count) as total_approved, sum(reject_count) as total_rejected, sum(delete_count) as total_deleted')
            ->where('status', 'Created')
            ->groupBy('user_id');

        if (request()->has('start_date') && request()->has('end_date')) {
            $startDate = Carbon::parse(request()->start_date);
            $endDate = Carbon::parse(request()->end_date);

            $countCreated->whereBetween('created_at', [$startDate->startOfDay(), $endDate->endOfDay()]);
        }

        if (request()->user_id) {
            $countCreated->where('user_id', request()->user_id);
        }

        if (!auth()->user()->hasRole('Super Admin') && !auth()->user()->hasRole('Super Management')) {
            $countCreated->where('user_id', auth()->user()->id);
        }

        $countCreated = $countCreated->get();

        // Initialize query for 'Edited' status and group by user
        $countEdited = UserListingCount::with('user')
            ->selectRaw('user_id, sum(create_count) as total_created, sum(approved_count) as total_approved, sum(reject_count) as total_rejected, sum(delete_count) as total_deleted')
            ->where('status', 'Edited')
            ->groupBy('user_id');

        if (request()->has('start_date') && request()->has('end_date')) {
            $startDate = Carbon::parse(request()->start_date);
            $endDate = Carbon::parse(request()->end_date);

            $countEdited->whereBetween('created_at', [$startDate->startOfDay(), $endDate->endOfDay()]);
        }

        if (request()->user_id) {
            $countEdited->where('user_id', request()->user_id);
        }

        if (!auth()->user()->hasRole('Super Admin') && !auth()->user()->hasRole('Super Management')) {
            $countEdited->where('user_id', auth()->user()->id);
        }

        $countEdited = $countEdited->get();

        // Get all users
        $users = User::all();

        // Pass data to the view
        return view('counts', compact('countCreated', 'countEdited', 'users'));
    }
}
