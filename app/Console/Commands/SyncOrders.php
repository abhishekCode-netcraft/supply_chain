<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use App\Models\ImportOrder;
use App\Models\ImportOrderItem;
use App\Models\OrderItem;
use App\Models\Order;
use App\Models\OrdersExtraPayment;
use App\Models\User;
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
        OrdersExtraPayment::truncate();
        OrderItem::truncate(); // first delete child records
        Order::truncate();     // then delete parent records
            
        DB::connection('supply_chain')
            ->table('orders_extra_payments')
            ->orderBy('order_id')
            ->chunk(100, function ($orders) {
                foreach ($orders as $order) {
                    $data = (array) $order;
                    DB::table('orders_extra_payments')->insert($data);
                }
            });

        DB::connection('supply_chain')->table('orders')
            ->where('order_type', 'products')
            ->whereIn('order_status', ['unshipped', 'under_process'])
            ->orderBy('order_id')
            ->chunk(100, function ($orders) {
                foreach ($orders as $order) {
                    $data = (array) $order;
        
                    // âœ… Fix timestamps â†’ milliseconds
                    $data['created_at'] = $order->created_at;
                    $data['updated_at'] = $order->updated_at;
        
                    // ðŸš€ Insert into supply_chain.orders table
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
            
        User::find(1)->update([
            'order_last_updated' => now()
        ]);

    
        $this->info('Orders synced successfully.');
    }
}
