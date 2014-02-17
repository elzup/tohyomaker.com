<?php

class Index extends CI_Controller
{

	public function __construct()
	{
		parent::__construct();
		echo "this is top page";
	}

	function index()
	{
		echo "TOP PAGE";
		$this->load->database();
		print_r($result);
	}
}
