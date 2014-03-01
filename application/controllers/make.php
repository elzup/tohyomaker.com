<?php

class Make extends CI_Controller
{

	public function __construct()
	{
		parent::__construct();
		session_start();
		$this->config->load('my_twitter');
		$this->load->helper('url');
		$this->load->helper('func');
		$this->load->helper('token');
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
		$this->load->view('navbar', array('user' => $this->user->getUser()));

		$makeform_info = array(
				'user' => $this->user->getUser(),
				'token' => set_token(),
		);
		$this->load->view('makeform', $makeform_info);

		$this->load->view('foot');
	}

	public function check()
	{
		
	}
}
