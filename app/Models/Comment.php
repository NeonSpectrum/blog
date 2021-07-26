<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Comment extends Model
{
    use HasFactory;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'content'
    ];

    public function blog() : BelongsTo
    {
        return $this->belongsTo(Blog::class);
    }

    public function user() : BelongsTo
    {
        return $this->belongsTo(User::class);
    }
}