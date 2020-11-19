<?php
namespace App\Controllers;

// this is our model, we import it here to use it below
use App\Models\User;

/**
 * This is an example controller to give you a quick
 *  idea on some of Leaf's features.
 *  Yet, you can directly use Leaf API as a boilerplate with User features
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

    public function register(){
        $username = requestData("username");
        $email = requestData("email");
        $password = requestData("password");

        //you can validate your data with Leaf Form Validation
        $validation = $this->form->validate([
            "username" => "validUsername",
            "email" => "email",
            "password" => "required"
        ]);
        // throws an error if there's an issue in validation
        if (!$validation) $this->throwErr($this->form->errors());

        // direct registration with Leaf Auth. Registers and initiates a login
        // the 3rd parameter makes sure that the same username and email can't be registered multiple times
        $user = $this->auth->register("users", [
            "username" => $username,
            "email" => $email,
            "password" => md5($password)
        ], ["username", "email"]);

        // throw an auth error if there's an issue
        if (!$user) $this->throwErr($this->auth->errors());

        respond($user);
    }

    public function recover_account()
    {
        $username = requestData("email");

        $user = User::where("email", $username)->get()[0] ?? null;
        if (!$user) throwErr(["email" => "Email not found"]);

        //set a temporary random password and reset user password
        $new_password = Str::random(8);
        $user->password = md5($new_password);
        $user->save();

        //send an email to user with the new temporary password
        $mail = new \Leaf\Mail;
        $mail->basic(
            //subject
            "Your Password has been reset", 
            //body
            "This is your new password: ".$password, 
            //recepient email
            $user->email,
            'leaf@api.com'
        );
        $mail->send()
        
        respond(["message" => "ok"]);
    }

    public function reset_password()
    {
        $user_id = $this->auth->useToken() ?? throwErr($this->auth->errors());
        $password = requestData("password");
        //Change the password if logged and type right password
        $user = User::where("user_id", $user_id)->where("password", $password)->get()[0] ?? null;
        if (!$user) throwErr(["message" => "Something went wrong"]);
        //change the user password
        $user->password = md5($password);
        $user->save();

        //login again 
        $user = $this->auth->login("users", [
            "username" => $user->username,
            "password" => $user->password
        ], "md5");
        
        if (!$user) $this->throwErr(["message" => "Something went wrong."]);

        respond($user);
    }

    //get the current user
    public function user(){
        // make sure user is logged in
        $payload = $this->auth->validateToken();
        if (!$payload) $this->throwErr($this->auth->errors());

        $user_id = $payload->user_id;

        respond(User::find($user_id));
    }

    //Edit user data
    public function edit()
    {
        $user_id = $this->auth->useToken() ?? throwErr($this->auth->errors());

        
        $user = User::find($user_id);
        foreach(requestBody() as $item => $value) {
            $user->{$item} = $value;
        }
        $user->save();

        respond($user);
    }
    
}