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
		$this->tag();
	}

	function tag()
	{
		$word = filter_input(INPUT_GET, 's');
		if (isset ($word))
		{
			$word = urldecode($word);
		}

		// TODO: prepare surveys in survey_model 
		$user = $this->user->get_user();
		$title = 'タグ検索';
//		$surveys = $this->survey->get_surveys_new(10, $user->id);
		$this->load->view('head', array('title' => $title));
		$this->load->view('title', array('title' => $title, 'offset' => 2));
		$this->load->view('navbar', array('user' => $this->user->get_user()));

		$this->load->view('searchtag', array('word' => $word, 'surveys' => $surveys));

//		$this->load->view('catalognew', array ('surveys' => $surveys));

		$this->load->view('foot');
	}

}


