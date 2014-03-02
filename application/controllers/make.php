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

		$this->load->model('Survey_model', 'survey', TRUE);
		$this->load->model('User_model', 'user', TRUE);
	}

	public function index()
	{

		/*
		 * view
		 */
		$title = '投票作成';
		$head_info = array(
				'title' => $title,
				'less_name' => 'main',
		);
		$this->load->view('head', $head_info);
		$this->load->view('title', array('title' => $title));
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
		if ($_SERVER['REQUEST_METHOD'] != 'POST')
		{
			// TODO: jump to source page
			echo "jump";
		}
		if (check_token() === FALSE)
		{
			// TODO: token error
			echo "token error";
		}
//		echo "<pre>";
//		var_dump($_POST);
//		exit;

		$title = '投票作成確認';
		$head_info = array(
				'title' => $title,
				'less_name' => 'main',
		);
		$this->load->view('head', $head_info);
		$this->load->view('title', array('title' => $title));
		$this->load->view('navbar', array('user' => $this->user->getUser()));

		$makecheck_info = array(
				'user' => $this->user->getUser(),
				'data' => $_POST,
				'token' => set_token(),
		);
		$this->load->view('makecheck', $makecheck_info);

		$this->load->view('foot');
	}

}
