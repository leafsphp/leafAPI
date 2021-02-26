<?php

namespace App\Controllers\Auth;

use Leaf\Auth;
use Leaf\Form;

class RegisterController extends Controller
{
    public function store()
    {
        $credentials = request(["username", "email", "password"]);

        $validation = Form::validate([
            "username" => ["username", "max:15"],
            "email" => "email",
            "password" => "min:8"
        ]);

        if (!$validation) throwErr(Form::errors());

        $user = Auth::register("users", $credentials, [
            "username", "email"
        ]);

        if (!$user) throwErr(Auth::errors());

        json($user);
    }
}
