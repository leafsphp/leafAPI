<?php

/*
|--------------------------------------------------------------------------
| Leaf API
|--------------------------------------------------------------------------
|
| Leaf API is a minimal but powerful PHP MVC framework based on
| the Leaf PHP framework for building APIs.
|
| This file allows us to run the app from the root of the project.
| This provides a convenient way to test your Leaf API app
| without having installed a "real" web server software here.
|
| It also allows you to directly load up your application from
| the root file for quickly hosting on shared hosting platforms.
|
*/

$uri = urldecode(
    parse_url($_SERVER['REQUEST_URI'], PHP_URL_PATH)
);

if ($uri !== '/' && file_exists(__DIR__ . '/public' . $uri)) {
    return false;
}

require_once __DIR__ . '/public/index.php';
