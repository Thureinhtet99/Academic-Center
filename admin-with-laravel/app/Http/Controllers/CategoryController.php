<?php

namespace App\Http\Controllers;

use App\Models\Course;
use App\Models\Category;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Validator;

class CategoryController extends Controller
{
    // Index
    public function index()
    {
        $categories = Category::select(
            "categories.id",
            "category_name",
            "category_image",
            "category_description",
            "courses.id as courseId",
            DB::raw("COUNT(courses.category_id) as course_count")
        )
            ->leftJoin("courses", "courses.category_id", "categories.id")
            ->groupBy("categories.id")
            ->get();
        return view("category.index", compact("categories"));
    }

    // Create
    public function create()
    {
        $this->createValidationCheck();
        $formDatas = $this->createFormData();

        if (request()->file("image")) {
            $imageName = uniqid() . request()->file("image")->getClientOriginalName();
            request()->file("image")->storeAs("public", $imageName);
            $formDatas["category_image"] = $imageName;
        } else {
            $formDatas["category_image"] = NULL;
        }

        Category::create($formDatas);
        return redirect()->route("category.index")->with(["createSuccess" => "Create Success"]);
    }

    // Edit
    public function edit($id)
    {
        $categories = Category::select(
            "id",
            "category_name",
            "category_image",
            "category_description",
        )
            ->get();
        $items = Category::select(
            "id",
            "category_name",
            "category_image",
            "category_description"
        )
            ->find($id);
        return view("category.edit", compact("categories", "items"));
    }

    // Update
    public function update($id)
    {
        $this->createValidationCheck();
        $formDatas = $this->createFormData();

        if (request()->hasFile("image")) {
            $img = Category::find($id);
            $img = $img->category_image;

            if ($img != null) {
                Storage::delete("public/$img");
            }

            $imageName = uniqid() . request()->file("image")->getClientOriginalName();
            request()->file("image")->storeAs("public", $imageName);
            $formDatas["category_image"] = $imageName;
        }

        Category::where("id", $id)->update($formDatas);
        return redirect()->route("category.index")->with(["updateSuccess" => "Update Success"]);
    }

    // Delete
    public function delete($id)
    {
        Category::where("id", $id)->delete();
        return redirect()->route("category.index")->with(["deleteSuccess" => "Delete Success"]);
    }

    // PRIVATE
    private function createFormData()
    {
        return [
            "category_name" => request("name"),
            "category_description" => request("description"),
        ];
    }

    private function createValidationCheck()
    {
        $validationRules = [
            "name" => "required",
            "description" => "required",
        ];
        return Validator::make(request()->all(), $validationRules)->validate();
    }

    // private function updateValidationCheck()
    // {
    //     $validationRules = [
    //         "name" => "required|unique:categories,category_name," . request()->id,
    //         "description" => "required",
    //     ];
    //     return Validator::make(request()->all(), $validationRules)->validate();
    // }
}
