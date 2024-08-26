<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\ReviewLikeCount;
use Illuminate\Http\Request;

class CommentLikeCountApiController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        return ReviewLikeCount::all();
    }

    // Check like
    public function checkLike()
    {
        $likeCheck = ReviewLikeCount::where([
            "review_id" => request("reviewId"),
            "user_id" => request("userId"),
        ])->first();

        if ($likeCheck) {
            ReviewLikeCount::where("review_id", request("reviewId"))
                ->where("user_id", request("userId"))
                ->delete();
        } else {
            ReviewLikeCount::create([
                "review_id" => request("reviewId"),
                "user_id" => request("userId"),
            ]);
        }
    }

    /**
     * Display the specified resource.
     */
    public function show()
    {
        $likedButton = ReviewLikeCount::select("id", "review_id", "user_id")
            ->where("user_id", request("userId"))
            ->where("review_id", request("reviewId"))
            ->first();

        logger($likedButton);

        return response()->json([
            "likedButton" => $likedButton
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
