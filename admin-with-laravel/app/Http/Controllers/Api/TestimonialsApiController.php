<?php

namespace App\Http\Controllers\Api;

use App\Models\Testimonials;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\Http\Controllers\Controller;
use Carbon\Carbon;
use Illuminate\Support\Facades\Date;

class TestimonialsApiController extends Controller
{
    // Index
    public function index()
    {
        $testimonials = Testimonials::all();
        return response()->json([
            "testimonials" =>  $testimonials,
        ]);
    }

    // Store
    public function store()
    {
        return Testimonials::create([
            "user_id" => request("userId"),
            "course_id" => request("courseId"),
            "text" => request("text"),
        ]);
    }

    // Show
    public function show()
    {
        $testimonialLength = Testimonials::where("course_id", request("courseId"))->count();

        $testimonials = Testimonials::select(
            "testimonials.id as testimonialId",
            "testimonials.user_id",
            "testimonials.course_id",
            "testimonials.text",
            "testimonials.created_at as testimonialCreatedAt",
            DB::raw("COUNT(testimonial_like_counts.user_id) as likeCount"),
            "users.name",
            "users.email",
            "users.gender",
            "users.profile_photo_path"
        )
            ->leftJoin("users", "users.id", "testimonials.user_id")
            ->leftJoin("testimonial_like_counts", "testimonial_like_counts.testimonial_id", "testimonials.id")
            ->where("testimonials.course_id", request("courseId"))
            ->groupBy(
                "testimonials.id",
                "testimonials.user_id",
                "testimonials.course_id",
                "testimonials.text",
                "testimonials.created_at",
                "users.name",
                "users.email",
                "users.gender",
                "users.profile_photo_path"
            )
            ->orderBy("testimonials.id", "desc")
            ->get();

        $sortByMostHelpful = Testimonials::select(
            "testimonials.id as testimonialId",
            "testimonials.user_id",
            "course_id",
            "text",
            "testimonials.created_at as testimonialCreatedAt",
            "testimonial_like_counts.id as testimonialLikeCountId",
            "testimonial_like_counts.user_id as likeCountUserId",
            DB::raw("COUNT(testimonial_like_counts.user_id) as likeCount")
        )
            ->leftJoin("testimonial_like_counts", "testimonial_like_counts.testimonial_id", "testimonials.id")
            ->where("testimonials.course_id", request("courseId"))
            ->groupBy("testimonials.id", "testimonials.user_id", "course_id", "text", "testimonials.created_at")
            ->orderBy("likeCount", "desc")
            ->get();

        $allTestimonials = Testimonials::select(
            "testimonials.id as testimonialId",
            "testimonials.user_id",
            "course_id",
            "text",
            "testimonials.created_at as testimonialCreatedAt",
            "testimonial_like_counts.id as testimonialLikeCountId",
            "testimonial_like_counts.user_id as likeCountUserId",
            DB::raw("COUNT(testimonial_like_counts.user_id) as likeCount"),
        )
            ->leftJoin("testimonial_like_counts", "testimonial_like_counts.testimonial_id", "testimonials.id")
            ->where("testimonials.course_id", request("courseId"))
            ->groupBy("testimonials.id", "testimonials.user_id", "course_id", "text", "testimonials.created_at")
            ->orderBy("testimonials.id", "desc")
            ->get();

        return response()->json([
            "testimonialLength" =>  $testimonialLength,
            "testimonials" =>  $testimonials,
            "sortByMostHelpful" =>  $sortByMostHelpful,
            "allTestimonials" =>  $allTestimonials,
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
    public function destroy()
    {
        return Testimonials::where("id", request("testimonialId"))->delete();
    }
}
