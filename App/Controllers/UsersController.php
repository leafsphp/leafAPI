<?php
namespace App\Controllers;

// This is our model, we import it here to use it below
use App\Models\User;

/**
 * UsersController (Demo)
 * ---------------
 * This is a demo users controller put together to give
 * you an idea on basic features of leaf 
 */
class UsersController extends Controller
{
    public function login()
    {
        // requestData is a shortcut method which allows
        // you get data passed into a request by key name
        // $username = requestData("username");
        // $password = requestData("password");

        // You can also mass assign particular fields from the request 
        list($username, $password) = requestData(["username", "password"], true, true);

        // You can perform operations on your model like this
        $user = User::where("username", $username)->first();

        // auth is initialised in the base controller
        // login allows us to sign a user in, and also generates
        // a jwt automatically
        $user = $this->auth->login("users", [
            "username" => $username,
            "password" => md5($password)
        ]);

        // This line catches any errors that MAY happen
        if (!$user) throwErr($this->auth->errors());

        // json is another global shortcut method
        // it's shorter than $this->json()
        json($user);
    }

    public function register()
    {
        // $username = requestData("username");
        // $email = requestData("email");
        // $password = requestData("password");

        // You can also directly pick vars from the request object
        $credentials = requestData(["username", "email", "password"]);
        $credentials["password"] = md5($credentials["password"]);

        // You can validate your data with Leaf Form Validation
        $validation = $this->form->validate([
            "username" => "validUsername",
            "email" => "email",
            "password" => "required"
        ]);

        // Throws an error if there's an issue in validation
        if (!$validation) throwErr($this->form->errors());

        // Direct registration with Leaf Auth. Registers and initiates a
        // login, so you don't have to call login again, unless you want
        // to. The 3rd parameter makes sure that the same username
        // and email can't be registered multiple times
        $user = $this->auth->register("users", $credentials, [
            "username", "email"
        ]);

        // throw an auth error if there's an issue
        if (!$user) throwErr($this->auth->errors());

        json($user);
    }

    public function recover_account()
    {
        $username = requestData("email");

        $user = User::where("email", $username)->first() ?? null;
        if (!$user) throwErr(["email" => "Email not found"]);

        // Set a temporary random password and reset user password
        $newPassword = rand(00000000, 99999999);
        $user->password = md5($newPassword);
        $user->save();

        // Send an email to user with the new temporary password
        // email() is a global method that allows you to send a
        // quick email. Don't forget to configure your .env variables
        email([
            "subject" => "Your Password has been reset",
            "body" => "This is your new password: $newPassword",
            "recepient_email" => $user->email,
            "sender_name" => "API Name",
        ]);

        json(["message" => "ok"]);
    }

    public function reset_password()
    {
        // useToken retrieves the JWT from the headers, decodes it and returns
        // the user encoded into the token. If there's a problem with the token,
        // we can throw whatever error occurs. This means the user must be logged in.
        $user = $this->auth->useToken() ?? throwErr($this->auth->errors());
        $password = requestData("password");
        $userId = $user["id"];

        // Get the 
        $user = User::find($userId);
        if (!$user) throwErr(["user" => "User not found! Check somewhere..."]);

        // Change the user password
        $user->password = md5($password);
        $user->save();

        // login again to get new token
        $user = $this->auth->login("users", ["id" => $userId]);
        if (!$user) throwErr($this->auth->errors());

        json($user);
    }

    public function user(){
        // Make sure user is logged in
        $user = $this->auth->useToken() ?? throwErr($this->auth->errors());

        json(User::find($user["id"]));
    }

    public function edit()
    {
        $user = $this->auth->useToken() ?? throwErr($this->auth->errors());

        $user = User::find($user["id"]);
        // requestBody returns a key value pair of all items passed into the request
        foreach(requestBody() as $item => $value) {
            $user->{$item} = $value;
        }
        $user->save();

        json($user);
    }
}
