<?php

namespace App\Http\Controllers;

use App\Models\User;

class UserController extends Controller
{
    // Index
    public function index()
    {
        $users = User::when(request("search"), function ($query) {
            $query->orWhere("name", "like", "%" . request("search") . "%")
                ->orWhere("email", "like", "%" . request("search") . "%");
        })
            ->where("role", "user")
            ->latest()
            ->paginate(5);
        $users->appends(request()->all());
        return view("users.index", compact("users"));
    }

    // Update
    public function update($id)
    {
        $users = User::select("role")->where("id", $id)->update([
            "role" => request("role")
        ]);
        return redirect()->route("users.index", compact("users"))->with(["updateSuccess" => "Update Success"]);
    }

    // Delete
    public function delete($id)
    {
        $users = User::where("id", $id)->delete();
        return redirect()->route("users.index", compact("users"))->with(["deleteSuccess" => "Delete Success"]);
    }
}
