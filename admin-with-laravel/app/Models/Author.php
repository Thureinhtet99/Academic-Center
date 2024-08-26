<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Author extends Model
{
    use HasFactory;
    protected $fillable = [
        "author_name",
        "author_email",
        "author_phone",
        "author_birthday",
        "author_gender",
        "author_degree",
        "author_about",
        "author_image",
    ];
}
