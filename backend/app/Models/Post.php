<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\HasOne;

class Post extends Model
{
    protected $guarded = [];

    public function user(): BelongsTo{
        return $this->belongsTo(User::class);
    }

    public function image(): HasMany{
        return $this->hasMany(Image::class);
    }

    public function location(): HasOne{
        return $this->hasOne(Location::class);
    }

    public function house(): HasOne{
        return $this->hasOne(House::class);
    }

    public function shop(): HasOne{
        return $this->hasOne( Shop::class);
    }

    public function saves(): HasMany{
        return $this->hasMany(Save::class);
    }

    public function payment(): HasMany{
        return $this->hasMany(Payment::class);
    }

    
}
