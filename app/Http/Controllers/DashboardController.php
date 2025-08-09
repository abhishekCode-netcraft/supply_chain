<?php

namespace App\Http\Controllers;

use App\Models\Order;
use App\Models\User;
use App\Models\UserSession;
use Carbon\Carbon;
use Illuminate\Support\Facades\Http;
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
public function index()
{
   
    $unshipped = Order::with('items')
        ->where('order_status', 'unshipped')
        ->where('order_type', 'products')
        ->paginate(10, ['*'], 'unshipped_page'); 

    $underProcess = Order::with('items')
        ->where('order_status', 'under_process')
        ->where('order_type', 'products')
        ->paginate(10, ['*'], 'underprocess_page');

    return view('dashboard.index', compact('unshipped', 'underProcess'));
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
