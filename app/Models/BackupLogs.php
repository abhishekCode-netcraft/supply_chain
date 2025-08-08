<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class BackupLogs extends Model
{
    use HasFactory;

    protected $fillable = [
        'batch_id',
        'started',
        'completed',
        'export_file',
        'merchant_file',
        'facebook_file',
        'sql_file',
        'email_to',
        'error'
    ];
}
