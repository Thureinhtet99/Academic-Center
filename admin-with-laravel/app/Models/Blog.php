<?php

namespace App\Models;


use App\Models\Author;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Blog extends Model
{
    use HasFactory;
    protected $fillable = [
        "category_id",
        "author_id",
        "blog_title",
        "blog_description",
        "blog_image",
    ];

    public function author()
    {
        return $this->belongsTo(Author::class);
    }
}
