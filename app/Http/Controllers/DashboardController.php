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

        $unshippedCutMin = null;
        if (!empty($user->order_date_min)) {
            $unshippedCutMin = Carbon::now()
                ->subDays($user->order_date_min)
                ->startOfDay()
                ->timestamp * 1000;
        }

        $underProcessCutMin = null;
        if (!empty($user->underProcess_order_date_min)) {
            $underProcessCutMin = Carbon::now()
                ->subDays($user->underProcess_order_date_min)
                ->startOfDay()
                ->timestamp * 1000;
        }

        $unshippedCutMax = null;
        if (!empty($user->order_date_max)) {
            $unshippedCutMax = Carbon::now()
                ->subDays($user->order_date_max)
                ->startOfDay()
                ->timestamp * 1000;
        }

        $underProcessCutMax = null;
        if (!empty($user->underProcess_order_date_max)) {
            $underProcessCutMax = Carbon::now()
                ->subDays($user->underProcess_order_date_max)
                ->startOfDay()
                ->timestamp * 1000;
        }

        $fromDate = request()->get('from_date');
        $toDate   = request()->get('to_date');

        // ✅ Date range filters
        $fromDateMs = $fromDate ? Carbon::parse($fromDate)->startOfDay()->timestamp * 1000 : null;
        $toDateMs   = $toDate ? Carbon::parse($toDate)->endOfDay()->timestamp * 1000 : null;

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

        // -----------------------
        // ✅ Unshipped Orders
        // -----------------------
        $unshippedQuery = \App\Models\Order::with('items')
            ->where('order_status', 'unshipped')
            ->where('order_type', 'products');

        $unshippedQuery->orderBy('created_at', request()->get('sort'));

        if ($fromDateMs) {
            $unshippedQuery->where('created_at', '>=', $fromDateMs);
        }
        
        if ($toDateMs) {
            $unshippedQuery->where('created_at', '<=', $toDateMs);
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

        // -----------------------
        // ✅ Under Process Orders
        // -----------------------
        $underProcessQuery = \App\Models\Order::with('items')
            ->where('order_status', 'under_process')
            ->where('order_type', 'products');

        if ($underProcessCutMin) {
            $underProcessQuery->where('created_at', '<', $underProcessCutMin);
        }

        if ($underProcessCutMax) {
            $underProcessQuery->where('created_at', '>', $underProcessCutMax);
        }

        $underProcessQuery->orderBy('created_at', request()->get('sort'));

        if ($fromDateMs) {
            $underProcessQuery->where('created_at', '>=', $fromDateMs);
        }
        if ($toDateMs) {
            $underProcessQuery->where('created_at', '<=', $toDateMs);
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

        $unshippedCutoff = !empty($user->order_date)
            ? Carbon::now()->subDays($user->order_date)->startOfDay()
            : null;

        $underProcessCutoff = !empty($user->underProcess_order_date)
            ? Carbon::now()->subDays($user->underProcess_order_date)->startOfDay()
            : null;

        if ($tab === 'unshipped') {
            $page = $request->get('unshipped_page', 1);
            $ordersQuery = Order::with('items')
                ->where('order_status', 'unshipped')
                ->where('order_type', 'products');

            if ($unshippedCutoff) {
                $ordersQuery->where('created_at', '<', $unshippedCutoff);
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

            if ($underProcessCutoff) {
                $ordersQuery->where('created_at', '<', $underProcessCutoff);
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

        if ($exportType === 'without_image') {

            $pagedData = $grouped->values();
        } else {

            $pagedData = $grouped->slice(($page - 1) * $perPage, $perPage)->values();
        }


        $pdf = PDF::loadView($view, [
                'items' => $pagedData,
                'tab'   => $tab,
                'generatedAt' => Carbon::now()->format('d-m-Y H:i:s'),
                'heading' => 'Product List',
                'user' => auth()->user()
            ])
            ->setPaper('a4', 'portrait')
            ->setOptions(['isRemoteEnabled' => true]);

        return $pdf->download("{$tab}_items_page_{$page}.pdf");
    }
}
