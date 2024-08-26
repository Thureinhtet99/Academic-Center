<?php

namespace App\Http\Controllers\Api;

use App\Models\Author;
use App\Models\Course;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class AuthorApiController extends Controller
{
    // Index
    public function index()
    {
        return Author::select(
            "id",
            "author_name",
            "author_degree",
            "author_gender",
            "author_image",
        )
            ->orderBy("id", "desc")
            ->get();
    }

    /**
     * Display the specified resource.
     */
    public function show()
    {
        $authors =  Author::select(
            "authors.id",
            "author_name",
            "author_email",
            "author_gender",
            "author_about",
            "author_image",
            "author_degree",
        )
            ->where("id", request("authorId"))
            ->first();

        $courses = Course::select(
            "courses.id as courseId",
            "author_id",
            "course_title",
            "course_image",
            "authors.id as authorId"
        )
            ->leftJoin("authors", "authors.id", "courses.author_id")
            ->where("courses.author_id", request("authorId"))
            ->get();

        $courseCount =
            Course::select(
                "courses.id as courseId",
                "author_id",
                "course_title",
                "course_image",
                "authors.id as authorId"
            )
            ->leftJoin("authors", "authors.id", "courses.author_id")
            ->where("courses.author_id", request("authorId"))
            ->count();
        return response()->json([
            "authors" => $authors,
            "courses" => $courses,
            "courseCount" => $courseCount,
        ]);
    }
}
