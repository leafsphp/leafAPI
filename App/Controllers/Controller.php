<?php
namespace App\Controllers;

use Leaf\Http\Request;

/**
 * This is the base controller for your Leaf API Project.
 * You can initialize packages here to use them across
 * all your other controllers which extend this one.
 */
class Controller extends \Leaf\ApiController {
	public $request;

	public function __construct() {
		parent::__construct();
		$this->request = new Request;
    }
}