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

        $unshippedCutoff = null;
        if (!empty($user->order_date)) {
            $unshippedCutoff = Carbon::now()
                ->subDays($user->order_date)
                ->startOfDay()
                ->timestamp * 1000;
        }

        $underProcessCutoff = null;
        if (!empty($user->underProcess_order_date)) {
            $underProcessCutoff = Carbon::now()
                ->subDays($user->underProcess_order_date)
                ->startOfDay()
                ->timestamp * 1000;
        }

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

        if ($unshippedCutoff) {
            $unshippedQuery->where('created_at', '<', $unshippedCutoff);
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

        if ($underProcessCutoff) {
            $underProcessQuery->where('created_at', '<', $underProcessCutoff);
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
