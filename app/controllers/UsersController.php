<?php
namespace App\Controllers;

// This is our model, we import it here to use it below
use App\Models\User;
use Leaf\Form;
use Leaf\Helpers\Password;

/**
 * UsersController (Demo)
 * ---------------
 * This is a demo users controller put together to give
 * you an idea on basic features of leaf. Each block is commented
 * to help you understand exactly what's going on.
 *
 * Some blocks can be used as alternatives depending on your preference,
 * you can switch to those as you see fit.
 *
 * Although a demo, it's a real controller and works correctly as is.
 * You can always delete this controller or link it to a route if you wish
 * to use it as a reference.
 */
class UsersController extends Controller
{
    // refer to base controller to find package initialization
    // and auth settings
    public function login()
    {
        // You can also mass assign particular fields from the request
        $credentials = request()->get(['username', 'password']);

        // You can perform operations on your model like this
        $user = User::where('username', $credentials['username'])->first();

        // auth is initialised in the base controller
        // login allows us to sign a user in, and also generates
        // a jwt automatically
        $user = auth()->login($credentials);

        // password encoding has been configured in the base controller

        // This line catches any errors that MAY happen
        if (!$user) {
            response()->exit(auth()->errors());
        }

        // We can call json on the response global shortcut method
        response()->json($user);
    }

    public function register()
    {
        // $username = request()->get('username');
        // $fullname = request()->get('fullname');
        // $email = request()->get('email');
        // $password = request()->get('password');

        // You can also directly pick vars from the request object
        $credentials = request()->get(['fullname', 'username', 'email', 'password']);

        // You can validate your data with Leaf Form Validation
        $validation = Form::validate([
            'username' => 'validUsername',
            'fullname' => 'required',
            'email' => 'email',
            'password' => 'required'
        ]);

        // Throws an error if there's an issue in validation
        if (!$validation) response()->exit(Form::errors());

        // Direct registration with Leaf Auth. Registers and initiates a
        // login, so you don't have to call login again, unless you want
        // to. The 3rd parameter makes sure that the same username
        // and email can't be registered multiple times
        $user = auth()->register($credentials, [
            'username', 'email'
        ]);

        // throw an auth error if there's an issue
        if (!$user) {
            response()->exit(auth()->errors());
        }

        response()->json($user);
    }

    public function recover_account()
    {
        $username = request()->get('email');
        $user = User::where('email', $username)->first() ?? null;

        if (!$user) {
            response()->exit(['email' => 'Email not found']);
        }

        // Set a temporary random password and reset user password
        $newPassword = rand(00000000, 99999999);

        // hash new password (uses leaf password helper)
        $user->password = Password::hash($newPassword);
        $user->save();

        // Send an email to user with the new temporary password
        // You can use any email service of your choice.

        // email([
        //     'subject' => 'Your Password has been reset',
        //     'body' => 'This is your new password: $newPassword',
        //     'recepient_email' => $user->email,
        //     'sender_name' => 'API Name',
        // ]);

        response()->json(['message' => 'ok']);
    }

    public function reset_password()
    {
        // id retrieves the JWT from the headers, decodes it and returns
        // the user encoded into the token. If there's a problem with the token,
        // we can throw whatever error occurs. This means the user must be logged in.
        $userId = auth()->id() ?? response()->exit(auth()->errors());
        $password = request()->get('password');

        // Get the current id
        $user = User::find($userId);

        if (!$user) {
            response()->exit(['user' => 'User not found! Check somewhere...']);
        }

        // Change the user password
        $user->password = md5($password);
        $user->save();

        // login again to get new token
        $user = auth()->login(['id' => $userId]);

        if (!$user) {
            response()->exit(auth()->errors());
        }

        response()->json($user);
    }

    public function user() {
        // Make sure user is logged in
        // You can pass in an array of items to
        // hide from the returned user
        $user = auth()->user(['id', 'remember_token', 'password']);

        response()->json($user ?? response()->exit(auth()->errors()));
    }

    public function edit()
    {
        // data to update
        $data = request()->get(['username', 'email', 'password']);

        // update in auth v2 gets the currently authenticated
        // user from the request or session, hence, there's no
        // longer the need to mnually validate the user
        $user = auth()->update($data, [
            'username', 'email'
        ]);

        response()->json($user ?? response()->exit(auth()->errors()));
    }
}
