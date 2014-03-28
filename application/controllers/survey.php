<?php

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
		return isset($data['vote-value']);
	}

	function vote($id_survey = NULL, $select = NULL)
	{
		if (!isset($id_survey))
		{
			die('no id_survey');
			// TODO: error action
		}
		$user = $this->user->get_main_user();
		if (($survey = $this->survey->get_survey($id_survey, $user)) === FALSE)
		{
			die("no found id : {$id_survey}");
			// TODO: jump no found page
		}
		// 
		if ($survey->is_voted())
		{
			$select = NULL;
		}

		$title = $survey->title;
		$head_info = array(
				'title' => $title,
				'url' => $url = '',
				'survey' => $survey,
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
				'token' => (isset($user) ? $this->_set_token() : NULL),
				'select' => $select,
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
		$user = $this->user->get_main_user();
		/* @var $survey Surveyobj */
		if (($survey = $this->survey->get_survey($id_survey, $user)) === FALSE)
		{
			die("no found id : {$id_survey}");
			// TODO: same as vote method todo
		}

		$title = $survey->title;
		$this->load->view('head', array('title' => $title));
		$this->load->view('title', array('title' => $title, 'offset' => 0));
		$this->load->view('navbar', array('user' => $user));
		$surveyhead_info = array(
				'survey' => $survey,
				'type' => SURVEY_PAGETYPE_VIEW,
		);
		$this->load->view('surveyhead', $surveyhead_info);
		$this->load->view('surveyresult', array('survey' => $survey));
		if (isset($survey->results))
		{
			$this->load->view('surveylog', array('survey', $survey));
		}
		// TODO: insert surveys parts
		$this->load->view('foot');
	}

	function regist($id_survey = NULL)
	{
		if ($this->input->server('REQUEST_METHOD') != 'POST' || !$this->_check_token()
				|| !$this->_check_post(($post = $this->input->post())) || !isset($id_survey))
		{
			// TODO: error action
			$this->session->set_userdata(set_alert(ALERT_TYPE_ERROR, CODE_ERROR_REQUEST + CODE_PAGE_SURVEY));
			jump(base_url());
		}

		$user = $this->user->get_main_user();
		if (empty($user))
		{
			$this->session->set_userdata(set_alert(ALERT_TYPE_ERROR, CODE_ERROR_ACCESS_NOLOGIN + CODE_PAGE_SURVEY));
			jump(base_url());
		}
		/* @var $survey Surveyobj */
		if (($survey = $this->survey->get_survey($id_survey, $user)) === FALSE)
		{
			jump(base_url());
		}
		$value = $post[POST_VALUE_NAME];
		if ($this->survey->regist_vote($survey, $user, $value) === FALSE)
		{
			// TODO: set alert. failed
			$this->session->set_userdata(set_alert(ALERT_TYPE_ERROR, CODE_ERROR_DB + CODE_PAGE_SURVEY));
			$user->count_vote++;
			$this->user->inclement_user_votecount($user->id, $user->count_vote);
		} else
		{
			// TODO: if just vote, plus1 message 
			$this->session->set_userdata(set_alert(ALERT_TYPE_VOTED));
		}
		jump(base_url(PATH_VOTE . '/' . $id_survey));
	}

	private function _set_token()
	{
		$token = sha1(uniqid(mt_rand(), TRUE));
		$this->session->set_userdata(array ('token' => $token));
		return $token;
	}

	private function _check_token($token = NULL)
	{
		$token = $token ?: filter_input(INPUT_POST, 'token');
		$token_c = $this->userdata('token');
		return !empty($token_c) && $token_c != $token;
	}
}
