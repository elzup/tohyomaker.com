<?php

class My extends CI_Controller
{

	/** @var Survey_model */
	public $survey;

	/** @var User_model */
	public $user;

	public function __construct()
	{
		parent::__construct();
		session_start();
		$this->config->load('my_twitter');
		$this->load->helper('url');
		$this->load->helper('func');
		$this->load->helper('token');
		$this->load->helper('alert');
		$this->load->helper('parts');
		$this->load->helper('text');

		$this->load->model('Survey_model', 'survey', TRUE);
		$this->load->model('User_model', 'user', TRUE);
	}

	function index()
	{
		$surveys = $this->survey->get_surveys_user_voted($this->user->get_user());
		
		$title = 'マイページ';
		$head_info = array(
				'title' => $title,
		);
		$this->load->view('head', $head_info);
		$this->load->view('title', array('title' => $title, 'offset' => 2));
		$this->load->view('navbar', array('user' => $this->user->get_user()));

		$this->load->view('mypage', array('surveys' => $surveys, 'user' => $this->user->get_user()));

		$this->load->view('foot');
	}

}
