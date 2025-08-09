<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class OrderItem extends Model
{
    protected $table = 'orders_items';
    protected $fillable = [
        'product_id',
        'title',
        'thumb',
        'order_id',
    ];

    public function order()
    {
        return $this->belongsTo(Order::class, 'order_id', 'order_id');
    }

   public function getCleanThumbAttribute()
{

    $url = $this->thumb;


    return preg_replace('/\/w80.*$/', '', $url);
}
}
