<?php

namespace App\Models;

// use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Laravel\Sanctum\HasApiTokens;
use Tymon\JWTAuth\Contracts\JWTSubject;
class User extends Authenticatable implements JWTSubject
{
    /** @use HasFactory<\Database\Factories\UserFactory> */
    use HasFactory, Notifiable, HasApiTokens;

    /**
     * The attributes that are mass assignable.
     *
     * @var list<string>
     */
    protected $fillable = [
        'name',
        'email',
        'password',
        'current_plan'
    ];

    /**
     * The attributes that should be hidden for serialization.
     *
     * @var list<string>
     */
    protected $hidden = [
        'password',
        'remember_token',
    ];

    /**
     * Get the attributes that should be cast.
     *
     * @return array<string, string>
     */
    protected function casts(): array
    {
        return [
            'email_verified_at' => 'datetime',
            'password' => 'hashed',
        ];
    }


    public function getJWTIdentifier()
    {
        return $this->getKey();
    }

    public function getJWTCustomClaims()
    {
        return [
            'role'=>$this->role,
            'name'=>$this->name,
            'email'=>$this->email
        ];
    }

    public function post(): HasMany{
        return $this->hasMany(Post::class);
    }

    public function saves(): HasMany{
        return $this->hasMany(Save::class);
    }

    public function payment(): HasMany{
        return $this->hasMany(Payment::class);
    }

    public function userPlan(): HasMany{
        return $this->hasMany(UserPlan::class);
    }

    // public function plan(): BelongsTo{
    //     return $this->belongsTo(Plan::class);
    // }

    

    public function canAccessFilament(): bool{

        return $this->hasRole('admin');

    }
}
