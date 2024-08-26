<?php

namespace App\Http\Controllers\Api;

use App\Models\Author;
use App\Models\Course;
use App\Models\Lesson;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\Http\Controllers\Controller;

class LessonApiController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        //
    }

    // Show
    public function show()
    {
        $lessons = Course::select(
            "courses.id as courseId",
            "course_title",
            "course_description",
            "course_image",
            "course_duration",
            "course_price",
            "course_about",
            "categories.id as categoryId",
            "category_name",
            "category_description",
            "category_image",
            "authors.id as authorId",
            "author_name",
            "author_gender",
            "author_degree",
            "author_image",
            "author_about",
            "lessons.id as lessonId",
            "course_id",
            "lesson_name",
            "lesson_description",
            "lessons.created_at as lessonCreatedAt",
        )
            ->leftJoin("categories", "categories.id", "courses.category_id")
            ->leftJoin("authors", "authors.id", "courses.author_id")
            ->leftJoin("lessons", "courses.id", "lessons.course_id")
            ->where("lessons.id",  request("lessonId"))
            ->first();

        $lessonVideos = Lesson::select(
            "lessons.id as lessonId",
            "course_id",
            "lesson_name",
            "lesson_description",
            "lesson_video",
            "lessons.created_at as lessonCreatedAt",
            "course_title",
            "review_text",
        )
            ->leftJoin("courses", "courses.id", "lessons.course_id")
            ->leftJoin("reviews", "reviews.lesson_id", "lessons.id")
            ->where("lessons.course_id",  request("courseId"))
            ->orderBy("lessons.id", "asc")
            ->first();

        $authors = Author::select(
            "authors.id",
            "author_name",
            "author_image",
            "author_gender",
            "author_degree",
            "author_about",
            "courses.id"
        )
            ->leftJoin("courses", "courses.author_id", "authors.id")
            ->where("courses.id",  request("courseId"))
            ->first();

        return response()->json([
            "lessons" => $lessons,
            "lessonVideos" => $lessonVideos,
            "authors" => $authors,
        ]);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        //
    }
}
