<?php

namespace App\Http\Controllers\Api;

use App\Models\Course;
use App\Models\Lesson;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class CourseApiController extends Controller
{
    // Index
    public function index()
    {
        $courses = Course::select(
            "courses.id as courseId",
            "course_title",
            "course_description",
            "course_duration",
            "course_image",
            "course_price",
            "categories.id as categoryId",
            "category_name",
            "authors.id as authorId",
            "author_name",
            "author_gender",
            "author_degree",
            "author_image",
        )
            ->leftJoin("categories", "categories.id", "courses.category_id")
            ->leftJoin("authors", "authors.id", "courses.author_id")
            ->get();

        $latestCourses = Course::select("*", "courses.id as courseId")->orderBy("courses.id", "desc")->limit(4)->get();
        $courseByFree = Course::select("*", "courses.id as courseId")->where("course_price", 0)->get();
        $courseByPaid = Course::select("*", "courses.id as courseId")->where("course_price", ">", 0)->get();
        $courseByPriceAsc = Course::select("*", "courses.id as courseId")->orderBy("course_price", "asc")->get();
        $courseByPriceDesc = Course::select("*", "courses.id as courseId")->orderBy("course_price", "desc")->get();

        return response()->json([
            "courses" => $courses,
            "latestCourses" => $latestCourses,
            "courseByFree" => $courseByFree,
            "courseByPaid" => $courseByPaid,
            "courseByPriceAsc" => $courseByPriceAsc,
            "courseByPriceDesc" => $courseByPriceDesc,
        ]);
    }

    // Show course
    public function showCourse()
    {
        $courses = Course::select(
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
            ->where("courses.id",  request("courseId"))
            // ->where("lessons.id",  request("lessonId"))
            ->first();

        $totalLessonCount = Lesson::where("course_id", request("courseId"))->count();

        $lessons = Lesson::select(
            "lessons.id as lessonId",
            "course_id",
            "lesson_name",
        )
            ->where("course_id",  request("courseId"))
            ->orderBy("lessons.id", "asc")
            ->get();

        return response()->json([
            "courses" =>  $courses,
            "totalLessonCount" => $totalLessonCount,
            "lessons" =>  $lessons,
        ]);
    }

    // FilterByCategory
    public function filterByCategory()
    {
        $filterByCategories = Course::select(
            "courses.id as courseId",
            "category_id",
            "author_id",
            "course_title",
            "course_description",
            "course_image",
            "course_duration",
            "course_price",
            "course_about",
            "categories.id as categoryId",
            "category_name",
            "author_name",
        )
            ->leftJoin("categories", "categories.id", "courses.category_id")
            ->leftJoin("authors", "authors.id", "courses.author_id")
            ->where("categories.id", request("categoryId"))
            ->get();

        return response()->json([
            "filterByCategories" => $filterByCategories,
        ]);
    }
}
