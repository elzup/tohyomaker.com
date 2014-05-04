<?php

class Catalog extends CI_Controller
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
		$this->hot();
	}

	function newp($page = 0)
	{

		// TODO: prepare surveys in survey_model 
		$user = $this->user->get_main_user();
		$surveys = $this->survey->get_surveys_new($user, ONEPAGE_NUM, $page * ONEPAGE_NUM);

		$meta = new Metaobj();
		$meta->setup_catalog_new();
		$this->load->view('head', array('meta' => $meta));
		$this->load->view('navbar', array('user' => $user));
		$this->load->view('title', array('title' => $meta->get_title(), 'offset' => 2));

		$this->load->view('catalognew', array ('surveys' => $surveys));

		$this->load->view('foot', array('user' => $user));
	}

	function hot($page = 0)
	{
		// TODO: get startnum and make multipages 
		$user = $this->user->get_main_user();
		$surveys = $this->survey->get_surveys_hot($user, ONEPAGE_NUM, $page * ONEPAGE_NUM);
		$meta = new Metaobj();
		$meta->setup_catalog_hot();
		$this->load->view('head', array('meta' => $meta));
		$this->load->view('navbar', array('user' => $user));
		$this->load->view('title', array('title' => $meta->get_title(), 'offset' => 2));

		$this->load->view('cataloghot', array ('surveys' => $surveys));

		$this->load->view('foot', array('user' => $user));
	}

}
