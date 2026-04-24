<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Illuminate\Database\Eloquent\SoftDeletes;

class Teacher extends Authenticatable
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
        'bio',
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

    public function courses()
    {
        return $this->hasMany(Course::class);
    }
}
