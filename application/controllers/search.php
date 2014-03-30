<?php

class Search extends CI_Controller
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
		$this->tag();
	}

	function tag($word = NULL)
	{
		$user = $this->user->get_main_user();
		if (!empty($word))
		{
			$word = urldecode($word);
		} else
		{
			$word = filter_input(INPUT_GET, 's');
		}
		$surveys = array();
		if (isset($word))
		{
			$word = urldecode($word);
			$surveys = $this->survey->get_surveys_search_tag($user, $word, 10, 0);
		}

		// TODO: prepare surveys in survey_model 
		$meta = new Metaobj();
		$meta->setup_search_tag($word);
		$this->load->view('head', array('meta' => $meta));
		$this->load->view('title', array('title' => $meta->get_title(), 'offset' => 2));
		$this->load->view('navbar', array('user' => $user));

		$this->load->view('searchtag', array('word' => $word, 'surveys' => $surveys));

//		$this->load->view('catalognew', array ('surveys' => $surveys));

		$this->load->view('foot');
	}

}
