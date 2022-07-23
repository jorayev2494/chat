<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Device extends Model
{

    /**
     * @var array $fillable
     */
    protected $fillable = [
        'user_id',
        'refresh_token',
        'device_id',
        'device_name',
        'user_agent',
        'os',
        'os_version',
        'app_version',
        'ip_address',
        'location',
        'ws_token',
    ];
}
