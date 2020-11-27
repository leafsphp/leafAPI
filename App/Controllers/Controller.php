<?php
namespace App\Controllers;

// Leaf Auth is a package which makes user authentication simple
use Leaf\Auth;

/**
 * This is the base controller for your Leaf API Project.
 * You can initialize packages or define methods here to use
 * them across all your other controllers which extend this one.
 */
class Controller extends \Leaf\ApiController {
	public $auth;

	public function __construct() {
		parent::__construct();

		// In this version, request isn't initialised for you. You can use
		// requestData() to get request data or initialise it yourself
		$this->auth = new Auth;
		$this->auth->autoConnect();
		
		// set default token expiry time
		$this->auth->tokenLifetime(60 * 60 * 24 * 365);

		// You can configure auth to get additional customizations
		$this->auth->config("PASSWORD_ENCODE", function ($password) {
			return md5($password);
		});
    }
}
