<?php

class Index extends CI_Controller
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
		$this->load->helper('partsblock');
		$this->load->helper('text');

		$this->load->model('Survey_model', 'survey', TRUE);
		$this->load->model('User_model', 'user', TRUE);
	}

	function index()
	{

		$user = $this->user->get_user();
		$surveys_hot = $this->survey->get_surveys_hot(5, 0, $user->id);
		$surveys_new = $this->survey->get_surveys_new(5, 0, $user->id);

		$title = 'トップページ';
		$this->load->view('head');
//		$this->load->view('title', array('title' => $title, 'offset' => 2));
		$this->load->view('navbar', array('user' => $this->user->get_user()));

		$topmain_info = array(
				'surveys_hot' => $surveys_hot,
				'surveys_new' => $surveys_new,
		);
		$this->load->view('topmain', $topmain_info);

		$this->load->view('foot');
	}
}
