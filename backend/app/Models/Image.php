<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Image extends Model
{
    protected $guarded = [];

    public function post(): BelongsTo{
        return $this->belongsTo(Post::class);
    }
}
