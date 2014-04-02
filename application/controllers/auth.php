<?php

class Auth extends CI_Controller
{

	public function __construct()
	{
		parent::__construct();
		$this->session->unset_userdata('userserial');
	}

	function Index()
	{
		$this->start();
	}

	function login()
	{
		$this->start();
		// save referer to return previous page
/*
 		$this->session->set_userdata(array('referer' => $this->input->server('HTTP_REFERER')));

		$meta = new Metaobj();
		$meta->setup_login();
		$this->load->view('head', array ('meta' => $meta));
		$this->load->view('title', array('title' => $meta->get_title()));
		$this->load->view('navbar', array('user' => $this->user->get_main_user()));

		$makeform_info = array(
				'user' => $this->user->get_main_user(),
				'token' => $this->_set_token(),
		);
		$this->load->view('makeform', $makeform_info);

		$this->load->view('foot', array('jss' => array('makeform')));
 * 
 */
	}

	function start()
	{

 		$this->session->set_userdata(array('referer' => $this->input->server('HTTP_REFERER')));
		$twitter_config = $this->config->item('TWITTER_CONSUMER');
		$this->session->set_userdata(array(
				'consumer_key' => $twitter_config['key'],
				'consumer_secret' => $twitter_config['secret'],
		));
		$callback_uri = base_url(PATH_AUTH_END);

		$connection = new TwitterOAuth($twitter_config['key'], $twitter_config['secret']);
		$request_token = $connection->getRequestToken($callback_uri);
		$token = $request_token['oauth_token'];
		$this->session->set_userdata(array(
				'oauth_token' => $token,
				'oauth_token_secret' => $request_token['oauth_token_secret'],
		));
		$auth_url = $connection->getAuthorizeURL($token);

		jump($auth_url);
	}

	function end()
	{
		// TODO: lookup referer and check is come from api.twitter.com
		$connection = new TwitterOAuth(
				$this->session->userdata('consumer_key'), $this->session->userdata('consumer_secret'), $this->session->userdata('oauth_token'), $this->session->userdata('oauth_token_secret')
		);
		$access_token = $connection->getAccessToken($this->input->get('oauth_verifier'));
		$this->session->unset_userdata('oauth_token');
		$this->session->unset_userdata('oauth_token_secret');
		$this->session->set_userdata(array ('access_token' => $access_token));
		$ref = $this->session->userdata('referer');
		$this->session->unset_userdata('referer');

		$this->session->set_userdata(set_alert(ALERT_TYPE_LOGIN));
		jump($ref ? : base_url());
	}

	function logout()
	{
		$this->session->sess_destroy();
		$ref = filter_input(INPUT_SERVER, 'HTTP_REFERER');

		$this->session->set_userdata(set_alert(ALERT_TYPE_LOGOUT));
		jump($ref ? : base_url());
	}

}
