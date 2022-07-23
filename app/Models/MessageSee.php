<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class MessageSee extends Model
{
    use HasFactory;

    /**
     * @var array $fillable
     */
    public $fillable = [
        'chat_id',
        'user_id',
        'message_id',
    ];

    /**
     * @var array $casts
     */
    public $casts = [
        'created_at' => 'datetime:Y-m-d H:i:s',
        'updated_at' => 'datetime:Y-m-d H:i:s',
    ];
}
