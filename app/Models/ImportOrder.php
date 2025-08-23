<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class ImportOrder extends Model
{
    protected $connection = 'supply_chain'; // supply chain DB

    protected $table = 'orders';
}