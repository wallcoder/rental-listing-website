<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\HasOne;

class Plan extends Model
{
    protected $guarded = [];

    public function payment(): HasMany{
        return $this->hasMany(Payment::class);
    }

    public function userPlan(): HasMany{
        return $this->hasMany(UserPlan::class);
    }

    // public function user(): HasOne{
    //     return $this->hasOne(User::class);
    // }


}
