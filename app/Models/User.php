<?php

namespace App\Models;

// use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;

class User extends Authenticatable
{
    /** @use HasFactory<\Database\Factories\UserFactory> */
    use HasFactory, Notifiable;

    /**
     * The attributes that are mass assignable.
     *
     * @var list<string>
     */
    protected $fillable = [
        'first_name',
        'last_name',
        'email',
        'password',
        'mobile',
        'address',
        'birth_date',
        'image',
        'gender',
        'status',
        'city_id',
        'actor_type',
        'actor_id',
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
            'birth_date' => 'date',
        ];
    }
    public function city()
    {
        return $this->belongsTo(City::class);
    }
    public function actorable()
    {
        return $this->morphTo(__FUNCTION__, 'actor_type', 'actor_id');
    }

    public function actor()
    {
        return $this->morphTo(__FUNCTION__, 'actor_type', 'actor_id');
    }

    public function profile()
    {
        return $this->hasOne(Profile::class);
    }
}
