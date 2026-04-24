<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Lesson extends Model
{
    use HasFactory, SoftDeletes;

    protected $fillable = [
        'title',
        'content',
        'video_url',
        'duration',
        'course_id',
        'status',
    ];

    protected $casts = [
        'duration' => 'integer',
    ];

    public function course()
    {
        return $this->belongsTo(Course::class);
    }
}
