<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Validator;

class ProfileController extends Controller
{
    // Read
    public function read()
    {
        User::where("id", auth()->user()->id)->first();
        return view("profile.read");
    }

    // Edit
    public function edit($id)
    {
        $users = User::where("id", auth()->user()->id)->first();
        $countries = Http::get("https://gist.githubusercontent.com/almost/7748738/raw/575f851d945e2a9e6859fb2308e95a3697bea115/countries.json")->json();
        return view('profile.edit', compact("users", "countries"));
    }

    // Update
    public function update()
    {
        $this->updateValidationCheck();
        $formDatas = $this->updateFormData();

        if (request()->hasFile("image")) {
            $img = User::where("id", auth()->user()->id)->first();
            $img = $img->profile_photo_path;

            if ($img != null) {
                Storage::delete("public/$img");
            }

            $imgName = uniqid() . request()->file("image")->getClientOriginalName();
            request()->file("image")->storeAs("public", $imgName);
            $formDatas["profile_photo_path"] = $imgName;
        }

        User::where("id", auth()->user()->id)->update($formDatas);
        return redirect()->route("profile.read", auth()->user()->id)->with(["updateSuccess" => "Update Success"]);
    }

    // PRVATE
    private function updateFormData()
    {
        return [
            "name" => request()->name,
            "email" => request()->email,
            "phone" => request()->phone,
            "gender" => request()->gender,
            "location" => request()->location,
            "about" => request()->about,
        ];
    }

    private function updateValidationCheck()
    {
        $validationRules = [
            "name" => "required",
            "email" => "required",
            "gender" => "required",
        ];
        return Validator::make(request()->all(), $validationRules)->validate();
    }
}
