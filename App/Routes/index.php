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
	respondWithCode([
		"data" => "Resource not found",
	], 404);
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

$app->get("/", function () {
	respondWithCode("Congrats!! You're on Leaf API", 200);
});

// From v1.1, you can use this Route method anywhere in your app
// This links to the login method of the UsersController
//Route("POST", "/login", "UsersController@login");

// you can also require an independent route file
require "_users.php";
