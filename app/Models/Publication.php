<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Publication extends Model
{
    use HasFactory;
    protected $fillable = [
        'publication_name',
        'discount_information',
        'location'
    ];
    
    protected $casts = [
        'discount_information' => 'string',
    ];
}
