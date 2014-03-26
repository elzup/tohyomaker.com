<?php

class User extends CI_Controller
{
	public function __construct()
	{
		parent::__construct();
		session_start();
	}

	function index()
	{
	}

	function main($id_user = NULL)
	{
		var_dump($id_user);
	}
}

