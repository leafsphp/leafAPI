<?php
namespace App\Controllers;

// Leaf Auth is a package which makes user authentication simple
use Leaf\Auth;

/**
 * This is the base controller for your Leaf API Project.
 * You can initialize packages here to use them across
 * all your other controllers which extend this one.
 */
class Controller extends \Leaf\ApiController {
	public $auth;

	public function __construct() {
		parent::__construct();
		// in this version, request isn't initialised for you. You can use
		// requestData to get request data or initialise it yourself
		$this->auth = new Auth;
		$this->auth->auto_connect();
		
		// set default token expiry time
		// $this->auth->tokenLifetime(60 * 60 * 24 * 365);
    }
}
