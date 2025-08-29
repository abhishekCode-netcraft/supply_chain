<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use App\Models\ImportOrder;
use App\Models\ImportOrderItem;
use App\Models\OrderItem;
use App\Models\Order;
use Carbon\Carbon;
use DB;

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
        OrderItem::truncate(); // first delete child records
        Order::truncate();     // then delete parent records
        
        // $orders = DB::connection('supply_chain')->table('orders')->get();

        DB::connection('supply_chain')->table('orders')
            ->where('order_type', 'products')
            ->whereIn('order_status', ['unshipped', 'under_process'])
            ->orderBy('order_id') // make chunking deterministic
            ->chunk(100, function ($orders) {
                foreach ($orders as $order) {
                    $data = (array) $order;
        
                    // ✅ Fix timestamps → milliseconds
                    $data['created_at'] = $order->created_at;
                    $data['updated_at'] = $order->updated_at;
        
                    // 🚀 Insert into supply_chain.orders table
                    DB::table('orders')->insert($data);
        
                    // // Fetch related order items (again via DB)
                    $items = DB::connection('supply_chain')->table('orders_items')
                        ->where('order_id', $order->order_id)
                        ->get();
        
                    foreach ($items as $item) {
                        $supplyItem = (array) $item;
                        unset($supplyItem['updated_at']); // remove unwanted field
        
                        DB::table('orders_items')->insert($supplyItem);
                    }
                }
            });

    
        $this->info('Orders synced successfully.');
    }
}
