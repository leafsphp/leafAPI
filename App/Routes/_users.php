<?php

$app->get("/leaf", function () {
    respondWithCode("New in v2", 200);
});

//Basic autentication routes
$app->mount("/auth", function() use($app) {
	$app->post("/login", "UsersController@login");
	$app->post("/register", "UsersController@register");
    //Password reset
    $app->post("/reset", "UsersController@reset_password");
	//password reset
    $app->post("/recover", "UsersController@recover_account"); 
});

//User routes
$app->mount("/user", function() use($app) {
    //Get user info
    $app->get("/", "UsersController@user");   
    //Update user info
	$app->post("/update", "UsersController@update");
});