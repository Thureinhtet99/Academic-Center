<?php

namespace App\Http\Controllers\Api;

use App\Models\Blog;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Models\Category;

class BlogApiController extends Controller
{
    // Index
    public function index()
    {
        // $page = request()->input("page", 1);
        // $perPage = ($page - 1) * 12;
        // $blogs = Blog::latest("id")->offset($perPage)->limit(12)->get();
        $blogs = Blog::select(
            "blogs.id as blogId",
            "blogs.category_id",
            "blogs.author_id",
            "blogs.blog_title",
            "blogs.blog_description",
            "blogs.blog_image",
            "blogs.created_at as blogCreatedAt",
            "categories.id as categoryId",
            "categories.category_name",
            "authors.author_name",
        )
            ->leftJoin("categories", "categories.id", "blogs.category_id")
            ->leftJoin("authors", "authors.id", "blogs.author_id")
            ->orderBy("blogs.id", "desc")
            ->get();

        $categories = Category::orderBy("id", "desc")->get();

        return response()->json([
            "blogs" => $blogs,
            "categories" => $categories,
        ]);
    }

    // Show
    public function show()
    {
        $blogDetails = Blog::select(
            "blogs.id as blogId",
            "blogs.category_id",
            "blogs.author_id",
            "blogs.blog_title",
            "blogs.blog_description",
            "blogs.blog_image",
            "blogs.created_at as blogCreatedAt",
            "categories.id as categoryId",
            "categories.category_name",
            "authors.author_name",
            "authors.author_image",
            "authors.author_degree",
        )
            ->leftJoin("categories", "categories.id", "blogs.category_id")
            ->leftJoin("authors", "authors.id", "blogs.author_id")
            ->where("blogs.id", request("blogId"))
            ->first();


        return response()->json([
            "blogDetails" => $blogDetails,
        ]);
    }

    // Related Blog Show
    public function relatedBlogShow()
    {
        $relatedBlogs = Blog::select(
            "blogs.id as blogId",
            "blogs.category_id",
            "blogs.author_id",
            "blogs.blog_title",
            "blogs.blog_description",
            "blogs.blog_image",
            "blogs.created_at as blogCreatedAt",
            "categories.id as categoryId",
            "categories.category_name",
            "authors.author_name",
            "authors.author_image",
            "authors.author_degree",
        )
            ->leftJoin("categories", "categories.id", "blogs.category_id")
            ->leftJoin("authors", "authors.id", "blogs.author_id")
            ->where("categories.id", request("relatedBlogCategoryId"))
            ->inRandomOrder()
            ->limit(4)
            ->get();

        return response()->json([
            "relatedBlogs" => $relatedBlogs,
        ]);
    }
}
