<?php

namespace App\Http\Controllers\Api;

use App\Models\User;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Storage;

class ProfileApiController extends Controller
{
    // Update
    public function update()
    {
        // logger(request()->all());
        $updateFormData = $this->updateFormData();
        if (request()->hasFile("image")) {
            $img = User::where("id", request("userId"))->first();
            $img = $img->profile_photo_path;

            if ($img != null) {
                Storage::delete("public/$img");
            }

            $imgName = uniqid() . request()->file("image")->getClientOriginalName();
            request()->file("image")->storeAs("public", $imgName);
            $updateFormData["profile_photo_path"] = $imgName;
        }
        User::where("id", request("userId"))->update($updateFormData);
        $users = User::where("email", request("email"))->first();

        return response()->json([
            "users" => $users,
        ]);
    }

    // updateProfileImg
    // public function updateProfileImg()
    // {
    //     if (request()->hasFile("image")) {
    //         $img = User::where("id", request("userId"))->first();
    //         $img = $img->profile_photo_path;

    //         if ($img != null) {
    //             Storage::delete("public/$img");
    //         }

    //         $imgName = uniqid() . request()->file("image")->getClientOriginalName();
    //         request()->file("image")->storeAs("public", $imgName);
    //         $formDatas["profile_photo_path"] = $imgName;
    //     }
    //     $userProfileImg = User::select("profile_photo_path")->where("email", request("email"))->first();
    //     return response()->json([
    //         "userProfileImg" => $userProfileImg,
    //     ]);
    // }

    // Update social-links
    public function updateSocialLink()
    {
        User::where("id", request("userId"))->update([
            "github_link" => request("github"),
            "facebook_link" => request("facebook"),
            "linkedin_link" => request("linkedin"),
        ]);
        $socials = User::where("email", request("email"))->first();
        logger($socials);

        return response()->json([
            "socials" => $socials,
        ]);
    }

    // Update password
    public function updatePassword()
    {
        $oldPwd = User::select("password")->where("id", request("userId"))->first();
        if (Hash::check(request("oldPwd"), $oldPwd->password)) {
            User::where("id", request("userId"))->update([
                "password" => Hash::make(request("newPwd"))
            ]);
        };
    }

    // PRIVATE
    private function updateFormData()
    {
        return [
            "name" => request("userName"),
            "phone" => request("phone"),
            "gender" => request("gender"),
            "location" => request("location"),
            "about" => request("about"),

        ];
    }
}
