<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class BackupListingImage extends Model
{
    use HasFactory;

    protected $fillable = [
        'listing_id',
        'image_url'
    ];
}
