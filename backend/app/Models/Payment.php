<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Payment extends Model
{
    protected $guarded = [];

    public function user(): BelongsTo{
        return $this->belongsTo(User::class);
    }

    public function plan(): BelongsTo{
        return $this->belongsTo(Plan::class);
    }

    public function post(): BelongsTo{
        return $this->belongsTo(Post::class);
    }

    public function booking(): BelongsTo{
        return $this->belongsTo(Booking::class);
    }
}
