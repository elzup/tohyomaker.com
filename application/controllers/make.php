<?php

class Make extends CI_Controller
{

	public function __construct()
	{
		parent::__construct();
		$this->load->model('Survey_model', 'survey', TRUE);
		$this->load->model('User_model', 'user', TRUE);
	}

	public function index()
	{

		// TODO: make no login user action

		/*
		 * view
		 */
		$meta = new Metaobj();
		$meta->setup_top();
		$this->load->view('head', array('meta' => $meta));
		$this->load->view('title', array('title' => $meta->get_title()));
		$this->load->view('navbar', array('user' => $this->user->get_main_user()));

		$post = $this->session->userdata('form_posts');
		$makeform_info = array(
				'user' => $this->user->get_main_user(),
				'post' => $post,
		);
		$this->load->view('makeform', $makeform_info);

		$this->load->view('foot', array('jss' => array('makeform')));
	}

	public function destroy()
	{
		$this->session->unset_userdata('form_posts');
		jump(base_url(PATH_MAKE));
	}

	public function check()
	{
		// TODO: check referrer 
		if ($this->input->server('REQUEST_METHOD') != 'POST')
		{
			jump(base_url(PATH_MAKE));
		}
		// POST REQ format and get in $post
		if (!($post = $this->_check_post($this->input->post())))
		{
			// TODO: set alert flag
			jump_back();
		}

		$meta = new Metaobj();
		$meta->setup_top();
		$this->load->view('head', array('meta' => $meta));
		$this->load->view('title', array('title' => $meta->get_title()));
		$this->load->view('navbar', array('user' => $this->user->get_main_user()));

		$makecheck_info = array(
				'user' => $this->user->get_main_user(),
				'data' => $post,
				'token' => $this->_set_token(),
		);
		$this->load->view('makecheck', $makecheck_info);
		$this->load->view('foot');

		$this->session->set_userdata(array('form_posts' => $post));
	}

	public function regist()
	{
		$post = $this->input->post();
		if ($this->input->server('REQUEST_METHOD') != 'POST' || !$this->_check_token() || !($post = $this->_check_post($this->input->post())))
		{
			jump_back(2);
		}
		$id_survey = $this->survey->regist($post, $this->user->get_main_user());
		$token = $this->_set_token();
		jump(base_url(HREF_TYPE_MAKEEND . "/{$id_survey}/{$token}"));
		// TODO: jump to survey page (use id
	}

	public function end($id_survey = NULL, $token = NULL)
	{
		if (!isset($id_survey) || !isset($token) || !$this->_check_token($token))
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

		$this->session->unset_userdata('form_posts');

		$meta = new Metaobj();
		$meta->setup_top();
		$this->load->view('head', array('meta' => $meta));
		$this->load->view('title', array('title' => $meta->get_title()));
		$this->load->view('navbar', array('user' => $this->user->get_main_user()));

		$this->load->view('makeend', array('survey' => $survey));
		$this->load->view('foot');
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
}
