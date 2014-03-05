<?php

//投票ページ
class Survey extends CI_Controller
{
	/* @var $survey Survey_model */
	/* @var $user Survey_model */

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

	public function Index()
	{
		// TODO: jump vote page
		echo 'index on survey';
	}

	function vote($id_survey)
	{
		echo "<pre>";
		if (($survey = $this->survey->get_survey($id_survey)) === FALSE)
		{
			die("no found id : {$id_survey}");
			// TODO: jump no found page
		}
		print_r($survey);
	}

	function view($id_survey)
	{
		
	}

	public function info($id_survey)
	{
		
	}

}
