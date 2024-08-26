<?php

namespace App\Http\Controllers;

use App\Models\Author;
use App\Models\Blog;
use App\Models\Category;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Validator;

class BlogController extends Controller
{
    // Index
    public function index()
    {
        $blogs = Blog::orderBy("id", "desc")->get();
        $categories = Category::orderBy("id", "desc")->get();
        $authors = Author::orderBy("id", "desc")->get();
        return view("blog.index", compact("blogs", "categories", "authors"));
    }

    // Create
    public function create()
    {
        $this->createValidationCheck();
        $createFormData = $this->createFormData();

        if (request()->file("image")) {
            $imageName = uniqid() . request()->file("image")->getClientOriginalName();
            request()->file("image")->storeAs("public", $imageName);
            $createFormData["blog_image"] = $imageName;
        } else {
            $createFormData["blog_image"] = null;
        }

        Blog::create($createFormData);
        return redirect()->route("blog.index")->with(["createSuccess" => "Create Succcess"]);
    }

    // Edit
    public function edit($id)
    {
        $blogs = Blog::get();
        $categories = Category::orderBy("id", "desc")->get();
        $items  = Blog::find($id);
        // dd($items->toArray());
        return view("blog.edit", compact("blogs", "categories", "items"));
    }

    // Update
    public function update($id)
    {
        $this->updateValidationCheck();
        $updateFormData = $this->updateFormData();

        if (request()->hasFile("image")) {
            $img = Blog::find($id);
            $img = $img->blog_image;

            if ($img != null) {
                Storage::delete("public/$img");
            }

            $imageName = uniqid() . request()->file("image")->getClientOriginalName();
            request()->file("image")->storeAs("public", $imageName);
            $updateFormData["blog_image"] = $imageName;
        }

        Blog::find($id)->update($updateFormData);
        return redirect()->route("blog.index")->with(["updateSuccess" => "Update Succcess"]);
    }

    // Delete
    public function delete($id)
    {
        Blog::find($id)->delete();
        return redirect()->route("blog.index")->with(["deleteSuccess" => "Delete Succcess"]);
    }

    // PRIVATE
    private function createFormData()
    {
        return [
            "category_id" => request("category"),
            "author_id" => request("author"),
            "blog_title" => request("title"),
            "blog_description" => request("description"),
        ];
    }

    private function updateFormData()
    {
        return [
            "category_id" => request("category"),
            "blog_title" => request("title"),
            "blog_description" => request("description"),
        ];
    }

    private function createValidationCheck()
    {
        $validationRules =  [
            "category" => "required",
            "author" => "required",
            "title" => "required|unique:blogs,blog_title," . request("id"),
            "description" => "required",
        ];

        $validationMsgs = [
            "category" => "Please select a category",
            "author" => "Please select an author",
        ];
        return Validator::make(request()->all(), $validationRules, $validationMsgs)->validate();
    }

    private function updateValidationCheck()
    {
        $validationRules =  [
            "category" => "required",
            "title" => "required|unique:blogs,blog_title," . request("id"),
            "description" => "required",
        ];

        $validationMsgs = [
            "category" => "Please select a category",
        ];
        return Validator::make(request()->all(), $validationRules, $validationMsgs)->validate();
    }
}
