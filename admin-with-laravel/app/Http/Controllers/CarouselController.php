<?php

namespace App\Http\Controllers;

use App\Models\Carousel;
use Illuminate\Support\Facades\Validator;

class CarouselController extends Controller
{
    // Index
    public function index()
    {
        $carousels = Carousel::select(
            "id",
            "carousel_image",
            "carousel_description",
        )->get();
        return view("carousel.index", compact("carousels"));
    }

    // Create
    public function create()
    {
        $this->createValidationCheck();
        $formDatas = $this->createFormData();

        if (request()->file("image")) {
            $imgName = uniqid() . request()->file("image")->getClientOriginalName();
            request()->file("image")->storeAs("public", $imgName);
            $formDatas["carousel_image"] = $imgName;
        } else {
            $formDatas["carousel_image"] = NULL;
        }

        Carousel::create($formDatas);
        return redirect()->route("carousel.index")->with(["updateSuccess" => "Update Success"]);
    }

    // Delete
    public function delete($id)
    {
        Carousel::where("id", $id)->delete();
        return redirect()->route("carousel.index")->with(["deleteSuccess" => "Delete Success"]);
    }

    // PRIVATE
    private function createFormData()
    {
        return [
            "carousel_image" => request("image"),
            "carousel_description" => request("description"),
        ];
    }

    // Validation
    private function createValidationCheck()
    {
        $validationRules = [
            "image" => "required",
            "description" => "required",
        ];
        return Validator::make(request()->all(), $validationRules)->validate();
    }
}
