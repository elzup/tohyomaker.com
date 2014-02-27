<?php

class Make extends CI_Controller
{

	public function __construct()
	{
		parent::__construct();
		$this->load->helper('url');
	}

	public function index() {
		$this->load->model('Survey_model', 'survey', TRUE);
		$this->load->model('User_model', 'user', TRUE);


		/*
		 * view
		 */
		$head_info = array (
				'title' => '投票作成',
				'less_name' => 'main',
		);
		$this->load->view('head', $head_info);
		$this->load->view('navbar');

		$this->load->view('foot');
	}
}
