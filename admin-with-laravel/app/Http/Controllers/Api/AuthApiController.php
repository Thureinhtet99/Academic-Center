<?php

namespace App\Http\Controllers\Api;

use App\Models\User;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Http;

class AuthApiController extends Controller
{
    // Check user
    public function checkUser()
    {
        $checkEmail = User::where("email", request("email"))->exists();
        return response()->json([
            "checkEmail" => $checkEmail
        ]);
    }

    // Register
    public function register()
    {
        $datas = [
            "name" => request("name"),
            "email" => request("email"),
            "gender" => request("gender"),
            "phone" => request("phone"),
            "location" => request("address"),
            "profile_photo_path" => request("profilePhoto"),
            "password" => Hash::make(request("password")),
            "role" => "user",
        ];
        User::create($datas);
        $users = User::where("email", request("email"))->first();
        return response()->json([
            "users" => $users,
            "token" => $users->createToken(time())->plainTextToken,
        ]);
    }

    // Login
    public function login()
    {
        $users = User::where("email", request("email"))->first();
        if ($users) {
            if (Hash::check(request("password"), $users->password)) {
                return response()->json([
                    "users" => $users,
                    "token" => $users->createToken(time())->plainTextToken,
                ]);
            } else {
                return response()->json([
                    "users" => null,
                    "token" => null,
                ]);
            }
        } else {
            return response()->json([
                "users" => null,
                "token" => null,
            ]);
        }
    }

    // Google login
    public function googleLogin()
    {
        $users = User::where("email", request("email"))->first();
        if ($users) {
            return response()->json([
                "users" => $users,
                "token" => $users->createToken(time())->plainTextToken,
            ]);
        } else {
            $googleLoggedInUser = User::create([
                "name" => request("name"),
                "email" => request("email"),
                "profile_photo_path" => request("photo"),
            ]);
            return response()->json([
                "googleLoggedInUser" => $googleLoggedInUser,
                "googleLoggedInToken" => $googleLoggedInUser->createToken(time())->plainTextToken,
            ]);
        }
    }
}
