<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Models\Author;
use App\Models\Course;
use App\Models\Category;
use Illuminate\Http\Request;

class DashboardController extends Controller
{
    // Index
    public function index()
    {
        $categories = Category::all();
        $courses = Course::all();
        $authors = Author::select(
            "author_name",
            "author_degree",
        )
            ->orderBy("id", "desc")
            ->get();
        $users = User::select(
            "name",
            "email",
            "gender",
            "profile_photo_path",
        )
            ->where("role", "user")
            ->orderBy("id", "desc")
            ->get();

        return view("dashboard.index", compact("categories", "courses", "authors", "users"));
    }
}
