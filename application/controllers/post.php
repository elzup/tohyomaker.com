<?php

class Post extends CI_Controller
{

	public function __construct()
	{
		parent::__construct();
	}

	function index()
	{
		echo "start post page\n";
		$this->load->model('Survey_model', 'survey', TRUE);
		$this->survey->
	}
}

