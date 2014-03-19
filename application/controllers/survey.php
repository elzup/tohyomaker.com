<?php

// TODO: move define timing
define('SURVEY_PAGETYPE_VOTE', 0);
define('SURVEY_PAGETYPE_VIEW', 1);

//投票ページ
class Survey extends CI_Controller
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

	public function Index()
	{
		// TODO: jump vote page
		echo 'index on survey';
	}

	private function _check_post(array $data)
	{
		if (empty($data['vote-value']))
		{
			return FALSE;
		}
		return TRUE;
	}

	function vote($id_survey = NULL, $select = NULL)
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
		$user = $this->user->get_user();
		$voted_value = $this->survey->check_voted($survey->id, (isset($user)) ? $user->id : NULL);
		$is_voted = !!$voted_value;
		if ($is_voted)
		{
			$select = $voted_value;
		}

		$title = $survey->title;
		$head_info = array(
				'title' => $title,
		);
		$this->load->view('head', $head_info);
		$this->load->view('title', array('title' => $title, 'offset' => 0));
		$this->load->view('navbar', array('user' => $user));
		$surveyhead_info = array(
				'survey' => $survey,
				'type' => SURVEY_PAGETYPE_VOTE,
		);
		$this->load->view('surveyhead', $surveyhead_info);
		$surveyselectform_info = array(
				'survey' => $survey,
				// is_login so emit token
				'token' => (isset($user) ? set_token() : NULL),
				'select' => $select,
				'is_voted' => $is_voted,
		);
		$this->load->view('surveyselectform', $surveyselectform_info);
		$this->load->view('foot', array('jss' => array('selectform')));
	}

	function view($id_survey = NULL)
	{
		if (!isset($id_survey))
		{
			die('no id_survey');
			// TODO: same as vote method todo
		}
		/* @var $survey SurveyObj */
		if (($survey = $this->survey->get_survey($id_survey, TRUE)) === FALSE)
		{
			die("no found id : {$id_survey}");
			// TODO: same as vote method todo
		}
		$voted_value = $this->survey->check_voted($survey, $this->user->get_user());
//		$is_voted = !!$voted_value;

		$title = $survey->title;
		$head_info = array(
				'title' => $title,
		);
		$this->load->view('head', $head_info);
		$this->load->view('title', array('title' => $title, 'offset' => 0));
		$this->load->view('navbar', array('user' => $this->user->get_user()));
		$surveyhead_info = array(
				'survey' => $survey,
				'type' => SURVEY_PAGETYPE_VIEW,
		);
		$this->load->view('surveyhead', $surveyhead_info);
		$surveyresult_info = array(
				'survey' => $survey,
				'select' => $voted_value,
		);
		$this->load->view('surveyresult', $surveyresult_info);
		if (isset($survey->results))
		{
			$this->load->view('surveylog', array('survey', $survey));
		}
		$this->load->view('foot');
	}

	function regist($id_survey = NULL)
	{
		if (filter_input(INPUT_SERVER, 'REQUEST_METHOD') != 'POST' || check_token() === FALSE || !$this->_check_post(filter_input_array(INPUT_POST)) || !isset($id_survey))
		{
			// TODO: error action
			die('error: not post request, wrong token, wrong postdata');
		}

		/* @var $survey SurveyObj */
		if (($survey = $this->survey->get_survey($id_survey)) === FALSE)
		{
			// TODO: jump no found page
			die("no found id : {$id_survey}");
		}
		$user = $this->user->get_user();
		$value = filter_input(INPUT_POST, 'vote-value');
		if ($this->survey->insert_vote($survey, $user, $value) === FALSE)
		{
			var_dump($this->db->message());
			die('failed query');
		}
		// TODO: set cookie
		setcookie("tm_alert_", $value, time() + 60);
		jump(base_url($id_survey));
	}

	public function info($id_survey)
	{
		
	}

}
