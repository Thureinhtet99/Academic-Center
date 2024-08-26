<?php

namespace App\Http\Controllers\Api;

use Carbon\Carbon;
use App\Models\Review;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\Http\Controllers\Controller;
use Egulias\EmailValidator\Parser\Comment;

class CommentApiController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        return Review::create([
            "user_id" => request("userId"),
            "lesson_id" => request("lessonId"),
            "review_text" => request("commentText"),
        ]);
    }

    /**
     * Display the specified resource.
     */
    public function show()
    {
        $comments = Review::select(
            "reviews.id as reviewId",
            "reviews.user_id as reviewUserId",
            "lesson_id",
            "review_text",
            "reviews.created_at as reviewCreatedAt",
            "users.id as userId",
            "name",
            "email",
            "gender",
            "profile_photo_path",
            "review_like_counts.user_id as reviewLikeCountUserId",
            DB::raw("COUNT(review_like_counts.user_id) as likeCount")
        )
            ->leftJoin("users", "users.id", "reviews.user_id")
            ->leftJoin("lessons", "lessons.id", "reviews.lesson_id")
            ->leftJoin("review_like_counts", "review_like_counts.review_id", "reviews.id")
            ->where("reviews.lesson_id", request("lessonId"))
            ->groupBy("reviews.id")
            ->orderBy("reviews.id", "desc")
            ->get();

        return response()->json([
            "comments" => $comments,
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
        Review::where("id", request("reviewId"))->delete();
    }
}
