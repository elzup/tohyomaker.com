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
		// TODO: delete session in all page
		$this->load->model('Survey_model', 'survey', TRUE);
		$this->load->model('User_model', 'user', TRUE);
	}

	function index()
	{
		$user = $this->user->get_main_user();
		if (empty($user))
		{
			jump(base_url());
		}
		$surveys_voted = $this->survey->get_surveys_user_voted($user);
		$surveys_maked = $this->survey->get_surveys_user_maked($user);
		
		$title = 'マイページ';
		$this->load->view('head', array('title' => $title));
		$this->load->view('title', array('title' => $title, 'offset' => 2));
		$this->load->view('navbar', array('user' => $user));

		$mypage_info = array(
				'user' => $user,
				'surveys_voted' => $surveys_voted,
				'surveys_maked' => $surveys_maked,
		);
		$this->load->view('mypage', $mypage_info);

		$this->load->view('foot');
	}

}
