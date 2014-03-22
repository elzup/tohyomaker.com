<?php

class Auth extends CI_Controller
{

	public function __construct()
	{
		parent::__construct();
		session_start();
		$this->config->load('my_twitter');
		$this->load->helper('url');
		$this->load->helper('func');
	}

	function Index()
	{
		$this->start();
	}

	function login()
	{
		$this->start();
	}

	function start()
	{
		$twitter_config = $this->config->item('TWITTER_CONSUMER');
		$_SESSION['consumer_key'] = $twitter_config['key'];
		$_SESSION['consumer_secret'] = $twitter_config['secret'];
		$callback_uri = base_url('/auth/end');

		$connection = new TwitterOAuth($_SESSION['consumer_key'], $_SESSION['consumer_secret']);
		$request_token = $connection->getRequestToken($callback_uri);
		$_SESSION['oauth_token'] = $token = $request_token['oauth_token'];
		$_SESSION['oauth_token_secret'] = $request_token['oauth_token_secret'];


		$auth_url = $connection->getAuthorizeURL($token);

		// save referer to return previous page
		$_SESSION['referer'] = $this->input->server('HTTP_REFERER');
		jump($auth_url);
	}

	function end()
	{
		// TODO: lookup referer and check is come from api.twitter.com
		$connection = new TwitterOAuth($_SESSION['consumer_key'], $_SESSION['consumer_secret'], $_SESSION['oauth_token'], $_SESSION['oauth_token_secret']);
		$access_token = $connection->getAccessToken($_GET['oauth_verifier']);
		unset($_SESSION['oauth_token']);
		unset($_SESSION['oauth_token_secret']);
		$_SESSION['access_token'] = $access_token;
		$ref = $_SESSION['referer'];
		unset($_SESSION['referer']);

		jump($ref ?: base_url());
		exit;
	}

	function logout()
	{
		$_SESSION = array();
		session_destroy();

		$ref = filter_input(INPUT_SERVER, 'HTTP_REFERER');
		jump($ref ?: base_url());
	}
}
