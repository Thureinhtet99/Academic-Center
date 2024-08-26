<?php

namespace App\Http\Controllers;

use App\Models\Author;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Validator;

class AuthorController extends Controller
{
    // Index
    public function index()
    {
        $authors = Author::select(
            "id",
            "author_name",
            "author_degree",
            "author_email",
            "author_image",
            "author_gender",
        )
            ->get();
        return view("author.index", compact("authors"));
    }

    // CreateIndex
    public function createIndex()
    {
        $degrees = Http::get("https://gist.githubusercontent.com/cblanquera/21c925d1312e9a4de3c269be134f3a6c/raw/4e227bcf3ac9be3adecf64382edd5f7291ef2065/certs.json")->json();
        return view("author.createIndex", compact("degrees"));
    }

    // Create
    public function create()
    {
        $this->createValidationCheck();
        $formDatas = $this->createFormData();

        if (request()->hasFile("image")) {
            $imageName = uniqid() . request()->file("image")->getClientOriginalName();
            request()->file("image")->storeAs("public", $imageName);
            $formDatas["author_image"] = $imageName;
        } else {
            $formDatas["author_image"] = NULL;
        }

        Author::create($formDatas);
        return redirect()->route("author.index")->with(["createSuccess" => "Create Success"]);
    }

    // Edit
    public function edit($id)
    {
        $authors = Author::select(
            "id",
            "author_name",
            "author_degree",
            "author_email",
            "author_phone",
            "author_about",
            "author_birthday",
            "author_image",
            "author_gender",
        )
            ->where("id", $id)
            ->first();
        $degrees = Http::get("https://gist.githubusercontent.com/cblanquera/21c925d1312e9a4de3c269be134f3a6c/raw/4e227bcf3ac9be3adecf64382edd5f7291ef2065/certs.json")->json();
        return view("author.edit", compact("authors", "degrees"));
    }

    // Update
    public function update($id)
    {
        $this->createValidationCheck();
        $datas = $this->createFormData();
        if (request()->hasFile("image")) {
            $img = Author::where("id", $id)->first();
            $img = $img->category_image;

            if ($img != null) {
                Storage::delete("public/$img");
            }

            $fileName = uniqid() . request()->file("image")->getClientOriginalName();
            request()->file("image")->storeAs("public", $fileName);
            $datas["author_image"] = $fileName;
        }

        Author::where("id", $id)->update($datas);
        return redirect()->route("author.index")->with(["updateSuccess" => "Update Success"]);
    }

    // Delete
    public function delete($id)
    {
        Author::find($id)->delete();
        return redirect()->route("author.index")->with(["deleteSuccess" => "Delete Success"]);
    }

    // PRIVATE
    private function createFormData()
    {
        return [
            "author_name" => request("name"),
            "author_email" => request("email"),
            "author_phone" => request("phone"),
            "author_birthday" => request("birthday"),
            "author_gender" => request("gender"),
            "author_degree" => request("degree"),
            "author_about" => request("about"),
        ];
    }

    private function createValidationCheck()
    {
        $validationRules = [
            "name" => "required",
            "email" => "required",
            "gender" => "required",
            "degree" => "required",
            "about" => "required",
        ];
        return Validator::make(request()->all(), $validationRules)->validate();
    }
}
