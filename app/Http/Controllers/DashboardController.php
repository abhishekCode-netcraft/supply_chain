<?php

namespace App\Http\Controllers;

use App\Models\Order;
use Carbon\Carbon;
use Illuminate\Support\Facades\Http;
use Illuminate\Pagination\LengthAwarePaginator;
use Illuminate\Support\Collection;
use Barryvdh\DomPDF\Facade\Pdf;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class DashboardController extends Controller
{
    /**
     * Create a new controller instance.
     * 
     * @return void
     */
    public function __construct() {}




    public function index()
    {
        $user = Auth::user();
        $cutoffTimestamp = null;

        if (!empty($user->order_date)) {
            $cutoffTimestamp = Carbon::now()
                ->subDays($user->order_date)
                ->startOfDay()
                ->timestamp * 1000;
        }
        $todayTimestamp = Carbon::now()->timestamp * 1000;


        $groupAndPaginate = function ($orders, $perPage = 15, $pageName = 'page') {
            $grouped = $orders->flatMap->items
                ->groupBy('product_id')
                ->map(function ($items) {
                    $firstItem = $items->first();
                    $firstItem->order_count = $items->count();
                    return $firstItem;
                })
                ->values();

            $page = request()->get($pageName, 1);
            $pagedData = $grouped->slice(($page - 1) * $perPage, $perPage)->values();

            return new \Illuminate\Pagination\LengthAwarePaginator(
                $pagedData,
                $grouped->count(),
                $perPage,
                $page,
                ['path' => request()->url(), 'pageName' => $pageName]
            );
        };

        $searchUnshipped = request()->get('search_unshipped');
        $searchUnderprocess = request()->get('search_underprocess');
        $activeTab = request()->get('tab', 'unshipped');

        $unshippedQuery = \App\Models\Order::with('items')
            ->where('order_status', 'unshipped')
            ->where('order_type', 'products');

        if ($cutoffTimestamp) {
            $unshippedQuery->where('created_at', '<', $cutoffTimestamp);
        }
        $unshippedOrders = $unshippedQuery->get();

        if ($searchUnshipped) {
            $unshippedOrders = $unshippedOrders->filter(function ($order) use ($searchUnshipped) {
                return $order->items->contains(function ($item) use ($searchUnshipped) {
                    return stripos($item->title, $searchUnshipped) !== false;
                });
            });
        }

        $unshipped = $groupAndPaginate($unshippedOrders, 15, 'unshipped_page');


        $underProcessQuery = \App\Models\Order::with('items')
            ->where('order_status', 'under_process')
            ->where('order_type', 'products');

        if ($cutoffTimestamp) {
            $underProcessQuery->where('created_at', '<', $cutoffTimestamp);
        }

        $underProcessOrders = $underProcessQuery->get();

        if ($searchUnderprocess) {
            $underProcessOrders = $underProcessOrders->filter(function ($order) use ($searchUnderprocess) {
                return $order->items->contains(function ($item) use ($searchUnderprocess) {
                    return stripos($item->title, $searchUnderprocess) !== false;
                });
            });
        }

        $underProcess = $groupAndPaginate($underProcessOrders, 15, 'underprocess_page');

        return view('dashboard.index', compact(
            'unshipped',
            'underProcess',
            'searchUnshipped',
            'searchUnderprocess',
            'activeTab'
        ));
    }


    public function exportPdf(Request $request)
    {
        $tab = $request->get('tab', 'unshipped');
        $perPage = 15;

        if ($tab === 'unshipped') {
            $page = $request->get('unshipped_page', 1);
            $orders = Order::with('items')
                ->where('order_status', 'unshipped')
                ->where('order_type', 'products')
                ->get();

            if ($request->filled('search_unshipped')) {
                $search = $request->get('search_unshipped');
                $orders = $orders->filter(function ($order) use ($search) {
                    return $order->items->contains(function ($item) use ($search) {
                        return stripos($item->title, $search) !== false;
                    });
                });
            }
        } else {
            $page = $request->get('underprocess_page', 1);
            $orders = Order::with('items')
                ->where('order_status', 'under_process')
                ->where('order_type', 'products')
                ->get();

            if ($request->filled('search_underprocess')) {
                $search = $request->get('search_underprocess');
                $orders = $orders->filter(function ($order) use ($search) {
                    return $order->items->contains(function ($item) use ($search) {
                        return stripos($item->title, $search) !== false;
                    });
                });
            }
        }

        // Group and slice data
        $grouped = $orders->flatMap->items
            ->groupBy('product_id')
            ->map(function ($items) {
                $firstItem = $items->first();
                $firstItem->order_count = $items->count();
                return $firstItem;
            })
            ->values();

        $pagedData = $grouped->slice(($page - 1) * $perPage, $perPage)->values();

        $pdf = PDF::loadView('dashboard.export-pdf', [
            'items' => $pagedData,
            'tab'   => $tab
        ])->setPaper('a4', 'portrait')
            ->setOptions(['isRemoteEnabled' => true]);

        return $pdf->download("{$tab}_items_page_{$page}.pdf");
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
