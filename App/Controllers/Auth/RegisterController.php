<?php

namespace App\Controllers\Auth;

use Leaf\Auth;
use Leaf\Form;

class RegisterController extends Controller
{
    // read the login controller to understand what each feature does.
    public function store()
    {
        $credentials = request(["username", "email", "password"]);

        $validation = Form::validate([
            "username" => ["username", "max:15"],
            "email" => "email",
            "password" => "min:8"
        ]);

        if (!$validation) response()->throwErr(Form::errors());

        $user = Auth::register("users", $credentials, [
            "username", "email"
        ]);

        if (!$user) response()->throwErr(Auth::errors());

        response()->json($user);
    }
}
