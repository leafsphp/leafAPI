<?php

/*
|--------------------------------------------------------------------------
| Set up 404 handler
|--------------------------------------------------------------------------
|
| Create a handler for 404 errors
|
*/
app()->set404(function () {
	response()->json("Resource not found", 404, true);
});

/*
|--------------------------------------------------------------------------
| Set up 500 handler
|--------------------------------------------------------------------------
|
| Create a handler for error 500
|
*/
app()->setErrorHandler(function ($e = null) {
    if ($e) {
        if (app()->config("log.enabled")) {
            app()->logger()->error($e);
        }
    }

    response()->json("An error occured, our team has been notified", 500, true);
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
app()->setNamespace("\App\Controllers");

// You can break up routes into individual files
require __DIR__ . "/_app.php";
