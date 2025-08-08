<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class SiteSetting extends Model
{
    use HasFactory;

    protected $fillable = [
        'url',
        'logo',
        'product_background_image',
        'homepage_image',
        'watermark_text',
        'calc_link',
        'button_1',
        'button_2',
        'button_3',
        'button_4',
        'listing_button_1',
        'listing_button_1_link',
        'listing_button_2',
        'listing_button_2_link',
        'upload_file',
        'term_and_condition',
        'policy',
    ];
}
