<?php

namespace App\Http\Controllers;

class AuthController extends Controller
{
    // Login
    public function loginPage()
    {
        return view("auth.login");
    }

    // Register
    public function registerPage()
    {
        return view("auth.register");
    }
}
