<?php

namespace App\Models;

use App\PostStatusEnum;
use Illuminate\Database\Eloquent\Model;

class Post extends Model
{
    protected $fillable = [
        'title',
        'date',
        'user_id',
        'description',
        'attachment',
        'status',
    ];

    protected $casts = [
        'status' => PostStatusEnum::class,
    ];
}
