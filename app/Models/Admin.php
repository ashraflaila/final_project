<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Illuminate\Database\Eloquent\SoftDeletes;

class Admin extends Authenticatable
{
    use HasFactory, Notifiable, SoftDeletes;

    protected $fillable = [
        'email',
        'password',
        'name',
        'last_name',
        'country_id',
        'mobile',
        'date',
        'address',
        'gender',
        'status',
        'image',
    ];

    protected $hidden = [
        'password',
        'remember_token',
    ];

    protected function casts(): array
    {
        return [
            'password' => 'hashed',
            'date'     => 'date',
        ];
    }

    public function country()
    {
        return $this->belongsTo(Country::class);
    }

    public function actorable()
    {
        return $this->morphOne(User::class, 'actor', 'actorable_type', 'actorable_id', 'id');
    }
}
