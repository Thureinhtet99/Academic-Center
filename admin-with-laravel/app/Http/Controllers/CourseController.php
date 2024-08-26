<?php

namespace App\Http\Controllers;

use Carbon\Carbon;
use App\Models\Author;
use App\Models\Course;
use App\Models\Category;
use App\Models\Testimonials;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Validator;

class CourseController extends Controller
{
    // Index
    public function index()
    {
        $courses = Course::select(
            "courses.id as courseId",
            "course_title",
            "course_description",
            "course_image",
            "courses.created_at as coursesCreatedAt",
            "category_name",
            "author_name",
            DB::raw("COUNT(testimonials.course_id) as testimonialCount")
        )
            ->when(request("search"), function ($query) {
                $query->orWhere("courses.course_title", "like", "%" . request("search") . "%");
            })
            ->leftJoin("categories", "categories.id", "courses.category_id")
            ->leftJoin("authors", "authors.id", "courses.author_id")
            ->leftJoin("testimonials", "testimonials.course_id", "courses.id")
            ->groupBy("courses.id")
            ->orderBy("courses.id", "desc")
            ->get();
        return view("course.index", compact("courses"));
    }

    // CreateIndex
    public function createIndex()
    {
        $categories = Category::select(
            "id",
            "category_name"
        )
            ->get();
        $authors = Author::select(
            "id",
            "author_name"
        )
            ->get();
        return view("course.createIndex", compact("categories", "authors"));
    }

    // Create
    public function create()
    {
        $this->createValidationCheck();
        $formDatas = $this->createFormData();

        if (request()->file("image")) {
            $imgName = uniqid() . request()->file("image")->getClientOriginalName();
            request()->file("image")->storeAs("public", $imgName);
            $formDatas["course_image"] = $imgName;
        } else {
            $formDatas["course_image"] = NULL;
        }
        Course::create($formDatas);
        return redirect()->route("course.index");
    }

    // Read
    public function read($id)
    {
        $courses = Course::select(
            "courses.id as courseId",
            "course_title",
            "course_description",
            "course_image",
            "course_duration",
            "course_price",
            "courses.created_at as coursesCreatedAt",
            "author_name",
            DB::raw("COUNT(own_courses.user_id) as userCount")
        )
            ->leftJoin("authors", "authors.id", "courses.author_id")
            ->leftJoin("own_courses", "own_courses.course_id", "courses.id")
            ->where("courses.id", $id)
            ->first();

        $testimonials = Testimonials::select(
            "text",
            "user_id",
            "course_id",
            "courses.id",
            "users.id",
            "users.name",
        )
            ->leftJoin("courses", "courses.id", "testimonials.course_id")
            ->leftJoin("users", "users.id", "testimonials.user_id")
            ->where("courses.id", $id)
            ->get();

        return view("course.read", compact("courses", "testimonials"));
    }

    // Edit
    public function edit($id)
    {
        $courses = Course::select(
            "courses.id as courseId",
            "course_title",
            "course_description",
            "course_image",
            "course_duration",
            "course_price",
            "courses.created_at as coursesCreatedAt",
            "category_id",
            "category_name",
            "author_id",
            "author_name",
            DB::raw("COUNT(own_courses.user_id) as userCount")
        )
            ->leftJoin("authors", "authors.id", "courses.author_id")
            ->leftJoin("categories", "categories.id", "courses.category_id")
            ->leftJoin("own_courses", "own_courses.course_id", "courses.id")
            ->where("courses.id", $id)
            ->first();

        $testimonials = Testimonials::select(
            "testimonials.id as testimonialId",
            "text",
            "user_id",
            "course_id",
            "courses.id",
            "users.id",
            "users.name",
        )
            ->leftJoin("courses", "courses.id", "testimonials.course_id")
            ->leftJoin("users", "users.id", "testimonials.user_id")
            ->where("courses.id", $id)
            ->get();

        $authors = Author::get();
        $categories = Category::get();
        return view("course.edit", compact("courses", "testimonials", "authors", "categories"));
    }

    // Update
    public function update($id)
    {
        $formDatas = $this->updateFormData();
        if (request()->hasFile("image")) {
            $img = Course::where("id", $id)->first();
            $img = $img->course_image;

            if ($img != null) {
                Storage::delete("public/$img");
            }

            $imgName = uniqid() . request()->file("image")->getClientOriginalName();
            request()->file("image")->storeAs("public", $imgName);
            $formDatas["course_image"] = $imgName;
        }
        Course::where("id", $id)->update($formDatas);
        return redirect()->route("course.index")->with(["updateSuccess" => "Update Success"]);
    }

    // Delete
    public function delete($id)
    {
        Course::where("id", $id)->delete();
        return redirect()->route("course.index")->with(["deleteSuccess" => "Delete Success"]);
    }

    // PRIVATE
    private function createFormData()
    {
        return [
            "category_id" => request("courseCategory"),
            "course_title" => request("title"),
            "course_description" => request("description"),
            "author_id" => request("authorName"),
            "course_duration" => request("duration"),
            "course_price" => request("price"),
            "course_about" => request("about"),
            "created_at" => Carbon::now(),
        ];
    }

    private function updateFormData()
    {
        return [
            "course_title" => request("title"),
            "course_description" => request("description"),
            "course_duration" => request("duration"),
            "course_price" => request("price"),
            "course_about" => request("about"),
            "author_id" => request("authorName"),
            "created_at" => Carbon::now(),
        ];
    }

    private function createValidationCheck()
    {
        $validationRules = [
            "courseCategory" => "required",
            "title" => "required",
            "description" => "required",
            "authorName" => "required",
            "duration" => "required",
            "price" => "required",
            "about" => "required",
        ];
        return Validator::make(request()->all(), $validationRules)->validate();
    }
}
