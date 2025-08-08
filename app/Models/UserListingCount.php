<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class UserListingCount extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_id',
        'approved_count',
        'reject_count',
        'status',
        'delete_count',
        'create_count'
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }
}
