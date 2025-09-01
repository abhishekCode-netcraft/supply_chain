<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Laravel\Sanctum\HasApiTokens;
use Spatie\Permission\Traits\HasRoles;

class User extends Authenticatable
{
    use HasApiTokens, HasFactory, Notifiable, HasRoles;

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */

    protected $fillable = [
        'name',
        'email',
        'mobile',
        'whatsapp_no',
        'alternate_no',
        'business_name',
        'business_address',
        'business_pincode',
        'business_email',
        'business_phone',
        'personal_upload',   
        'business_upload',
        'status',
         'otp',
           'otp_feature',
        'is_active',
        'password',
        "email_verification_code",
        "email_verified_at",
        "order_date_min",
        "order_date_max",
        "underProcess_order_date_min",
        "underProcess_order_date_max"
    ];


    /**
     * The attributes that should be hidden for serialization.
     *
     * @var array<int, string>
     */
    protected $hidden = [
        'password',
        'remember_token',
    ];

    /**
     * The attributes that should be cast.
     *
     * @var array<string, string>
     */
    protected $casts = [
        'email_verified_at' => 'datetime',
        'password' => 'hashed',
    ];

    /**
     * Get Sessions
     *
     * @return void
     */
    public function sessions()
    {
        return $this->hasMany(UserSession::class);
    }

    public function counts()
    {
        return $this->hasMany(UserListingCount::class);
    }
}
