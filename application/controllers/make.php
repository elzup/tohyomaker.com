<?php

class Make extends CI_Controller
{

	public function __construct()
	{
		parent::__construct();
		session_start();
		$this->load->model('Survey_model', 'survey', TRUE);
		$this->load->model('User_model', 'user', TRUE);
	}

	public function index()
	{

		// TODO: make no login user action
		// TODO: add 'target' param in survey_table

		/*
		 * view
		 */
		$title = '投票作成';
		$head_info = array(
				'title' => $title,
		);
		$this->load->view('head', $head_info);
		$this->load->view('title', array('title' => $title));
		$this->load->view('navbar', array('user' => $this->user->get_user()));

		$makeform_info = array(
				'user' => $this->user->get_user(),
				'token' => set_token(),
		);
		$this->load->view('makeform', $makeform_info);

		$this->load->view('foot', array('jss' => array('makeform')));
	}

	private function _check_post(array $data)
	{
		//
		if (!($data = array_reflect_func($data, 'trim_bothend_space')))
		{
			return FALSE;
		}
		$n = 0;
		for ($i = 1; $i <= 10; $i++)
		{
			if (!empty($data["item{$i}"]))
			{
				$n++;
			}
		}
		if (empty($data['title']) || $n < 2)
		{
			return FALSE;
		}
		return $data;
	}

	public function check()
	{
		// TODO: check referrer 
		if ($this->input->server('REQUEST_METHOD') != 'POST' || !check_token())
		{
			jump(base_url(PATH_MAKE));
		}
		// POST REQ format and get in $post
		if (!($post = $this->_check_post($this->input->post())))
		{
			// TODO: set alert flag
			jump_back();
		}

		$title = '投票作成確認';
		$this->load->view('head', array('title' => $title));
		$this->load->view('title', array('title' => $title));
		$this->load->view('navbar', array('user' => $this->user->get_user()));

		$makecheck_info = array(
				'user' => $this->user->get_user(),
				'data' => $post,
				'token' => set_token(),
		);
		$this->load->view('makecheck', $makecheck_info);
		$this->load->view('foot');
	}

	public function regist()
	{
		$post = $this->input->post();
		if ($this->input->server('REQUEST_METHOD') != 'POST' || !check_token()
				|| !($post = $this->_check_post($this->input->post())))
		{
			jump_back(2);
		}
		$id_survey = $this->survey->regist($post, $this->user->get_user());
		$token = set_token();
		jump(base_url(HREF_TYPE_MAKEEND . "/{$id_survey}/{$token}"));
		// TODO: jump to survey page (use id
	}

	public function end($id_survey = NULL, $token = NULL)
	{
		if (!isset($id_survey) || !isset($token) || check_token($token) === FALSE)
		{
			//TODL: jump to error action
			die('error');
		}

		/* @var $survey Surveyobj */
		if (($survey = $this->survey->get_survey($id_survey)) === FALSE)
		{
			die("no found id : {$id_survey}");
			// TODO: jump no found page
		}

		// TODO: create views
		$title = '投票作成完了';
		$head_info = array(
				'title' => $title,
		);
		$this->load->view('head', $head_info);
		$this->load->view('title', array('title' => $title));
		$this->load->view('navbar', array('user' => $this->user->get_user()));

		$this->load->view('makeend', array('survey' => $survey));
		$this->load->view('foot');
	}

}
