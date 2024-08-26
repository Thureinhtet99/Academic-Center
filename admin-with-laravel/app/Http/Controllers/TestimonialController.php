<?php

namespace App\Http\Controllers;

use App\Models\Testimonials;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class TestimonialController extends Controller
{

    // Index
    public function index()
    {
        $testimonials = Testimonials::select(
            "testimonials.id",
            "testimonials.course_id",
            "text",
            DB::raw("COUNT(testimonial_like_counts.testimonial_id) as likeCount")
        )
            ->leftJoin("testimonial_like_counts", "testimonial_like_counts.testimonial_id", "testimonials.id")
            ->groupBy("testimonials.id")
            ->get();
        return view("reviews.index", compact("testimonials"));
    }

    // Delete
    public function delete($id)
    {
        Testimonials::where("id", $id)->delete();
        return back()->with(["deleteSuccess" => "Delete Success"]);
    }
}
