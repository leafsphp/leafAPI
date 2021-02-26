<?php

/*
|--------------------------------------------------------------------------
| Set up 404 handler
|--------------------------------------------------------------------------
|
| Create a handler for 404 errors
|
*/
$app->set404(function () {
	json("Resource not found", 404, true);
});

/*
|--------------------------------------------------------------------------
| Set up Controller namespace
|--------------------------------------------------------------------------
|
| This allows you to directly use controller names instead of typing
| the controller namespace first.
|
*/
$app->setNamespace("\App\Controllers");


// $app is the instance of Leaf
$app->get("/", function () {
	json(["message" => "Congrats!! You're on Leaf API"], 200);
});

$app->get("/app", function () {
	// app() returns $app
	json(app()->routes(), 200);
});

// From v1.1, you can use this Route method anywhere in your app
// This links to the login method of the UsersController
// Route("POST", "/login", "UsersController@login");

// You can define your routes here directly or
// import an independent route file

// Example authentication has been created for you to give you
// an idea on working with this version of leaf. To get rid of all
// the comments, simply run php leaf scaffold:auth --api
require __DIR__ . "/_auth.php";