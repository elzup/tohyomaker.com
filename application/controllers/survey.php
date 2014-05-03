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
		show_404();
	}

	private function _check_post(array $data)
	{
		return isset($data['vote-value']);
	}

	function vote($id_survey = NULL, $select = NULL)
	{
		if (!isset($id_survey))
		{
			// TODO: error action
			show_404();
		}
		$user = $this->user->get_main_user();
		$surveys_hot = $this->survey->get_surveys_hot($user, 5, 0);
		$surveys_new = $this->survey->get_surveys_new($user, 5, 0);

		if (($survey = $this->survey->get_survey($id_survey, $user)) === FALSE)
		{
			show_404();
			// TODO: jump no found page
		}
		// 
		if ($survey->is_voted())
		{
			$select = NULL;
		}

		$meta = new Metaobj();
		$meta->setup_survey($survey);
		$this->load->view('head', array('meta' => $meta, 'survey' => $survey));
		$this->load->view('navbar', array('user' => $user));
		$this->load->view('title', array('title' => $meta->get_title(), 'offset' => 0));
		if ($survey->state != SURVEY_STATE_DELETED)
		{
			$surveyhead_info = array(
					'survey' => $survey,
					'type' => PAGETYPE_VOTE,
			);
			$this->load->view('surveyhead', $surveyhead_info);
			$surveyselectform_info = array(
					'survey' => $survey,
					// is_login so emit token
					'token' => $this->_set_token(),
					'select' => $select,
					'user' => $user,
			);
			$this->load->view('surveyselectform', $surveyselectform_info);
		} else
		{
			$this->load->view('surveydeleted');
		}

		$this->load->view('surveysblock', array('surveys' => $surveys_hot, 'type' => SURVEY_BLOCKTYPE_HOT, 'is_more_btn' => FALSE));
		$this->load->view('surveysblock', array('surveys' => $surveys_new, 'type' => SURVEY_BLOCKTYPE_NEW, 'is_more_btn' => FALSE));
		$this->load->view('foot', array('jss' => array('selectform'), 'user' => $user));
	}

	function view($id_survey = NULL)
	{
		if (!isset($id_survey))
		{
			die('no id_survey');
			// TODO: same as vote method todo
		}
		$user = $this->user->get_main_user();
		$surveys_hot = $this->survey->get_surveys_hot($user, 5, 0);
		$surveys_new = $this->survey->get_surveys_new($user, 5, 0);
		/* @var $survey Surveyobj */
		if (($survey = $this->survey->get_survey($id_survey, $user)) === FALSE)
		{
			die("no found id : {$id_survey}");
			// TODO: same as vote method todo
		}

		$meta = new Metaobj();
		$meta->setup_survey($survey, TRUE);
		$this->load->view('head', array('meta' => $meta));
		$this->load->view('navbar', array('user' => $user));
		$this->load->view('title', array('title' => $meta->get_title(), 'offset' => 0));
		if ($survey->state != SURVEY_STATE_DELETED)
		{
			$surveyhead_info = array(
					'survey' => $survey,
					'type' => PAGETYPE_VIEW,
			);
			$this->load->view('surveyhead', $surveyhead_info);
			$this->load->view('surveyresult', array('survey' => $survey));
			if (isset($survey->results))
			{
				$this->load->view('surveylog', array('survey', $survey));
			}
		} else
		{
			$this->load->view('surveydeleted');
		}
		// TODO: insert surveys parts
		$this->load->view('surveysblock', array('surveys' => $surveys_hot, 'type' => SURVEY_BLOCKTYPE_HOT, 'is_more_btn' => FALSE));
		$this->load->view('surveysblock', array('surveys' => $surveys_new, 'type' => SURVEY_BLOCKTYPE_NEW, 'is_more_btn' => FALSE));
		$this->load->view('foot', array('user' => $user));
	}

	function friend($id_survey = NULL)
	{
		if (!isset($id_survey))
		{
			show_404();
		}
		$user = $this->user->get_main_user();
		$surveys_hot = $this->survey->get_surveys_hot($user, 5, 0);
		$surveys_new = $this->survey->get_surveys_new($user, 5, 0);
		/* @var $survey Surveyobj */
		if (($survey = $this->survey->get_survey($id_survey, $user)) === FALSE)
		{
			show_404();
		}

		$users = $this->user->get_friend_users();
		$users_voted = $this->survey->install_users_select($users, $survey);
		$this->user->install_users_img($users_voted);
		// TODO:

		$meta = new Metaobj();
		$meta->setup_survey($survey, TRUE);
		$this->load->view('head', array('meta' => $meta));
		$this->load->view('navbar', array('user' => $user));
		$this->load->view('title', array('title' => $meta->get_title(), 'offset' => 0));

		if ($survey->state != SURVEY_STATE_DELETED)
		{
			$surveyhead_info = array(
					'survey' => $survey,
					'type' => PAGETYPE_FRIEND,
			);
			$this->load->view('surveyhead', $surveyhead_info);
			$this->load->view('surveyfriend', array('survey' => $survey, 'friends' => $users_voted));
		} else
		{
			$this->load->view('surveydeleted');
		}
		$this->load->view('surveysblock', array('surveys' => $surveys_hot, 'type' => SURVEY_BLOCKTYPE_HOT, 'is_more_btn' => FALSE));
		$this->load->view('surveysblock', array('surveys' => $surveys_new, 'type' => SURVEY_BLOCKTYPE_NEW, 'is_more_btn' => FALSE));
		$this->load->view('foot', array('user' => $user));
	}

	function regist($id_survey = NULL)
	{
		if ($this->input->server('REQUEST_METHOD') != 'POST' || !$this->_check_token() || !$this->_check_post(($post = $this->input->post())) || !isset($id_survey))
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
//		jump_back();
		jump(base_url(PATH_VOTE . '/' . $id_survey));
	}

	function deleting($id_survey = NULL, $token = FALSE)
	{
		if (!isset($id_survey))
		{
			show_404();
		}
		$user = $this->user->get_main_user();
		if (empty($user))
		{
			$this->session->set_userdata(set_alert(ALERT_TYPE_ERROR, CODE_ERROR_ACCESS_NOLOGIN + CODE_PAGE_SURVEY));
			jump(base_url());
		}
		/* @var $survey Surveyobj */
		$survey = $this->survey->get_survey($id_survey, $user);
		if ($survey === FALSE)
		{
			show_404();
		}

		// check $user is $survey's owner
		if ($survey->owner->id !== $user->id || $survey->state == SURVEY_STATE_DELETED)
		{
			jump(base_url($id_survey));
		}

		if (isset($token) && $this->_check_token($token) && $this->survey->delete_survey($survey))
		{
			$this->session->set_userdata(set_alert(ALERT_TYPE_SURVEYDELETED));
			jump(base_url($id_survey));
		}

		$meta = new Metaobj();
		$meta->setup_deleting();
		$this->load->view('head', array('meta' => $meta));
		$this->load->view('navbar', array('user' => $user));
		$this->load->view('title', array('title' => $meta->get_title(), 'offset' => 0));
		$this->load->view('deleting', array('survey' => $survey, 'token' => $this->_set_token()));
		$this->load->view('foot', array('user' => $user));
	}

	private function _set_token()
	{
		$token = sha1(uniqid(mt_rand(), TRUE));
		$this->session->set_userdata(array('token' => $token));
		return $token;
	}

	private function _check_token($token = NULL)
	{
		$token = $token ? : filter_input(INPUT_POST, 'token');
		$token_c = $this->session->userdata('token');
		return !empty($token_c) && $token_c == $token;
	}

}
