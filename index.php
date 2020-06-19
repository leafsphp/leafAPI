<?php
/*
|--------------------------------------------------------------------------
| Register The Auto Loader
|--------------------------------------------------------------------------
|
| Composer provides a convenient, automatically generated class loader
| for our application. We just need to utilize it! We'll require it
| into the script here so that we do not have to worry about the
| loading of any our classes "manually". Feels great to relax.
|
*/
require_once __DIR__ . '/vendor/autoload.php';

/*
|--------------------------------------------------------------------------
| Register The Leaf Auto Loader
|--------------------------------------------------------------------------
|
| Require all Leaf's Files
|
*/
require __DIR__. "/Config/bootstrap.php";

/*
|--------------------------------------------------------------------------
| Initialise Leaf Core
|--------------------------------------------------------------------------
|
| Plant a seed, grow the stem and return Leaf🤷‍
|
*/
$app = new Leaf\App;

/*
|--------------------------------------------------------------------------
| Default fix for CORS
|--------------------------------------------------------------------------
|
| This just prevents the connection client from throwing
| CORS errors at you. You can delete or make them more specific.
|
*/
header("Access-Control-Allow-Origin: *");
header("Access-Control-Allow-Headers: *");

/*
|--------------------------------------------------------------------------
| Route Config
|--------------------------------------------------------------------------
|
| Require app routes
|
*/
require __DIR__. "/App/Routes.php";

/*
|--------------------------------------------------------------------------
| Run Leaf Application
|--------------------------------------------------------------------------
|
| Require app routes
|
*/
$app->run();
