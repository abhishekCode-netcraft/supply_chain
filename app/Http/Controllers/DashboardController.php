<?php

namespace App\Http\Controllers;

use App\Models\Order;
use Carbon\Carbon;
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


        $groupAndPaginate = function ($orders, $perPage = 50, $pageName = 'page') {
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

        $unshipped = $groupAndPaginate($unshippedOrders, 50, 'unshipped_page');


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

        $underProcess = $groupAndPaginate($underProcessOrders, 50, 'underprocess_page');

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
        $exportType = $request->get('export_type', 'with_image'); 
        $perPage = 50;

        $user = Auth::user();
        $cutoffTimestamp = null;

        if (!empty($user->order_date)) {
            $cutoffTimestamp = Carbon::now()
                ->subDays($user->order_date)
                ->startOfDay();
        }

        if ($tab === 'unshipped') {
            $page = $request->get('unshipped_page', 1);
            $ordersQuery = Order::with('items')
                ->where('order_status', 'unshipped')
                ->where('order_type', 'products');

            if ($cutoffTimestamp) {
                $ordersQuery->where('created_at', '<', $cutoffTimestamp);
            }

            $orders = $ordersQuery->get();

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
            $ordersQuery = Order::with('items')
                ->where('order_status', 'under_process')
                ->where('order_type', 'products');

            if ($cutoffTimestamp) {
                $ordersQuery->where('created_at', '<', $cutoffTimestamp);
            }

            $orders = $ordersQuery->get();

            if ($request->filled('search_underprocess')) {
                $search = $request->get('search_underprocess');
                $orders = $orders->filter(function ($order) use ($search) {
                    return $order->items->contains(function ($item) use ($search) {
                        return stripos($item->title, $search) !== false;
                    });
                });
            }
        }

  
        $grouped = $orders->flatMap->items
            ->groupBy('product_id')
            ->map(function ($items) {
                $firstItem = $items->first();
                $firstItem->order_count = $items->count();
                return $firstItem;
            })
            ->values();

        $pagedData = $grouped->slice(($page - 1) * $perPage, $perPage)->values();

        $view = $exportType === 'without_image'
            ? 'dashboard.export-pdf-table' 
            : 'dashboard.export-pdf';    

        $pdf = PDF::loadView($view, [
            'items' => $pagedData,
            'tab'   => $tab
        ])->setPaper('a4', 'portrait')
            ->setOptions(['isRemoteEnabled' => true]);

        return $pdf->download("{$tab}_items_page_{$page}.pdf");
    }
}
