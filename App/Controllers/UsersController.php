<?php
namespace App\Controllers;

// this is our model, we import it here to use it below
use App\Models\User;

/**
 * This is an example controller to give you a quick
 *  idea on some of Leaf's features
 */
class UsersController extends Controller {
    public function login() {
        // requestData is a shortcut method which allows
        // you get data passed into a request by key name
        $username = requestData("username");
        $password = requestData("password");

        // you can perform operations on your model like this
        $user = User::where("username", "username here")->get();

        // auth is initialised in the base controller
        // login allows us to sign a user in
        $user = $this->auth->login("users", [
            "username" => $username,
            "password" => md5($password)
        ]);
        // this line catches any errors that MAY happen
        if (!$user) $this->throwErr($this->auth->errors());

        // respond is another global shortcut method
        // it's shorter than $this->respond()
        respond($user);
    }
}