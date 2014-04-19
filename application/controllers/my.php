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
		$this->voted();
	}


	function voted()
	{
		$user = $this->user->get_main_user();
		if ($user->is_guest)
		{
			jump(base_url());
		}
		$surveys_voted = $this->survey->get_surveys_user_voted($user);

		$meta = new Metaobj();
		$meta->setup_my();
		$this->load->view('head', array('meta' => $meta));
		$this->load->view('navbar', array('user' => $user));
		$this->load->view('title', array('title' => $meta->get_title(), 'offset' => 2));

		$mypage_info = array(
				'user' => $user,
				'surveys' => $surveys_voted,
				'type' => PAGETYPE_VOTED,
		);
		$this->load->view('mypage', $mypage_info);

		$this->load->view('foot');
	}

	function maked() {
		$user = $this->user->get_main_user();
		if ($user->is_guest)
		{
			jump(base_url());
		}
		$surveys_maked = $this->survey->get_surveys_user_maked($user);

		$meta = new Metaobj();
		$meta->setup_my();
		$this->load->view('head', array('meta' => $meta));
		$this->load->view('navbar', array('user' => $user));
		$this->load->view('title', array('title' => $meta->get_title(), 'offset' => 2));

		$mypage_info = array(
				'user' => $user,
				'surveys' => $surveys_maked,
				'type' => PAGETYPE_MAKED,
		);
		$this->load->view('mypage', $mypage_info);

		$this->load->view('foot');
	}

}
