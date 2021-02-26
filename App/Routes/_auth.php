<?php

$app->group("/auth", function () use ($app) {
    $app->post("/login", "Auth\LoginController@index");
    $app->post("/register", "Auth\RegisterController@store");
    $app->get("/logout", "Auth\LoginController@logout");
    // Reset and recover account will be added later
});

$app->group("/user", function () use ($app) {
    $app->get("/", "Auth\AccountController@user");
    $app->post("/update", "Auth\AccountController@update");
});
