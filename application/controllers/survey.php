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
		$user = $this->user->get_user();
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
		$user = $this->user->get_user();
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
		$this->load->view('surveyresult', array ('survey' => $survey));
		if (isset($survey->results))
		{
			$this->load->view('surveylog', array('survey', $survey));
		}
		// TODO: insert surveys parts
		$this->load->view('foot');
	}

	function regist($id_survey = NULL)
	{
		if ($this->input->server('REQUEST_METHOD') != 'POST' || check_token() === FALSE || !$this->_check_post(($post = $this->input->post())) || !isset($id_survey))
		{
			// TODO: error action
			die('error: not post request, wrong token, wrong postdata');
		}

		$user = $this->user->get_user();
		if (empty($user))
		{
			// TODO: error action
			die('error: not logined');
		}
		/* @var $survey Surveyobj */
		if (($survey = $this->survey->get_survey($id_survey, $user)) === FALSE)
		{
			// TODO: jump no found page
			die("no found id : {$id_survey}");
		}
		$value = $post[POST_VALUE_NAME];
		if ($this->survey->regist_vote($survey, $user, $value) === FALSE)
		{
			var_dump($this->survey->db->message());
			die('failed query');
		}
		// TODO: set cookie
		setcookie("tm_alert_", $value, time() + 60);
		jump(base_url(PATH_VOTE .'/'. $id_survey));
	}

	public function info($id_survey)
	{
		
	}

}
