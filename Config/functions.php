<?php

function Route($methods, $pattern, $fn) {
	global $app;
	$app->match($methods, $pattern, $fn);
}

function App() {
	global $app;
	return $app;
}

function View(string $view, array $data = [], array $mergeData = []) {
	global $app;
	$app->blade->configure(views_path(), storage_path("framework/views"));
	return $app->blade->render($view, $data, $mergeData);
}

function render(string $view, array $data = [], array $mergeData = []) {
	global $app;
	$app->response->renderMarkup(View($view, $data, $mergeData));
}

function respond($data) {
	global $app;
	$app->response->respond($data);
}
