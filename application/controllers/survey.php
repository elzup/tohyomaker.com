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
		$this->load->helper('parts');

		$this->load->model('Survey_model', 'survey', TRUE);
		$this->load->model('User_model', 'user', TRUE);
	}

	public function Index()
	{
		// TODO: jump vote page
		echo 'index on survey';
	}

	function vote ($id_survey = NULL, $select = NULL)
	{
		if (!isset($id_survey))
		{
			die('no id_survey');
			// TODO: error action
		}
		/* @var $survey SurveyObj */
		if (($survey = $this->survey->get_survey($id_survey)) === FALSE)
		{
			die("no found id : {$id_survey}");
			// TODO: jump no found page
		}
//		echo '<pre>';
//		var_dump($survey);
//		exit;

		$title = $survey->title;
		$head_info = array(
				'title' => $title,
				'less_name' => 'main',
		);
		$this->load->view('head', $head_info);
		$this->load->view('title', array('title' => $title));
		$this->load->view('navbar', array('user' => $this->user->get_user()));
		$surveyhead_info = array(
				'survey' => $survey,
				'type' => 0,
		);
		$this->load->view('surveyhead', $surveyhead_info);
		$surveyselectform_info = array(
				'survey' => $survey,
				'token' => set_token(),
				'select' => $select,
		);
		$this->load->view('surveyselectform', $surveyselectform_info);
		$this->load->view('foot');
	}

	function view($id_survey)
	{
		
	}

	public function info($id_survey)
	{
		
	}

}
