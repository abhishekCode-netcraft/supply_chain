<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class PurchesPriceWeightCourier extends Model
{
    use HasFactory;
    protected $fillable = [
        'min', 'max', 'weight', 'courier_rate', 'packing_charge', 'our_min_profit', 'max_profit'
    ];
}
