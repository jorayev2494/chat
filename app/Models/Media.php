<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\MorphTo;

class Media extends Model
{
    use HasFactory;

    /**
     * @var string $table
     */
    public $table = 'medias';

    /**
     * @var array $fillable
     */
    public $fillable = [
        'width',
        'height',
        'path',
        'mime_type',
        'type',
        'extension',
        'size',
        'user_file_name',
        'name',
        'full_path',
        'url',
    ];

    public $casts = [
        'created_at' => 'datetime:Y-m-d H:i:s',
        'updated_at' => 'datetime:Y-m-d H:i:s',
    ];

    /**
     * @return void
     */
    public function mediaable(): MorphTo
    {
        return $this->morphTo();
    }

}
