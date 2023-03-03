<?php

namespace App\Controllers;

/**
 * This is the base controller for your Leaf MVC Project.
 * You can initialize packages or define methods here to use
 * them across all your other controllers which extend this one.
 */
class Controller extends \Leaf\Controller
{
    public function __construct()
    {
        parent::__construct();

        // In this version, request isn't initialised for you. You can use
        // request() to get request data or initialise it yourself

        // autoConnect uses the .env variables to quickly connect to db
        // Leaf auth will automagically connect to this db instance
        // Note that you only need to enable this if you didn't
        // already connect to the db in your public/index.php file
        // If you did, you can delete this whole block
        db()->autoConnect();

        // You can configure auth to get additional customizations
        // This can be done here with the auth()->config method or
        // simply in the config/auth.php file
        auth()->config(AuthConfig());

        // You can refer to https://leafphp.dev/modules/auth for auth docs
    }
}
