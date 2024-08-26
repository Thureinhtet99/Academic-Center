<?php

namespace App\Models;

use App\Models\Course;
use App\Models\TestimonialLikeCount;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Testimonials extends Model
{
    use HasFactory;
    protected $fillable = [
        "user_id",
        "course_id",
        "text",
    ];

    public function course()
    {
        return $this->belongsTo(Course::class);
    }
    public function users()
    {
        return $this->hasMany(User::class);
    }
}
