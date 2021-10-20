<?php

namespace App\Controllers\Auth;

use Leaf\Auth;
use Leaf\Form;

class LoginController extends Controller
{
    public function index()
    {
        list($username, $password) = request()->get(["username", "password"], true, true);

        // You can now call leaf form methods statically.
        // Leaf v2.4.2 includes a new rule method which allows you to create
        // your own form rules
        Form::rule("max", function ($field, $value, $params) {
            if (strlen($value) > $params) {
                // add error sets the error which will display when this rule fails
                Form::addError($field, "$field can't be more than $params characters");
                // a rule must return false when it's validation fails
                return false;
            }
        });

        // You can also pass in custom parameters into your
        // form rules. The example below calls the max rule defined
        // above, and replaces the $params variable with 15.
        $validation = Form::validate([
            // To pass a param to a rule, just use :
            "username" => "max:15",
            "password" => "min:8",
        ]);

        // if validation fails, throw the errors
        if (!$validation) response()->throwErr(Form::errors());

        // Simple logins with leaf auth. It takes in the table
        // to search for users in and the credentials to check
        $user = Auth::login("users", [
            "username" => $username,
            "password" => $password
        ]);

        // If user isn't found, show some errors
        if (!$user) response()->throwErr(Auth::errors());

        response()->json($user);
    }

    public function logout()
    {
        // If you use session with your tokens, you
        // might want to remove all the saved data here
        response()->json("Logged out successfully!");
    }
}
