<?php

namespace App\Http\Controllers\Api;

use App\Models\User;
use App\Models\Course;
use App\Models\OwnCourse;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\DB;

class OwnCourseApiController extends Controller
{
    // Show
    public function show()
    {
        // $user = User::select(
        //     "users.id as userId",
        //     "name",
        //     "email",
        //     "profile_photo_path",
        //     "gender",
        //     "about",
        //     "github_link",
        //     "facebook_link",
        //     "linkedin_link",
        // )
        //     ->where("users.id", request("userId"))
        //     ->first();

        $ownCourses = Course::select(
            "courses.id as courseId",
            "course_title",
            "course_image",
            "own_courses.id as ownCourseId",
            "own_courses.user_id as ownCourseUserUd",
            "own_courses.course_id as ownCourseCourseId",
            DB::raw("COUNT(lessons.id) as lessonCounts")
        )
            ->leftJoin("own_courses", "own_courses.course_id", "courses.id")
            ->leftJoin("categories", "categories.id", "courses.category_id")
            ->leftJoin("lessons", "lessons.course_id", "lessons.id")
            ->where("own_courses.user_id", request("userId"))
            ->groupBy("courses.id")
            ->orderBy("own_courses.id")
            ->get();


        logger($ownCourses);
        return response()->json([
            "ownCourses" => $ownCourses
        ]);
    }

    // Store
    public function store()
    {
        $ownCourses = OwnCourse::create([
            "user_id" => request("userId"),
            "course_id" => request("courseId"),
        ]);

        return response()->json([
            "ownCourses" => $ownCourses,
        ]);
    }
}
