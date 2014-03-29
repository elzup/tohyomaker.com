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
		$this->load->model('Survey_model', 'survey', TRUE);
		$this->load->model('User_model', 'user', TRUE);
	}

	function index()
	{

		$user = $this->user->get_main_user();
		$surveys_hot = $this->survey->get_surveys_hot(5, 0, @$user->id);
		$surveys_new = $this->survey->get_surveys_new(5, 0, @$user->id);

		$meta = new Metaobj();
		$meta->setup_top();
		$this->load->view('head', array ('meta' => $meta));
		$this->load->view('navbar', array('user' => $user));

		$topmain_info = array(
				'surveys_hot' => $surveys_hot,
				'surveys_new' => $surveys_new,
		);
		$this->load->view('topmain', $topmain_info);

		$this->load->view('foot');
	}
}
