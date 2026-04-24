<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Country extends Model
{
    use HasFactory , SoftDeletes;

    protected $fillable = [
        'name',
        'code',
    ];

    public function cities()
    {
        return $this->hasMany(City::class);
    }
    protected static function booted()
    {
        static::deleting(function($country) {
            $country->cities()->delete();
        });
    }
}
