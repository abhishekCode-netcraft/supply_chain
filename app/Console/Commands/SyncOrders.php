<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use App\Models\ImportOrder;
use App\Models\ImportOrderItem;
use App\Models\OrderItem;
use App\Models\Order;

class SyncOrders extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'app:sync-orders';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Sync orders from the main orders table to the supply chain orders table';

    /**
     * Execute the console command.
     */
    public function handle()
    {
        // Example: Get last 1 hour orders
        $orders = ImportOrder::where('created_at', '>=', now()->subHour())->get();

        foreach ($orders as $order) {
            // Insert into supply_chain orders table
            $supplyOrder = Order::create($order->toArray());

            // Fetch related order items
            $items = ImportOrderItem::where('order_id', $order->id)->get();

            foreach ($items as $item) {
                $supplyItem = $item->toArray();
                $supplyItem['order_id'] = $supplyOrder->id; // match new order_id
                OrderItem::create($supplyItem);
            }
        }

        $this->info('Orders synced successfully.');
    }

}
