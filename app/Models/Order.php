<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Order extends Model
{
    protected $table = 'orders';
    protected $fillable = [
        'order_id',
        'order_type',
        'order_status',
        'created_at'
    ];

        protected $casts = [
        'created_at' => 'string',
    ];

    public function items()
    {
        return $this->hasMany(OrderItem::class, 'order_id', 'order_id');
    }

    public function extra_payments()
    {
        return $this->hasOne(OrdersExtraPayment::class, 'order_id', 'order_id');
    }
}
