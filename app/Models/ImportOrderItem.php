<?php

use App\Models;

use Illuminate\Database\Eloquent\Model;

class ImportOrderItem extends Model
{
    protected $connection = 'supply_chain'; // supply chain DB

    protected $table = 'orders_items';
}