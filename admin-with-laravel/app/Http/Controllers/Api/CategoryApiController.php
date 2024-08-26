<?php

namespace App\Http\Controllers\Api;

use App\Models\Category;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\Http\Controllers\Controller;

class CategoryApiController extends Controller
{
    // Index
    public function index()
    {
        $categories = Category::select(
            "id",
            "category_name",
            "category_image",
            "category_description"
        )
            ->orderBy("id", "desc")
            ->get();

        $groupByCategories = Category::select(
            "categories.id as categoryId",
            "category_name",
            "category_id",
            DB::raw("COUNT(category_id) as courseCount"),
            "courses.id as courseId",

        )
            ->leftJoin("courses", "courses.category_id", "categories.id")
            ->groupBy("category_name")
            ->orderBy("courseCount", "desc")
            ->get();

        return response()->json([
            "categories" =>  $categories,
            "groupByCategories" =>  $groupByCategories,
        ]);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        //
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
