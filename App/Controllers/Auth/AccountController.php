<?php

namespace App\Controllers\Auth;

use Leaf\Auth;

class AccountController extends Controller
{
    public function user()
    {
        // The second parameter holds items to hide from the user array.
        $user = Auth::user("users", ["password"]);

        if (!$user) response()->throwErr(Auth::errors());

        response()->json($user);
    }

    public function update()
    {
        $userId = Auth::id();

        // request::try attempts to retrieve the data passed into it
        // but unsets the data key if no value is found.
        $data = request()->try(["username", "email", "name"]);
        $where = ["id" => $userId];
        $uniques = ["username", "email"];

        // This section removes all uniques not found in request
        foreach ($uniques as $key => $unique) {
            if (!isset($data[$unique])) {
                unset($uniques[$key]);
            }
        }

        $user = Auth::update("users", $data, $where, $uniques);

        if (!$user) response()->throwErr(Auth::errors());

        response()->json($user);
    }
}
