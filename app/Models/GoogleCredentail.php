<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class GoogleCredentail extends Model
{
    use HasFactory;

    protected $fillable = [
        'client_id',
        'client_secret',
        'redirect_uri',
        'blog_id',
        'token',
        'scope',
        'merchant_id',
    ];
}
