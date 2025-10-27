<?php

namespace App\Models;

use App\Enums\PostStatusEnum;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Post extends Model
{
    use HasFactory;

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

    protected $dates = [
        'created_at',
        'updated_at',
    ];


}
