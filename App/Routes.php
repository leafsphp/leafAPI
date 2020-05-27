<?php

/*
|--------------------------------------------------------------------------
| Set up 404 handler
|--------------------------------------------------------------------------
|
| Create a handler for 404 errors
|
*/
$app->set404(function () use ($app) {
	$app->response->respondWithCode([
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

$app->get("/", function() use($app) {
	$app->response->respondWithCode("Welcome to bitcart API v2", 200);
});

$app->mount('/info', function() use($app) {
	$app->get('/', 'InfoController@index');
	$app->get('/addresses', 'InfoController@addresses');
	$app->get('/qr', 'InfoController@qr');
	$app->get('/bank', 'InfoController@bank');
	$app->get('/mobile', 'InfoController@mobile');
	$app->get('/tax', 'InfoController@tax');
});

$app->mount('/auth', function() use($app) {
	$app->post('/login', 'AuthController@login');
	$app->post('/register', 'AuthController@register');
});

$app->mount('/account', function() use($app) {
	$app->get('/', 'AccountController@user');
	$app->get('/verify/{username}', 'AccountController@verifyUsername');
	$app->post('/update', 'AccountController@update');
	$app->post('/update/password', 'AccountController@password');
});

$app->mount('/transactions', function() use($app) {
	$app->get('/', 'TransactionsController@index');
	$app->get('/(\d+)', 'TransactionsController@withLimit');
});

$app->mount('/transaction', function() use($app) {
	$app->get('/(\d+)', 'TransactionsController@transaction');
});
