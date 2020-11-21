<?php
if (!function_exists('app')) {
	function app()
	{
		global $app;
		return $app;
	}
}

if (!function_exists('d')) {
	function d()
	{
		return app()->date;
	}
}

if (!function_exists('dbRow')) {
	function dbRow($table, $row_id, $columns = "*")
	{
		app()->db->auto_connect();
		return app()->db->select($table, $columns)->where("id", $row_id)->fetchAll();
	}
}

if (!function_exists('email')) {
	function email(array $email)
	{
		$mail = new \Leaf\Mail;
		if (getenv("MAIL_DRIVER") === "smtp") {
			$mail->smtp_connect(
				getenv("MAIL_HOST"),
				getenv("MAIL_PORT"),
				!getenv("MAIL_USERNAME") ? false : true,
				getenv("MAIL_USERNAME") ?? null,
				getenv("MAIL_PASSWORD") ?? null,
				getenv("MAIL_ENCRYPTION") ?? "STARTTLS"
			);
		}
		$mail->write($email)->send();
	}
}

if (!function_exists('fs')) {
	function fs()
	{
		return app()->fs;
	}
}

if (!function_exists('json')) {
	/**
	 * json uses Leaf's now `json` method
	 * 
	 * json() packs in a bunch of functionality and customization into one method
	 * 
	 * @param array|string|object $data The data to output
	 * @param int $code HTTP Status code for response, it's set in header
	 * @param bool $showCode Show response code in response body?
	 * @param bool $useMessage Show code meaning instead of int in response body?
	 */
	function json($data, int $code = 200, bool $showCode = false, bool $useMessage = false)
	{
		app()->response()->json($data, $code, $showCode, $useMessage);
	}
}

if (!function_exists('markup')) {
	function markup($data)
	{
		app()->response()->markup($data);
	}
}

if (!function_exists('plural')) {
	function plural($value, $count = 2)
	{
		return Leaf\Str::plural($value, $count);
	}
}

if (!function_exists('render')) {
	function render(string $view, array $data = [], array $mergeData = [])
	{
		markup(view($view, $data, $mergeData));
	}
}

if (!function_exists('requestBody')) {
	function requestBody($safeOutput = true)
	{
		return app()->request()->body($safeOutput);
	}
}

if (!function_exists('requestData')) {
	function requestData($param, $safeOutput = true, $assoc = false)
	{
		$data = app()->request()->get($param, $safeOutput);
		return $assoc && is_array($data) ? array_values($data) : $data;
	}
}

if (!function_exists('respond')) {
	/**
	 * Output neatly parsed json [DEPRECATION WARNING: USE `json()` INSTEAD]
	 */
	function respond($data)
	{
		app()->response()->respond($data);
	}
}

if (!function_exists('respondWithCode')) {
	/**
	 * Output json encoded data with an HTTP code/message [DEPRECATION WARNING: USE `json()` INSTEAD]
	 */
	function respondWithCode($data, $code = 200, bool $useMessage = false)
	{
		app()->response()->respondWithCode($data, $code, $useMessage);
	}
}

if (!function_exists('Route')) {
	function Route($methods, $pattern, $fn)
	{
		app()->match($methods, $pattern, $fn);
	}
}

if (!function_exists('setHeader')) {
	function setHeader($key, $value = "", $replace = true, $code = 200)
	{
		app()->headers()->set($key, $value, $replace, $code);
	}
}

if (!function_exists('singular')) {
	function singular($value)
	{
		return Leaf\Str::singular($value);
	}
}

if (!function_exists('throwErr')) {
	function throwErr($error, int $code = 200, bool $useMessage = false)
	{
		app()->response()->throwErr($error, $code, $useMessage);
	}
}

if (!function_exists('view')) {
	function view(string $view, array $data = [], array $mergeData = [])
	{
		app()->blade->configure(views_path(), storage_path("framework/views"));
		return app()->blade->render($view, $data, $mergeData);
	}
}
