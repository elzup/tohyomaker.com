<?php

class User extends CI_Controller
{
	public function __construct()
	{
		parent::__construct();
		session_start();
		$this->load->model('Survey_model', 'survey', TRUE);
		$this->load->model('User_model', 'user', TRUE);
	}

	function index()
	{
	}
}
