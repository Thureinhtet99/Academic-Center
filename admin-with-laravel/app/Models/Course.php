<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Course extends Model
{
    use HasFactory;
    protected $fillable = [
        "category_id",
        "author_id",
        "course_title",
        "course_description",
        "course_image",
        "course_view_count",
        "course_duration",
        "course_price",
        "course_about",
    ];

    public function testimonials()
    {
        return $this->hasMany(Testimonials::class);
    }
}
