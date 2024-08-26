<?php

namespace App\Http\Controllers\Api;

use Illuminate\Http\Request;
use App\Models\BlogActionLog;
use Illuminate\Support\Facades\DB;
use App\Http\Controllers\Controller;

class BlogActionLogApiController extends Controller
{
    // Index
    public function index()
    {
        $mostTrendBlogs =  BlogActionLog::select(
            "blog_action_logs.id",
            "user_id",
            "blog_id",
            "blogs.id as blogId",
            "blog_title",
            "blog_description",
            "blog_image",
            "blogs.created_at as blogCreatedAt",
            DB::raw("COUNT(blog_action_logs.id) as trendBlogs")
        )
            ->leftJoin("blogs", "blog_action_logs.blog_id", "blogs.id")
            ->groupBy(
                "blog_action_logs.blog_id",
            )
            ->orderBy("trendBlogs", "desc")
            ->first();

        $trendBlogs =  BlogActionLog::select(
            "blog_action_logs.id",
            "user_id",
            "blog_id",
            "blogs.id as blogId",
            "blog_title",
            "blog_description",
            "blog_image",
            "blogs.created_at as blogCreatedAt",
            DB::raw("COUNT(blog_action_logs.id) as trendBlogs")
        )
            ->leftJoin("blogs", "blog_action_logs.blog_id", "blogs.id")
            ->groupBy(
                "blog_action_logs.blog_id",
            )
            ->orderBy("trendBlogs", "desc")
            ->limit(4)
            ->get();
        return response()->json([
            "mostTrendBlogs" => $mostTrendBlogs,
            "trendBlogs" => $trendBlogs,
        ]);
    }

    // Store
    public function store()
    {
        return BlogActionLog::create([
            "user_id" => request("userId"),
            "blog_id" => request("blogId"),
        ]);
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        //
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
