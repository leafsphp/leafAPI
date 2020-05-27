<?php
namespace App\Controllers;

use Leaf\Http\Request;

class Controller extends \Leaf\ApiController {
	public $request;

	public function __construct() {
		parent::__construct();
		$this->request = new Request;
    }
}