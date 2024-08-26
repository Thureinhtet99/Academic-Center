<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;

class UserAjaxController extends Controller
{
    public function sortByMale()
    {
        $sortByMale = User::where(
            [
                ["gender", "male"],
                ["role", "user"]
            ]
        )->get();
        return $sortByMale;
    }

    public function sortByFemale()
    {
        $sortByFemale = User::where(
            [
                ["gender", "female"],
                ["role", "user"]
            ]
        )->get();
        return $sortByFemale;
    }

    public function allUser()
    {
        $allUser = User::where("role", "user")->get();
        return $allUser;
    }
}
