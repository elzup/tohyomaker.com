<?php

class Make extends CI_Controller
{

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

	public function index()
	{

		/*
		 * view
		 */
		$title = '投票作成';
		$head_info = array(
				'title' => $title,
				'less_name' => 'main',
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

	private function check_post(array $data)
	{
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
		return TRUE;
	}

	public function check()
	{
		if (filter_input(INPUT_SERVER, 'REQUEST_METHOD') != 'POST' || check_token() === FALSE || !$this->check_post(filter_input_array(INPUT_POST)))
		{
			// TODO: jump to source page
			echo "jump or token error or valieable";
		}

		$title = '投票作成確認';
		$head_info = array(
				'title' => $title,
				'less_name' => 'main',
		);
		$this->load->view('head', $head_info);
		$this->load->view('title', array('title' => $title));
		$this->load->view('navbar', array('user' => $this->user->get_user()));

		$makecheck_info = array(
				'user' => $this->user->get_user(),
				'data' => filter_input_array(INPUT_POST),
				'token' => set_token(),
		);
		$this->load->view('makecheck', $makecheck_info);
		$this->load->view('foot');
	}

	public function regist()
	{
		if (filter_input(INPUT_SERVER, 'REQUEST_METHOD') != 'POST' || check_token() === FALSE || !$this->check_post(filter_input_array(INPUT_POST)))
		{
			// TODO: jump to source page
			echo "jump or token error";
		}
		$id_survey = $this->survey->regist(filter_input_array(INPUT_POST), $this->user->get_user());
		$token = set_token();
		jump(base_url("make/end/{$id_survey}/{$token}"));

		// TODO: jump to survey page (use id
	}

	public function end($id_survey = NULL, $token = NULL)
	{
		// TODO: reset
//		if (!isset($id_survey) || !isset($token) || check_token($token) === FALSE)
		if (!isset($id_survey))
		{
			//TODL: jump to error action
			die('error');
		}

		/* @var $survey SurveyObj */
		if (($survey = $this->survey->get_survey($id_survey)) === FALSE)
		{
			die("no found id : {$id_survey}");
			// TODO: jump no found page
		}

		// TODO: create views
		$title = '投票作成完了';
		$head_info = array(
				'title' => $title,
				'less_name' => 'main',
		);
		$this->load->view('head', $head_info);
		$this->load->view('title', array('title' => $title));
		$this->load->view('navbar', array('user' => $this->user->get_user()));

		$this->load->view('makeend', array('survey' => $survey));
		$this->load->view('foot');
	}
}
