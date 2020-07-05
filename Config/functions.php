<?php
function app() {
	global $app;
	return $app;
}

function d() {
	return app()->date;
}

function markup($data) {
	app()->response->renderMarkup($data);
}

function render(string $view, array $data = [], array $mergeData = []) {
	markup(view($view, $data, $mergeData));
}

function requestBody() {
	return app()->request->body();
}

function requestData($param) {
	return app()->request->get($param);
}

function respond($data) {
	app()->response->respond($data);
}

function respondWithCode($data, $code = 500) {
	app()->response->respondWithCode($data, $code);
}

function Route($methods, $pattern, $fn) {
	app()->match($methods, $pattern, $fn);
}

function sessionBody() {
	return app()->session->body();
}

function sessionGet($param) {
	return app()->session->get($param);
}

function sessionSet($data, $value = null) {
	return app()->session->set($data, $value);
}

function view(string $view, array $data = [], array $mergeData = []) {
	app()->blade->configure(views_path(), storage_path("framework/views"));
	return app()->blade->render($view, $data, $mergeData);
}
