<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\MorphTo;
use Illuminate\Database\Eloquent\Relations\BelongsTo;


class Comment extends Model
{
    use HasFactory;
    protected $fillable = [
        'body',
        'commentable_type',
        'commentable_id',
        'user_id'
    ];

    // public function user(): BelongsTo
    // {
    //     return $this->belongsTo(User::class);
    // }

    public function commentable(): MorphTo
    {
        return $this->morphTo();
    }
}