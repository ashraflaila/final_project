<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Profile extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_id',
        'bio',
        'avatar',
        'website',
        'facebook_url',
        'linkedin_url',
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }
}
