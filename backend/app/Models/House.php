<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasOne;

class House extends Model
{
    protected $guarded = [];

    public function post(): BelongsTo{
        return $this->belongsTo(Post::class);
    }
}
