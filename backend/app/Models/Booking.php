<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Booking extends Model
{
    protected $guarded = [];

    public function post(): BelongsTo{
        return $this->belongsTo(Post::class);
    }

    public function user(): BelongsTo{
        return $this->belongsTo(User::class);
    }

    public function payment(): HasMany{
        return $this->hasMany(Payment::class);
    }
}
