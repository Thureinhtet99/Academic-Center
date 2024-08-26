<?php

namespace App\Http\Controllers\Api;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\Http\Controllers\Controller;
use App\Models\TestimonialLikeCount;

class TestimonialsLikeCountApiController extends Controller
{
    // Index
    public function index()
    {
        return TestimonialLikeCount::all();
    }

    // Show
    public function show()
    {
        $testimonialLikes = TestimonialLikeCount::where("id", request("id"))
            ->where("user_id", request("userId"))
            ->first();

        return response()->json([
            "testimonialLikes" => $testimonialLikes
        ]);
    }

    // Check Like
    public function checkLike()
    {
        $likeCheck = TestimonialLikeCount::where([
            "testimonial_id" => request("testimonialId"),
            "user_id" => request("userId"),
        ])->first();

        if ($likeCheck) {
            TestimonialLikeCount::where("testimonial_id", request("testimonialId"))
                ->where("user_id", request("userId"))
                ->delete();
            return response()->json([
                "status" => "deleted",
            ]);
        } else {
            TestimonialLikeCount::create([
                "testimonial_id" => request("testimonialId"),
                "user_id" => request("userId"),
            ]);
            return response()->json([
                "status" => "created",
            ]);
        }
        return response()->json([
            "likeCheck" => $likeCheck,
        ]);
    }
};
