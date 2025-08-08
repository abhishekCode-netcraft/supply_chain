<?php

namespace App\Http\Controllers;

use App\Models\Listing;
use App\Models\User;
use App\Models\UserSession;
use App\Services\GoogleService;
use Carbon\Carbon;
use Illuminate\Support\Facades\Http;
use App\Models\UserListingInfo;
use Illuminate\Support\Facades\Crypt;

class DashboardController extends Controller
{
    /**
     * Create a new controller instance.
     * 
     * @return void
     */
    public function __construct()
    {
        // $this->middleware('role_or_permission:Dashboard', ['only' => ['index']]);
    }

    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\View\View
     */
    public function index()
    {
        $userSessionsCount = UserSession::query()->with('user');

        $selectedUserId = '';
        if ((request()->get('user_id'))) {
            $selectedUserId = Crypt::decryptString(request()->get('user_id'));
            if (request()->user_id) {
                $userSessionsCount->where('user_id', $selectedUserId);
            } else {
                $userSessionsCount->where("user_id", auth()->user()->id);
            }
        }

        if (request()->user_id) {
            $userSessionsCount->where('user_id', $selectedUserId);
        } else {
            $userSessionsCount->where("user_id", auth()->user()->id);
        }

        $userSessionsCount = $userSessionsCount->get();

        $approved = UserListingInfo::where('approved_by', '!=', '');

        $pending = Listing::where('status', 0);

        $rejected = Listing::where('status', 2);

        $users = User::where('status', 1)->get()->map(function ($user) {
            $user->encrypted_id = Crypt::encryptString($user->id);
            return $user;
        });

        $users = User::where('status', 1)->get();

        return view('dashboard.index', compact('userSessionsCount', 'approved', 'rejected', 'pending', 'users', 'selectedUserId'));
    }

    /**
     * Get Statistics
     *
     * @param string $category
     * @return int
     */
    public function getStats()
    {
        $url = $this->getSiteBaseUrl();

        $category = request()->category;

        $agoDate = Carbon::now();

        if (request()->filled('updated_before')) {
            // Get the current date
            $currentDate = Carbon::now();

            if (
                request()->query('updated_before') == 1
                || request()->query('updated_before') == 2
                || request()->query('updated_before') == "3Y"
            ) {
                $updateBefore = request()->query('updated_before');
                if (request()->query('updated_before') == "3Y") $updateBefore = 3;
                $agoDate = $currentDate->subYear($updateBefore);
            } else {
                // Subtract three months from the current date
                $agoDate = $currentDate->subMonths(request()->query('updated_before'));
            }
        }

        $response = Http::get($url . '/feeds/posts/default?alt=json&category=' . $category . "&updated-max=" . $agoDate?->format('Y-m-d') . "T00:00:00");

        return $response->json()['feed']['openSearch$totalResults']['$t'];
    }
}
