<?php

class User extends CI_Controller
{
	/** @var Survey_model */
	public $survey;

	/** @var User_model */
	public $user;

	public function __construct()
	{
		parent::__construct();
		$this->load->model('Survey_model', 'survey', TRUE);
		$this->load->model('User_model', 'user', TRUE);
	}

	function index()
	{
		// TODO: create page
			jump(base_url());
	}

	function view($id_user = NULL)
	{
		$user = $this->user->get_main_user();
		if (is_null($id_user))
		{
			jump(base_url());
		}
		if (!($user_target = $this->user->get_user($id_user)))
		{
			show_404();
		}

		$surveys_maked = $this->survey->get_surveys_user_maked($user_target);
		
		$title = $user_target->screen_name . 'の作成した投票';
		$this->load->view('head', array('title' => $title));
		$this->load->view('title', array('title' => $title, 'offset' => 2));
		$this->load->view('navbar', array('user' => $user));

		$userpage_info = array(
				'surveys_maked' => $surveys_maked,
		);
		$this->load->view('userpage', $userpage_info);

		$this->load->view('foot');

	}
}

