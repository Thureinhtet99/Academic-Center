<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class TestimonialLikeCount extends Model
{
    use HasFactory;
    protected $fillable = [
        "testimonial_id",
        "user_id",
    ];
}
